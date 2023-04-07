<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $services_liste = $DB->prepare("SELECT * FROM service");
    $services_liste->execute();
    $services_liste = $services_liste->fetchAll();

    $aujourdhui = date("Y-m-d");
    $passe = date("Y-m-d", strtotime('-100 year'));

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['inscription'])) {
            // $code_service = $DB->prepare("select id from service where libelle = ?");
            // $code_service->execute(array($service));
            // $code_service=$code_service->fetch();
            // $code = $code_service['id'];
            [$erreur] = $_INSCRIPTION->inscription_user($nom, $prenom, $identifiant, $service, $password, $role, $naissance);
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/notification.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Ajouter un personnel</h1>
        <form method="POST">
            <?php if(isset($erreur)) { echo $erreur; } ?>
            <label for="identifiant">Nom</label>
            <input type="text" class="grand" name="nom" id="nom" maxlength="20" required="required"><br>

            <label for="identifiant">Prénom</label>
            <input type="text" class="grand" name="prenom" id="prenom" maxlength="20" required="required"><br>

            <label for="naissance">Date de naissance</label>
            <input type="date" class="petit" name="naissance" id="naissance" min="<?=$passe?>" max="<?=$aujourdhui?>" required="required"><br>

            <label for="identifiant">Identifiant</label>
            <input type="text" class="grand" name="identifiant" id="identifiant" maxlength="20" required="required"><br>

            <label for="nom-medecin">Service</label>
            <select class="petit" name='service' size='1' id='service' required='required'>
                <?php 
                    foreach ($services_liste as $liste) {
                ?>
                <option value="<?= $liste['id']?>"><?= $liste['libelle']?></option>
                <?php
                    }
                ?>
            </select><br>

            <label for="chambre">Rôle</label>
            <select class="petit" name="role" id="role" required="required">
                    <option value="Secrétaire">Secrétaire</option>
                    <option value="Médecin">Médecin</option>
                    <option value="Administrateur">Administrateur</option>
            </select><br>

            <label for="password">Mot de passe</label>
            <div class="div-input">
                <input type="password" class="grand" name="password" id="password" maxlength="32">
                <span class="material-icons-outlined" onclick='toggle()'>visibility</span>
            </div><br>

            <div class="password-force">
            <div class="password-pourcent"><span></span></div>
            <div>Force du mot de passe : <span class="password-label"></span></div>
            </div>

            <input name="inscription" class="btn-envoi" value="Créer cet enregistrement" type="submit">
        </form>

        <script src="../js/password.js"></script>
        <script src="../js/valeur_input.js"></script>
    </section>
    
</body>
</html>