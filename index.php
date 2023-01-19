<?php
    error_reporting(E_ALL);
	ini_set("display_errors", 1);
    include_once('include.php');

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['connexion'])) {
            [$erreur] = $_CONNEXION->connexion_user($identifiant, $password);
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('include/link.php') ?>

    <link rel="stylesheet" href="css/formulaire.css">
    <link rel="stylesheet" href="css/notification.css">

    <title>Clinique LPF</title>

</head>

    <body>
        <div class="left">
            <h1 class="logo">Clinique <span>LPF</span></h1>
            <form method="POST">
                <h1>Se connecter 🖐</h1>
                <p>Renseignez votre identifiant pour continuer sur le panel.</p>
                <label for="identifiant">Votre identifiant</label>

                <?php if(isset($erreur)) { echo $erreur; } ?>
                <input type="text" name="identifiant" id="identifiant" maxlength="20">

                <label for="password">Votre mot de passe</label>
                <div class="div-input">
                    <input type="password" name="password" id="password" maxlength="32">
                    <span class="material-icons-outlined" onclick='toggle()'>visibility</span>
                </div>

                <input type="submit" name="connexion" value="Se connecter">
            </form>
        </div>
        <div class="right">
            <img src="./images/public/ICONE.svg" alt="">
        </div>

        <script src="./js/password.js"></script>
        
    </body>

</html>