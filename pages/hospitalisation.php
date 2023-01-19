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
                <div class="bulle 2 active-bulle"><p>2</p></div>
                <div class="bulle-texte active-texte"><p>HOSPITALISATION</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl3">
                <div class="bulle 3"><p>3</p></div>
                <div class="bulle-texte"><p>COUVERTURE SOCIALE</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl4">
                <div class="bulle 4"><p>4</p></div>
                <div class="bulle-texte"><p>DOCUMENTS</p></div>
            </div>
        </div>

        <form action="" method="post">
            <label for="pre-admission">Pré-admission :</label><br>
            <select class="moyen" name="pre-admission" id="pre-admission" required="required">
                <option value="Ambulatoire">Ambulatoire</option>
                <option value="Hospitalisation">Hospitalisation</option>

            </select><br>

            <!-- <label for="num-secu">Numéro de sécurité sociale :</label><br>
            <input type="text" name="num-secu" id="num-secu" maxlength="15" required="required"><br> -->

            <label for="date-hospitalisation">Date d'hospitalisation</label><br>
            <input class="petit" type="date" name="date-hospitalisation" id="date-hospitalisation" required="required">

            <br>

            <label for="heure-intervention">Heure d'intervention</label><br>
            <input class="petit" type="time" name="heure-intervention" id="heure-intervention" required="required">

            <br>
                    
            <label for="nom-medecin">Nom du medecin</label><br>
            <select class="moyen" name='nom-medecin' size='1' id='nom-medecin' required='required'>
                <option value="">aa</option>
                <option value="">bb</option>
            </select><br>

            <input class="btn-envoi" type="submit" name="submit">
        </form>
    </section>
    
</body>
</html>