<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $medecins_liste = $DB->prepare("SELECT * FROM personnel where role='medecin' and Code_personnel!=?");
    $medecins_liste->execute(array($_SESSION['hospitalisation'][3]));
    $medecins_liste = $medecins_liste->fetchAll();

    $medecin= $DB->prepare("SELECT * FROM personnel where Code_personnel=?");
    $medecin->execute(array($_SESSION['hospitalisation'][3]));
    $medecin = $medecin->fetch();

    $aujourdhui = date("Y-m-d");

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            $_SESSION['hospitalisation'] = array(
                $pre_admission, //0
                $date_hospitalisation, //1
                $heure_intervention, //2
                $nom_medecin); //3
            
            header('Location: updateAdmission');
            exit;
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
        <form action="" method="post">
            <label for="pre-admission">Pré-admission :</label>
            <select class="moyen" name="pre_admission" id="pre_admission" required="required">
                <option value="Ambulatoire">Ambulatoire</option>
                <option value="Hospitalisation">Hospitalisation</option>
                <?php
                    if($_SESSION['couverture'][1]== 'Non') {
                ?>
                        <option value="Oui" >Oui</option> 
                <?php
                    }
                    else {
                ?>
                        <option value="Oui" >Oui</option>
                        <option value="Non" >Non</option>
                <?php
                    }
                ?>


            </select><br>

            <!-- <label for="num-secu">Numéro de sécurité sociale :</label><br>
            <input type="text" name="num-secu" id="num-secu" maxlength="15" required="required"><br> -->

            <label for="date-hospitalisation">Date d'hospitalisation</label>
            <input class="petit" value="<?= $_SESSION['hospitalisation'][0]?>" type="date" name="date_hospitalisation" min="<?= $aujourdhui?>" id="date_hospitalisation" required="required">

            <br>

            <label for="heure-intervention">Heure d'intervention</label>
            <input class="petit" value="<?= $_SESSION['hospitalisation'][2]?>" type="time" name="heure_intervention" id="heure_intervention" required="required">

            <br>

                    
            <label for="nom-medecin">Nom du medecin</label>
            <select class="moyen" name='nom_medecin' size='1' id='nom_medecin' required='required'>
                <option value="<?= $medecin['Nom']?>"><?= $medecin['Nom']?></option>
                <?php 
                    foreach ($medecins_liste as $liste) {
                ?>
                <option value="<?= $liste['Nom']?>"><?= $liste['Nom']?></option>
                <?php
                    }
                ?>
            </select><br>
        

            <input class="btn-envoi" type="submit" value="Suivant" name="submit">
        </form>
    </section>
    
</body>
</html>