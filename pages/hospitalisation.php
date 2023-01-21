<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');
    include_once('hospitalisation.php');

    $medecins_liste = $DB->prepare("SELECT * FROM personnel where role='medecin'");
    $medecins_liste->execute();
    $medecins_liste = $medecins_liste->fetchAll();

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            $medecin = $DB->prepare("SELECT Code_personnel FROM personnel WHERE Nom = ?");
            $medecin->execute(array($nom_medecin));
            $medecin = $medecin->fetch();

            if(!empty($medecin['Code_pesonnel'])) {
                $insert_admission = $DB->prepare("INSERT INTO hospitalisation (Date_hospitalisation, Pre_admission, Heure_intervention, code_personnel, Num_secu) VALUES (?, ?, ?, ?, ?)");
                $insert_admission->execute(array($pre_admission, $date_hospitalisation, $heure_intervention, $medecin['Code_personnel'], $_SESSION['patient'][0]));
            }

            // header('Location: couverture');
            // exit();
        }
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
            <label for="pre-admission">Pré-admission :</label>
            <select class="moyen" name="pre_admission" id="pre_admission" required="required">
                <option value="Ambulatoire">Ambulatoire</option>
                <option value="Hospitalisation">Hospitalisation</option>

            </select><br>

            <!-- <label for="num-secu">Numéro de sécurité sociale :</label><br>
            <input type="text" name="num-secu" id="num-secu" maxlength="15" required="required"><br> -->

            <label for="date-hospitalisation">Date d'hospitalisation</label>
            <input class="petit" type="date" name="date_hospitalisation" id="date_hospitalisation" required="required">

            <br>

            <label for="heure-intervention">Heure d'intervention</label>
            <input class="petit" type="time" name="heure_intervention" id="heure_intervention" required="required">

            <br>

                    
            <label for="nom-medecin">Nom du medecin</label>
            <select class="moyen" name='nom_medecin' size='1' id='nom_medecin' required='required'>
                <?php 
                    foreach ($medecins_liste as $liste) {
                ?>
                <option value="<?= $liste['Nom']?>"><?= $liste['Nom']?></option>
                <?php
                    }
                ?>
            </select><br>
        

            <input class="btn-envoi" type="submit" name="submit">
        </form>
    </section>
    
</body>
</html>