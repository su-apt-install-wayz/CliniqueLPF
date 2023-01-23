<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    if ($_SESSION['patient'][1] = 'Homme') {
        $homme = "selected";
        $femme = "";
    }
    else if  ($_SESSION['patient'][1] = 'Femme'){
        $homme = "";
        $femme = "selected";
    }
    else {
        $homme = "";
        $femme = "";
    }

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            $code_contact = $DB->prepare("SELECT code_prevenir, code_confiance, Nom Prenom, Téléphone, Adresse, code_contact FROM patient inner join on contact.code_contact=patient.code_prevenir contact WHERE Num_secu = ?");
            $code_contact->execute(array($_SESSION['patient'][0]));
            $code_contact = $code_contact->fetch();

            $_SESSION['prevenir'] = array(
                $code_contact['code_prevenir'], //0
                $nom_prevenir, //1
                $prenom_prevenir, //2
                $tel_prevenir, //3
                $adresse_prevenir); //4

            $_SESSION['confiance'] = array(
                $code_contact['code_confiance'], //0
                $nom_confiance, //1
                $prenom_confiance, //2
                $tel_confiance, //3
                $adresse_confiance); //4
        }
    }

    $aujourdhui = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][1])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">  
        <div class="level">
            <div class="lvl1">
                <div class="bulle active-bulle"><p>1</p></div>
                <div class="bulle-texte active-texte"><p>PATIENT</p></div>
            </div>
    
            <div class="ligne"></div>
    
            <div class="lvl2">
                <div class="bulle 2"><p>2</p></div>
                <div class="bulle-texte"><p>HOSPITALISATION</p></div>
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
            <h2>Coordonnées Personne à prévenir</h2><br>

            <label for="nom-prevenir">Nom :</label>
            <input type="text" class="grand" value="<?= $_SESSION['prevenir'][1]?>" name="nom_prevenir" id="nom-prevenir" required="required"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" value="<?= $_SESSION['prevenir'][2]?>" name="prenom_prevenir" id="prenom" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" value="<?= $_SESSION['prevenir'][3]?>" name="tel_prevenir" id="tel" maxlength="10" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" value="<?= $_SESSION['prevenir'][4]?>" name="adresse_prevenir" id="adresse" required="required"><br><br><br>

            <h2>Coordonnées Personne de confiance</h2><br>

            <label for="nom-confiance">Nom :</label>
            <input type="text" class="grand" value="<?= $_SESSION['confiance'][1]?>" name="nom_confiance" id="nom-confiance" required="required"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" value="<?= $_SESSION['confiance'][2]?>" name="prenom_confiance" id="prenom" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" value="<?= $_SESSION['confiance'][3]?>" name="tel_confiance" id="tel" maxlength="10" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" value="<?= $_SESSION['confiance'][4]?>" name="adresse_confiance" id="adresse" required="required"><br>

            <input class="btn-envoi" type="submit" name="submit">
        </form>
    </section>
    
</body>
</html>