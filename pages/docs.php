<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');
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
            <label for="carte-id">Carte d'identité (recto/verso) :</label><br>
            <input class="grand" type="file" title="" name="carte-id" id="carte-id" required="required"><br>

            <label for="carte-vitale">Carte vitale :</label><br>
            <input class="grand" type="file" title="" name="carte-vitale" id="carte-vitale" required="required"><br>

            <label for="carte-mutuelle">Carte de mutuelle :</label><br>
            <input class="grand" type="file" title="" name="carte-mutuelle" id="carte-mutuelle" required="required"><br>
                    
            <!-- <?php     
                include_once('./php/config.php');
                if($_SESSION['mineur']==1) {
            ?> -->
                <label for="livret">Livret de famille (mineurs) :</label><br>
                <input class="grand" type="file" title="" name="livret" id="livret" required="required"><br>
            <!-- <?php
                }
            ?> -->

            <input name="submit" class="btn-envoi" type="submit">
        </form>
    </section>
    
</body>
</html>