<?php 

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = '';

    // var_dump($_SESSION['patient']);
    // var_dump($_SESSION['prevenir']);
    // var_dump($_SESSION['confiance']);
    // var_dump($_SESSION['hospitalisation']);
    // var_dump($_SESSION['couverture']);

    if(!empty($_POST)) {
        extract($_POST);

        if(isset($_POST['submit'])) {

            $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=?");
            $code_prevenir->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3]));
            $code_prevenir = $code_prevenir->fetch();

            $code_confiance = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=?");
            $code_confiance->execute(array($_SESSION['confiance'][1], $_SESSION['confiance'][2], $_SESSION['confiance'][3]));
            $code_confiance = $code_confiance->fetch();

            if ($_SESSION['prevenir'][1] == $_SESSION['confiance'][1] && $_SESSION['prevenir'][2] == $_SESSION['confiance'][2] && $_SESSION['prevenir'][3] == $_SESSION['confiance'][3]) {
                if(isset($code_prevenir['code_contact'])) {
                    $prevenir_update = $DB->prepare("UPDATE contact SET Nom=?, Prenom=?, Téléphone=?, Adresse=? WHERE code_contact=?;");
                    $prevenir_update->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3], $_SESSION['prevenir'][4], $_SESSION['prevenir'][0]));
                }
    
                else {
                    $insert_prevenir = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
                    $insert_prevenir->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3], $_SESSION['prevenir'][4]));
                }
            }

            else {
                if(isset($code_prevenir['code_contact'])) {
                    $prevenir_update = $DB->prepare("UPDATE contact SET Nom=?, Prenom=?, Téléphone=?, Adresse=? WHERE code_contact=?;");
                    $prevenir_update->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3], $_SESSION['prevenir'][4], $code_prevenir['code_contact']));
                }
    
                else {
                    $insert_prevenir = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
                    $insert_prevenir->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3], $_SESSION['prevenir'][4]));
                }
    
                if(isset($code_confiance['code_contact'])) {
                    $confiance_update = $DB->prepare("UPDATE contact SET Nom=?, Prenom=?, Téléphone=?, Adresse=? WHERE code_contact=?;");
                    $confiance_update->execute(array($_SESSION['confiance'][1], $_SESSION['confiance'][2], $_SESSION['confiance'][3], $_SESSION['confiance'][4], $code_confiance['code_contact']));
                }
    
                else {
                    $insert_confiance = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
                    $insert_confiance->execute(array($_SESSION['confiance'][1], $_SESSION['confiance'][2], $_SESSION['confiance'][3], $_SESSION['confiance'][4]));
                }
            }

            if($_SESSION['patient'][14]==true) {
                $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=?");
                $code_prevenir->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3]));
                $code_prevenir = $code_prevenir->fetch();

                $code_confiance = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=?");
                $code_confiance->execute(array($_SESSION['confiance'][1], $_SESSION['confiance'][2], $_SESSION['confiance'][3]));
                $code_confiance = $code_confiance->fetch();

                $patient_update = $DB->prepare("UPDATE patient SET Civilité=?, Nom_Naissance=?, Nom_Epouse=?, Prenom=?, Date_naissance=?, Adresse=?, Code_postal=?, Téléphone=?, Ville=?, Email=?, Mineur=?, code_prevenir=?, code_confiance=? WHERE Num_secu=?;");
                $patient_update->execute(array($_SESSION['patient'][1], $_SESSION['patient'][2], $_SESSION['patient'][3], $_SESSION['patient'][4], $_SESSION['patient'][5], $_SESSION['patient'][6], $_SESSION['patient'][7], $_SESSION['patient'][8], $_SESSION['patient'][9], $_SESSION['patient'][10], $_SESSION['patient'][11], $code_prevenir['code_contact'], $code_confiance['code_contact'], $_SESSION['patient'][0]));
            }

            else {
                $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=?");
                $code_prevenir->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3]));
                $code_prevenir = $code_prevenir->fetch();

                $code_confiance = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=?");
                $code_confiance->execute(array($_SESSION['confiance'][1], $_SESSION['confiance'][2], $_SESSION['confiance'][3]));
                $code_confiance = $code_confiance->fetch();
                
                $insert_patient = $DB->prepare("INSERT INTO patient VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_patient->execute(array($_SESSION['patient'][0], $_SESSION['patient'][1], $_SESSION['patient'][2], $_SESSION['patient'][3], $_SESSION['patient'][4], $_SESSION['patient'][5], $_SESSION['patient'][6], $_SESSION['patient'][7], $_SESSION['patient'][8], $_SESSION['patient'][9], $_SESSION['patient'][10], $_SESSION['patient'][11], $code_prevenir['code_contact'], $code_confiance['code_contact']));
            }

            $code_personnel = $DB->prepare("SELECT * FROM personnel WHERE Nom = ?");
            $code_personnel->execute(array($_SESSION['hospitalisation'][3]));
            $code_personnel = $code_personnel->fetch();
            
            $insert_admission = $DB->prepare("INSERT INTO hospitalisation (Date_hospitalisation, Pre_admission, Heure_intervention, code_personnel, Num_secu, statut) VALUES(?, ?, ?, ?, ?, 'A faire');");
            $insert_admission->execute(array($_SESSION['hospitalisation'][1], $_SESSION['hospitalisation'][0], $_SESSION['hospitalisation'][2], $code_personnel['Code_personnel'], $_SESSION['patient'][0]));

            if($_SESSION['couverture'][6]==true) {
                $update_couverture = $DB->prepare("UPDATE secu SET organisme=?, assure=?, Ald=?, Nom_mutuelle=?, num_adherent=?, chambre_particuliere=? WHERE Num_secu=?");
                $update_couverture->execute(array($_SESSION['couverture'][0], $_SESSION['couverture'][1], $_SESSION['couverture'][2], $_SESSION['couverture'][3], $_SESSION['couverture'][4], $_SESSION['couverture'][5], $_SESSION['patient'][0]));
            }

            else {
                $insert_couverture = $DB->prepare("INSERT INTO clinique.secu (Num_secu, organisme, assure, Ald, Nom_mutuelle, num_adherent, chambre_particuliere) VALUES(?, ?, ?, ?, ?, ?, ?);");
                $insert_couverture->execute(array($_SESSION['patient'][0], $_SESSION['couverture'][0], $_SESSION['couverture'][1], $_SESSION['couverture'][2], $_SESSION['couverture'][3], $_SESSION['couverture'][4], $_SESSION['couverture'][5]));
            }

        }


        $valid = true;
            
        $num_secu = $_SESSION['patient'][0];

        if($_SESSION['patient'][11]==1) {
            if(isset($_FILES['livret']) && !empty($_FILES['livret'])) {
                $extensionValides = array('jpg', 'png', 'jpeg', 'pdf');

                $extensionUpload_livret = strtolower(substr(strrchr($_FILES['livret']['name'], '.'), 1));

                if(in_array($upload_livret, $extensionValides)) {

                    $dossier = '../images/private/patients/'.$_SESSION['patient'][0].'/';

                    if(!is_dir($dossier)) {
                        mkdir($dossier);
                    }
                
                    $img_livret = $num_secu . '_livret.' . $extensionUpload_livret;

                    $chemin_livret = $dossier . $img_livret;

                    $resultat_livret = move_uploaded_file($_FILES['livret']['tmp_name'], $chemin_livret);

                    if(is_readable($chemin_livret)) {
                        $valid = true;
                    } else {
                        $valid = false;
                    }
                }
                else {
                    $valid = false;
                    $erreur = '<ul class="notifications">
                    <li class="toast error">
                        <div class="column">
                            <span class="material-icons-round icon-notif">error</span>
                            <span class="message-notif">Mauvais format de fichier</span>
                        </div>
                        <span class="material-icons-outlined icon-notif close" onclick="remove()">close</span>
                    </li>
                </ul>
                <script>
                    const toast = document.querySelector(".toast");

                    function hideToast() {
                        setTimeout(function() {
                            toast.classList.add("hide")
                        }, 5000);
                    }

                    function remove() {
                        toast.classList.add("hide");
                    }

                    hideToast();
                </script>';
                }
            }
            else {
                $valid = false;
            }
        } 
        else {
            $img_livret = 'none';
        }
            


        if(isset($_FILES['carte_id']) && !empty($_FILES['carte_id']['name']) && isset($_FILES['carte_vitale']) && !empty($_FILES['carte_vitale']['name']) && isset($_FILES['carte_mutuelle']) && !empty($_FILES['carte_mutuelle']['name'])) {
            $filename_petit = $_FILES['carte_id']['tmp_name'];

            $extensionValides = array('jpg', 'png', 'jpeg');


            $extensionUpload_CNI = strtolower(substr(strrchr($_FILES['carte_id']['name'], '.'), 1));
            $extensionUpload_CV = strtolower(substr(strrchr($_FILES['carte_vitale']['name'], '.'), 1));
            $extensionUpload_CM = strtolower(substr(strrchr($_FILES['carte_mutuelle']['name'], '.'), 1));

            if(in_array($extensionUpload_CNI, $extensionValides) && in_array($extensionUpload_CV, $extensionValides) && in_array($extensionUpload_CM, $extensionValides)) {
                $dossier = '../images/private/patients/'.$_SESSION['patient'][0].'/';

                if(!is_dir($dossier)) {
                    mkdir($dossier);
                }

                $img_CNI = $num_secu . '_cni.' . $extensionUpload_CNI;
                $img_CV = $num_secu . '_cv.' . $extensionUpload_CV;
                $img_CM = $num_secu . '_cm.' . $extensionUpload_CM;
                        
                $chemin_CNI = $dossier . $img_CNI;
                $chemin_CV = $dossier . $img_CV;
                $chemin_CM = $dossier . $img_CM;

                $resultat_CNI = move_uploaded_file($_FILES['carte_id']['tmp_name'], $chemin_CNI);
                $resultat_CV = move_uploaded_file($_FILES['carte_vitale']['tmp_name'], $chemin_CV);
                $resultat_CM = move_uploaded_file($_FILES['carte_mutuelle']['tmp_name'], $chemin_CM);

                if(is_readable($chemin_CNI) && is_readable($chemin_CV) && is_readable($chemin_CM)) {
                    $delete_files = $DB->prepare("DELETE FROM piece_jointe where Num_secu = ?;");
                    $delete_files->execute(array($num_secu));

                    $insert_files = $DB->prepare("INSERT INTO piece_jointe (Carte_identité, Carte_vitale, Carte_mutuelle, Livret_de_famille, Num_secu)  VALUES (?, ?, ?, ?, ?);");
                    $insert_files->execute(array($img_CNI, $img_CV, $img_CM, $img_livret, $num_secu));
                    $valid = true;
                } else {
                    $valid = false;
                }
                header('Location: patient.php');
                exit;
            }
            else {
                $valid = false;
                $erreur = '<ul class="notifications">
                    <li class="toast error">
                        <div class="column">
                            <span class="material-icons-round icon-notif">error</span>
                            <span class="message-notif">Mauvais format de fichier</span>
                        </div>
                        <span class="material-icons-outlined icon-notif close" onclick="remove()">close</span>
                    </li>
                </ul>
                <script>
                    const toast = document.querySelector(".toast");

                    function hideToast() {
                        setTimeout(function() {
                            toast.classList.add("hide")
                        }, 5000);
                    }

                    function remove() {
                        toast.classList.add("hide");
                    }

                    hideToast();
                </script>';
            }        
        }
        else {
            $valid = false;
        }     
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/notification.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
</head>
<body> 

    <?php

        // include_once ('src/sidebar.php');

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

        <?= $erreur?>
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