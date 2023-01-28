<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['inscription'])) {
            [$erreur] = $_INSCRIPTION->inscription_user($identifiant, $mail, $password);
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/formulaire.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][1])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Ajouter un personnel</h1>
        <form method="POST">
            <label for="identifiant">Votre identifiant</label>
            <div class="div-input">
                <input type="text" class="grand" name="identifiant" id="identifiant" maxlength="20">
                <span class="chiffre chiffre_id">20</span>
            </div>

            <label for="mail">Votre adresse mail</label>
            <div class="div-input">
            <input type="mail" class="grand" name="mail" id="mail" maxlength="30">
            <span class="chiffre chiffre_mail">30</span>
            </div>

            <label for="password">Votre mot de passe</label>
            <div class="div-input">
            <input type="password" class="grand" name="password" id="password" maxlength="32">
            <span class="material-icons-outlined" onclick='toggle()'>visibility</span>
            </div>

            <div class="password-force">
            <div class="password-pourcent"><span></span></div>
            <div>Force du mot de passe : <span class="password-label"></span></div>
            </div>

            <input type="submit" class="grand" name="inscription" value="Créer cet enregistrement">
        </form>

        <script src="../js/password.js"></script>
        <script src="../js/valeur_input.js"></script>
    </section>
    
</body>
</html>