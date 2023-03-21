<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            $bool = $_SESSION['couverture'][6];

            $_SESSION['couverture'] = array(
                $orga_secu, //0
                $assure, //1
                $ALD, //2
                $nom_mutuelle, //3
                $num_adherent, //4
                $chambre, //5
                $bool); //6

            header('Location: docs.php');
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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
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
                <div class="bulle bulle-passe"><p>2</p></div>
                <div class="bulle-texte texte-passe"><p>HOSPITALISATION</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl3">
                <div class="bulle active-bulle"><p>3</p></div>
                <div class="bulle-texte active-texte"><p>COUVERTURE SOCIALE</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl4">
                <div class="bulle 4"><p>4</p></div>
                <div class="bulle-texte"><p>DOCUMENTS</p></div>
            </div>
        </div>

        <form action="" method="post">
            <label for="orga-secu">Organisme de sécurité sociale :</label>
            <input class="grand" value="<?= $_SESSION['couverture'][0]?>" type="text" name="orga_secu" id="orga-secu" required="required"><br>

            <label for="assuré">Le patient est-il assuré ?</label>
            <select class="petit" name="assure" id="assure" required="required">
                <?php
                    if(!empty($_SESSION['couverture'][1])) {
                ?>
                    <option value="<?= $_SESSION['couverture'][1]?>" ><?= $_SESSION['couverture'][1]?></option>
                    <?php
                        if ($_SESSION['couverture'][1]== 'Oui') {
                    ?>
                            <option value="Non" >Non</option>
                    <?php
                        }
                        else if($_SESSION['couverture'][1]== 'Non') {
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

            <label for="ALD">Le patient est-il en ALD ?</label>
            <select class="petit" name="ALD" id="ALD" required="required">
                <?php
                    if(!empty($_SESSION['couverture'][2])) {
                ?>
                    <option value="<?= $_SESSION['couverture'][2]?>" ><?= $_SESSION['couverture'][2]?></option>
                    <?php
                        if ($_SESSION['couverture'][2]== 'Oui') {
                    ?>
                            <option value="Non" >Non</option>
                    <?php
                        }
                        else if($_SESSION['couverture'][2]== 'Non') {
                    ?>
                           <option value="Oui" >Oui</option> 
                    <?php
                        }
                        else {
                    ?>
                            <option value="Non" >Non</option>
                            <option value="Oui" >Oui</option>
                    <?php
                        }
                    ?>

                <?php
                    }
                    else {
                ?>
                        <option value="Non" >Non</option>
                        <option value="Oui" >Oui</option>
                <?php
                    }
                ?>
            </select><br>

            <label for="nom-mutuelle">Nom de la mutuelle ou l'assurance:</label>
            <input class="grand" value="<?= $_SESSION['couverture'][3]?>" type="text" name="nom_mutuelle" id="nom_mutuelle" required="required"><br>
                            
            <label for="num-adherent">Numéro d'adhérent :</label>
            <input class="moyen" value="<?= $_SESSION['couverture'][4]?>" type="number" name="num_adherent" id="num_adherent" required="required"><br>

            <label for="chambre">Chambre :</label>
            <select class="petit" name="chambre" id="chambre" required="required">
                <optgroup label="Avec équipements">
                    <option value=1>Individuelle</option>
                    <option value=2>Partagée</option>
                </optgroup>
                <optgroup label="Sans équipements">
                    <option value=3>Individuelle</option>
                    <option value=4>Partagée</option>
                </optgroup>
            </select>

            <input class="btn-envoi" type="submit" value="Suivant" name="submit">
        </form>
    </section>
    
</body>
</html>