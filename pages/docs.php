<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    if(!empty($_POST)) {
        extract($_POST);

        $valid = true;
            
        $num_secu = $_SESSION['patient'][0];
            
        if(isset($_FILES['carte_id']) && !empty($_FILES['carte_id']['name']) && isset($_FILES['carte_vitale']) && !empty($_FILES['carte_vitale']['name']) && isset($_FILES['carte_mutuelle']) && !empty($_FILES['carte_mutuelle']['name'])) {
            $filename_petit = $_FILES['carte-id']['tmp_name'];

            $extensionValides = array('jpg', 'png', 'jpeg');


            $extensionUpload_CNI = strtolower(substr(strrchr($_FILES['carte-id']['name'], '.'), 1));
            $extensionUpload_CV = strtolower(substr(strrchr($_FILES['carte-vitale']['name'], '.'), 1));
            $extensionUpload_CM = strtolower(substr(strrchr($_FILES['carte-mutuelle']['name'], '.'), 1));
            $extensionUpload_livret = strtolower(substr(strrchr($_FILES['carte-mutuelle']['name'], '.'), 1));

                if(in_array($extensionUpload_CNI, $extensionValides) && in_array($extensionUpload_CV, $extensionValides) && in_array($extensionUpload_CM, $extensionValides)) {
                    $dossier_CNI = '../images/private/patients/';
                    $dossier_CV = '../images/private/patients/';
                    $dossier_CM = '../images/private/patients/';

                    var_dump($num_secu);
                    $img_CNI = $num_secu . '_cni.' . $extensionUpload_CNI;
                    $img_CV = $num_secu . '_cv.' . $extensionUpload_CV;
                    $img_CM = $num_secu . '_cm.' . $extensionUpload_CM;
                        
                    $chemin_CNI = $dossier_CNI . $img_CNI;
                    $chemin_CV = $dossier_CV . $img_CV;
                    $chemin_CM = $dossier_CM . $img_CM;

                    $resultat_CNI = move_uploaded_file($_FILES['carte-id']['tmp_name'], $chemin_CNI);
                    $resultat_CV = move_uploaded_file($_FILES['carte-vitale']['tmp_name'], $chemin_CV);
                    $resultat_CM = move_uploaded_file($_FILES['carte-mutuelle']['tmp_name'], $chemin_CM);

                }

                if(is_readable($chemin_CNI) && is_readable($chemin_CV) && is_readable($chemin_CM)) {

                    $insert_files = $DB->prepare("INSERT INTO piece_jointe (Carte_identité, Carte_vitale, Carte_mutuelle, Num_secu)  VALUES (?, ?, ?, ?);");
                    $insert_admission->execute(array($carte_id, $carte_vitale, $carte_mutuelle, $num_secu));
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
            <label for="carte-id">Carte d'identité (recto/verso) :</label>
            <input class="grand" type="file" title="" name="carte_id" id="carte_id" required="required"><br>

            <label for="carte-vitale">Carte vitale :</label>
            <input class="grand" type="file" title="" name="carte_vitale" id="carte_vitale" required="required"><br>

            <label for="carte-mutuelle">Carte de mutuelle :</label>
            <input class="grand" type="file" title="" name="carte_mutuelle" id="carte_mutuelle" required="required"><br>
                    
            <!-- <?php     
                include_once('./php/config.php');
                if($_SESSION['mineur']==1) {
            ?> -->
                <label for="livret">Livret de famille (mineurs) :</label>
                <input class="grand" type="file" title="" name="livret" id="livret" required="required"><br>
            <!-- <?php
                }
            ?> -->

            <input name="submit" class="btn-envoi" type="submit">
        </form>
    </section>
    
</body>
</html>