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

    $aujourdhui = date("Y-m-d");

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            $diff = date_diff(date_create($date_naissance), date_create($aujourdhui));
            if ($diff->format('%y') >= 18){
                $age = 0;
            }
            else{
                $age = 1;
            }

            $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=? and Adresse=?");
            $code_prevenir->execute(array($_SESSION['prevenir'][1], $_SESSION['prevenir'][2], $_SESSION['prevenir'][3], $_SESSION['prevenir'][4]));
            $code_prevenir = $code_prevenir->fetch();

            $code_confiance = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom=? and Téléphone=? and Adresse=?");
            $code_confiance->execute(array($_SESSION['confiance'][1], $_SESSION['confiance'][2], $_SESSION['confiance'][3], $_SESSION['confiance'][4]));
            $code_confiance = $code_confiance->fetch();

            $bool = $_SESSION['patient'][14];

            $_SESSION['patient'] = array(
                $num_secu, //0
                $civilite, //1
                $nom_naissance, //2
                $nom_epouse, //3
                $prenom, //4
                $date_naissance, //5
                $adresse, //6
                $CP, //7
                $tel, //8
                $ville, //9
                $email, //10
                $age, //11
                $code_prevenir['code_contact'], //12
                $code_confiance['code_contact'], //13
                $bool); //14

            header('Location: contact');
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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <div class="en-tete">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
            </svg><br>
            <p>Nous vous remercions de bien vouloir remplir avec attention ce formulaire</p><br><br>
        </div>
    
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
            <label for="civilite">Civilité :</label>
            <select class="petit" name="civilite" id="civilite" required="required">
                <option value="Vide" hidden>Choisir le sexe</option>
                <option value="Homme" <?= $homme?> >Homme</option>
                <option value="Femme" <?= $femme?> >Femme</option>
            </select><br>

            <label for="nom-naissance">Nom de naissance :</label>
            <input type="text" class="grand" value="<?= $_SESSION['patient'][2]?>" name="nom_naissance" id="nom-naissance" required="required"><br>

            <label for="nom-epouse">Nom d'épouse (optionnel) :</label>
            <input type="text" class="grand" value="<?= $_SESSION['patient'][3]?>" name="nom_epouse" id="nom-epouse"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" value="<?= $_SESSION['patient'][4]?>" name="prenom" id="prenom" required="required"><br> 

            <label for="num-secu">Numéro de sécurité sociale :</label>
            <input type="text" class="moyen" value="<?= $_SESSION['patient'][0]?>" style="cursor: not-allowed;" name="num_secu" id="num-secu" maxlength="15" required="required"><br>

            <label for="date-naissance">Date de naissance :</label>
            <input type="date" class="petit" value="<?= $_SESSION['patient'][5]?>" name="date_naissance" id="date-naissance" max="<?=$aujourdhui?>" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" value="<?= $_SESSION['patient'][6]?>" name="adresse" id="adresse" required="required"><br>
            
            <label for="CP">Code postal :</label>
            <input type="text" class="petit" value="<?= $_SESSION['patient'][7]?>" name="CP" id="CP" maxlength="5" required="required"><br>

            <label for="ville">Ville :</label>
            <input type="text" class="grand" value="<?= $_SESSION['patient'][9]?>" name="ville" id="ville" required="required"><br>

            <label for="email">Email :</label>
            <input type="email" class="moyen" value="<?= $_SESSION['patient'][10]?>" name="email" id="email" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" value="<?= $_SESSION['patient'][8]?>" name="tel" id="tel" maxlength="10" required="required"><br><br><br>

            <input class="btn-envoi" type="submit" value="Suivant" name="submit">
        </form>
    </section>
    
</body>
</html>