<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            if ($nom_prevenir == $nom_confiance){
                $insert_prevenir = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
                $insert_prevenir->execute(array($nom_prevenir, $prenom_prevenir, $tel_prevenir, $adresse_prevenir));
            }
            else{
                $insert_prevenir = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
                $insert_prevenir->execute(array($nom_prevenir, $prenom_prevenir, $tel_prevenir, $adresse_prevenir));
                
                $insert_confiance = $DB->prepare("INSERT INTO contact (Nom, Prenom, Téléphone, Adresse) VALUES(?, ?, ?, ?)");
                $insert_confiance->execute(array($nom_confiance, $prenom_confiance, $tel_confiance, $adresse_confiance));
            }

            $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom = ?");
            $code_prevenir->execute(array($nom_prevenir, $prenom_prevenir));
            $code_prevenir = $code_prevenir->fetch();

            $code_confiance = $DB->prepare("SELECT * FROM contact WHERE Nom = ? and Prenom = ?");
            $code_confiance->execute(array($nom_confiance, $prenom_confiance));
            $code_confiance = $code_confiance->fetch();

            if(!empty($code_prevenir['code_contact']) && !empty($code_confiance['code_contact'])) {
                $insert_patient = $DB->prepare("INSERT INTO patient VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_patient->execute(array($num_secu, $civilite, $nom_naissance, $nom_epouse, $prenom, $date_naissance, $adresse, $CP, $tel, $ville, $email, 0, $code_prevenir['code_contact'], $code_confiance['code_contact']));
            }

            $patient = $DB->prepare("SELECT * FROM patient WHERE Num_secu = ?");
            $patient->execute(array($num_secu));
            $patient = $patient->fetch();

            if(isset($patient['Num_secu'])) {
                $_SESSION['patient'] = array(
                    $patient['Num_secu'], //0
                    $patient['Civilité'], //1
                    $patient['Nom_Naissance'], //2
                    $patient['Nom_Epouse'], //3
                    $patient['Prenom'], //4
                    $patient['Date_naissance'], //5
                    $patient['Adresse'], //6
                    $patient['Code_postal'], //7
                    $patient['Téléphone'], //8
                    $patient['Ville'], //9
                    $patient['Email'], //10
                    $patient['Mineur'], //11
                    $patient['code_prevenir'], //12
                    $patient['code_confiance'],); //13
            }

            $prevenir = $DB->prepare("SELECT * FROM contact WHERE code_contact = ?");
            $prevenir->execute(array($code_prevenir['code_contact']));
            $prevenir = $prevenir->fetch();

            if(isset($prevenir['code_contact'])) {
                $_SESSION['prevenir'] = array(
                    $prevenir['code_contact'], //0
                    $prevenir['Nom'], //1
                    $prevenir['Prenom'], //2
                    $prevenir['Téléphone'], //3
                    $prevenir['Adresse']); //4
            }

            $confiance = $DB->prepare("SELECT * FROM contact WHERE code_contact = ?");
            $confiance->execute(array($code_confiance['code_contact']));
            $confiance = $confiance->fetch();

            if(isset($confiance['code_contact'])) {
                $_SESSION['confiance'] = array(
                    $confiance['code_contact'], //0
                    $confiance['Nom'], //1
                    $confiance['Prenom'], //2
                    $confiance['Téléphone'], //3
                    $confiance['Adresse']); //4
            }

            header('Location: hospitalisation');
            exit;
        }
    }


    $aujourdhui = date("Y-m-d");
    // $diff = date_diff(date_create($date_naissance_patient), date_create($aujourdhui));
    // if ($diff->format('%y') >= 18){
    //     $age = 0;
    // }
    // else{
    //     $age = 1;
    // }
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
            <input type="text" class="grand" name="nom_naissance" id="nom-naissance" required="required"><br>

            <label for="nom-epouse">Nom d'épouse :</label>
            <input type="text" class="grand" name="nom_epouse" id="nom-epouse"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" name="prenom" id="prenom" required="required"><br> 

            <label for="num-secu">Numéro de sécurité sociale :</label>
            <input type="text" class="moyen" value="<?= $_SESSION['num']?>" style="cursor: not-allowed;" name="num_secu" id="num-secu" maxlength="15" required="required"><br>

            <label for="date-naissance">Date de naissance :</label>
            <input type="date" class="petit" name="date_naissance" id="date-naissance" max="<?=$aujourdhui?>" required="required"><br>

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
            <input type="text" class="grand" name="nom_prevenir" id="nom-prevenir" required="required"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" name="prenom_prevenir" id="prenom" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" name="tel_prevenir" id="tel" maxlength="10" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" name="adresse_prevenir" id="adresse" required="required"><br><br><br>

            <h2>Coordonnées Personne de confiance</h2><br>

            <label for="nom-confiance">Nom :</label>
            <input type="text" class="grand" name="nom_confiance" id="nom-confiance" required="required"><br>
            
            <label for="prenom">Prénom :</label>
            <input type="text" class="grand" name="prenom_confiance" id="prenom" required="required"><br>

            <label for="tel">Téléphone :</label>
            <input type="tel" class="petit" name="tel_confiance" id="tel" maxlength="10" required="required"><br>

            <label for="adresse">Adressse :</label>
            <input type="text" class="grand" name="adresse_confiance" id="adresse" required="required"><br>

            <input class="btn-envoi" type="submit" name="submit">
        </form>
    </section>
    
</body>
</html>