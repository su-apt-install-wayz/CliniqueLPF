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
            <label for="orga-secu">Organisme de sécurité sociale :</label><br>
            <input class="grand" type="text" name="orga-secu" id="orga-secu" required="required"><br>

            <!-- <label for="num-secu">Numéro de sécurité sociale :</label><br>
            <input type="text" name="num-secu" id="num-secu" maxlength="15" required="required" value=""><br> -->

            <label for="assuré">Le patient est-il assuré ?</label><br>
            <select class="petit" name="assuré" id="assuré" required="required">
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </select><br>

            <label for="ALD">Le patient est-il en ALD ?</label><br>
            <select class="petit" name="ALD" id="ALD" required="required">
                <option value="non">Non</option>
                <option value="oui">Oui</option>
            </select><br>

            <label for="nom-mutuelle">Nom de la mutuelle ou l'assurance:</label><br>
            <input class="grand" type="text" name="nom-mutuelle" id="nom-mutuelle" required="required"><br>
                            
            <label for="num-adherent">Numéro d'adhérent :</label><br>
            <input class="moyen" type="text" name="num-adherent" id="num-adherent" required="required"><br>

            <label for="chambre">Chambre particulière ?</label><br>
            <select class="petit" name="chambre" id="chambre" required="required">
                <option value="non">Non</option>
                <option value="oui">Oui</option>
            </select>

            <input class="btn-envoi" type="submit" name="submit">
        </form>
    </section>
    
</body>
</html>