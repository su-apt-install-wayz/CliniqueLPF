<?php 

// $insert_prevenir = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
// $insert_prevenir->execute(array($nom_prevenir, $prenom_prevenir, $tel_prevenir, $adresse_prevenir));

// $insert_confiance = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
// $insert_confiance->execute(array($nom_confiance, $prenom_confiance, $tel_confiance, $adresse_confiance));

// $insert_patient = $DB->prepare("INSERT INTO patient VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// $insert_patient->execute(array($num_secu, $civilite, $nom_naissance, $nom_epouse, $prenom, $date_naissance, $adresse, $CP, $tel, $ville, $email, 0, $code_prevenir['code_contact'], $code_confiance['code_contact']));

// $insert_admission = $DB->prepare("INSERT INTO clinique.hospitalisation (Date_hospitalisation, Pre_admission, Heure_intervention, code_personnel, Num_secu) VALUES(?, ?, ?, ?, ?);");
// $insert_admission->execute(array($date_hospitalisation, $pre_admission, $heure_intervention, $medecin['Code_personnel'], $_SESSION['patient'][0]));

// $insert_couverture = $DB->prepare("INSERT INTO clinique.secu (Num_secu, organisme, assure, Ald, Nom_mutuelle, num_adherent, chambre_particuliere) VALUES(?, ?, ?, ?, ?, ?, ?);");
// $insert_couverture->execute(array($_SESSION['patient'][0], $orga_secu, $assure, $ALD, $nom_mutuelle, $num_adherent, $chambre));


// $patient_update = $DB->prepare("UPDATE clinique.patient SET Civilité=?, Nom_Naissance=?, Nom_Epouse=?, Prenom=?, Date_naissance=?, Adresse=?, Code_postal=?, Téléphone=?, Ville=?, Email=?, Mineur=0, code_prevenir=?, code_confiance=? WHERE Num_secu=$num_secu;");
// $patient_update->execute(array($civilite, $nom_naissance, $nom_epouse, $prenom, $date_naissance, $adresse, $CP, $tel, $ville, $email, $code_prevenir['Code_contact'], $code_confiance['Code_contact']));
    



    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    // var_dump($_SESSION['patient']);
    // var_dump($_SESSION['prevenir']);
    // var_dump($_SESSION['confiance']);
    // var_dump($_SESSION['hospitalisation']);
    // var_dump($_SESSION['couverture']);

    if(!empty($_POST)) {
        extract($_POST);

        $valid = true;
            
        $num_secu = $_SESSION['patient'][0];
            
        if(isset($_FILES['carte_id']) && !empty($_FILES['carte_id']['name']) && isset($_FILES['carte_vitale']) && !empty($_FILES['carte_vitale']['name']) && isset($_FILES['carte_mutuelle']) && !empty($_FILES['carte_mutuelle']['name'])) {
            $filename_petit = $_FILES['carte_id']['tmp_name'];

            $extensionValides = array('jpg', 'png', 'jpeg');


            $extensionUpload_CNI = strtolower(substr(strrchr($_FILES['carte_id']['name'], '.'), 1));
            $extensionUpload_CV = strtolower(substr(strrchr($_FILES['carte_vitale']['name'], '.'), 1));
            $extensionUpload_CM = strtolower(substr(strrchr($_FILES['carte_mutuelle']['name'], '.'), 1));
            $extensionUpload_livret = strtolower(substr(strrchr($_FILES['carte_mutuelle']['name'], '.'), 1));

                if(in_array($extensionUpload_CNI, $extensionValides) && in_array($extensionUpload_CV, $extensionValides) && in_array($extensionUpload_CM, $extensionValides)) {
                    $dossier_CNI = '../images/private/patients/';
                    $dossier_CV = '../images/private/patients/';
                    $dossier_CM = '../images/private/patients/';

                    $img_CNI = $num_secu . '_cni.' . $extensionUpload_CNI;
                    $img_CV = $num_secu . '_cv.' . $extensionUpload_CV;
                    $img_CM = $num_secu . '_cm.' . $extensionUpload_CM;
                        
                    $chemin_CNI = $dossier_CNI . $img_CNI;
                    $chemin_CV = $dossier_CV . $img_CV;
                    $chemin_CM = $dossier_CM . $img_CM;

                    $resultat_CNI = move_uploaded_file($_FILES['carte_id']['tmp_name'], $chemin_CNI);
                    $resultat_CV = move_uploaded_file($_FILES['carte_vitale']['tmp_name'], $chemin_CV);
                    $resultat_CM = move_uploaded_file($_FILES['carte_mutuelle']['tmp_name'], $chemin_CM);

                }

                if(is_readable($chemin_CNI) && is_readable($chemin_CV) && is_readable($chemin_CM)) {

                    $insert_files = $DB->prepare("INSERT INTO piece_jointe (Carte_identité, Carte_vitale, Carte_mutuelle, Num_secu)  VALUES (?, ?, ?, ?);");
                    $insert_files->execute(array($img_CNI, $img_CV, $img_CM, $num_secu));
                    $valid = true;
                } else {
                    $valid = false;
                }
            }

        header('Location: patient');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= $_SESSION['personnel'][1]?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
          
        <div class="level">
            <div class="lvl1">
                <div class="bulle bulle-passe"><p>1</p></div>
                <div class="bulle-texte texte-passe"><p>PATIENT</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl2">
                <div class="bulle 2 bulle-passe"><p>2</p></div>
                <div class="bulle-texte texte-passe"><p>HOSPITALISATION</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl3">
                <div class="bulle 3 bulle-passe"><p>3</p></div>
                <div class="bulle-texte texte-passe"><p>COUVERTURE SOCIALE</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl4">
                <div class="bulle 4 active-bulle"><p>4</p></div>
                <div class="bulle-texte active-texte"><p>DOCUMENTS</p></div>
            </div>
        </div>


        <form action="" method="post" enctype="multipart/form-data">
            <label class="file" for="carte_id"><span>Carte d'identité (recto/verso) :</span>
                <input name="carte_id" type="file" id="carte_id" required="required">
            </label>

            <label class="file" for="carte_vitale"><span>Carte vitale :</span>
                <input name="carte_vitale" type="file" id="carte_vitale" required="required">
            </label>

            <label class="file" for="carte_mutuelle"><span>Carte de mutuelle :</span>
                <input name="carte_mutuelle" type="file" id="carte_mutuelle" required="required">
            </label>
                    
            <?php
                if($_SESSION['patient'][11]==1) {
            ?>
                <label class="file" for="livret"><span>Livret de famille :</span>
                    <input name="livret" type="file" id="livret" required="required">
                </label>
            <?php
                }
            ?>

            <input name="submit" class="btn-envoi" value="Enregister l'admission" type="submit">
        </form>
    </section>
    
</body>
</html>