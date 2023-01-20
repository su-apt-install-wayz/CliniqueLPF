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

            $insert_patient = $DB->prepare("INSERT INTO personnel (Nom, Identifiant, Mot_de_passe, role) VALUES(?, ?, ?, 'secretaire')");
            $insert_patient->execute(array($identifiant, $identifiant, $crypt_password));

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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][1])?> 🖐</title>
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
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select><br>

            <label for="nom-naissance">Nom de naissance :</label>
            <input type="text" class="grand" name="nom-naissance" id="nom-naissance" required="required"><br>

            <label for="nom-epouse">Nom d'épouse :</label>
            <input type="text" class="grand" name="nom-epouse" id="nom-epouse"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" name="prenom" id="prenom" required="required"><br>

            <label for="num-secu">Numéro de sécurité sociale :</label>
            <input type="text" class="moyen" name="num-secu" id="num-secu" maxlength="15" required="required"><br>

            <label for="date-naissance">Date de naissance :</label>
            <input type="date" class="petit" name="date-naissance" id="date-naissance" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" name="adresse" id="adresse" required="required"><br>
            
            <label for="CP">Code postal :</label>
            <input type="text" class="petit" name="CP" id="CP" maxlength="5" required="required"><br>

            <label for="ville">Ville :</label>
            <input type="text" class="grand" name="ville" id="ville" required="required"><br>

            <label for="email">Email :</label>
            <input type="text" class="moyen" name="email" id="email" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" name="tel" id="tel" maxlength="10" required="required"><br><br><br>

            <h2>Coordonnées Personne à prévenir</h2><br>

            <label for="nom-prevenir">Nom :</label>
            <input type="text" class="grand" name="nom-prevenir" id="nom-prevenir" required="required"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" name="prenom-prevenir" id="prenom" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" name="tel-prevenir" id="tel" maxlength="10" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" name="adresse-prevenir" id="adresse" required="required"><br><br><br>

            <h2>Coordonnées Personne de confiance</h2><br>

            <label for="nom-confiance">Nom :</label>
            <input type="text" class="grand" name="nom-confiance" id="nom-confiance" required="required"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" name="prenom-confiance" id="prenom" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" name="tel-confiance" id="tel" maxlength="10" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" name="adresse-confiance" id="adresse" required="required"><br>

            <input class="btn-envoi" type="submit" name="submit">
        </form>
    </section>
    
</body>
</html>