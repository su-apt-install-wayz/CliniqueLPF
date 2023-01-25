<?php 

    include_once('../include.php');

    $_SESSION['patient'] = array();
    $_SESSION['prevenir'] = array();
    $_SESSION['confiance'] = array();
    $_SESSION['couverture'] = array();

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            function is_secsocnum($num_secu){
                // que des chiffres 
                $num_secu = preg_replace("/[^0-9]/", "", $num_secu); 
                 // 13 chiffres + 2 de cle. 
                if ((strlen($num_secu) != 13) && (strlen($num_secu) != 15)) { return 0;} 
                // premier chiffre : sexe : un ou deux 
                if (($num_secu[0] == 0) || ( $num_secu[0] > 2)){ return 0;} 
                // deux chiffres suivants : annee de naissance 
                // deux chiffres suivants : mois de naissance, entre 1 et 12 
                if (!in_array(substr($num_secu, 3, 2), range(1, 12))){ return 0;} 
                 
                return true;
            }

            $patient = $DB->prepare("SELECT * FROM patient WHERE Num_secu = ?");
            $patient->execute(array($num_secu));
            $patient = $patient->fetch();

            if (is_secsocnum($num_secu) ) {

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
                        $patient['code_confiance'], //13
                        true); //14

                    $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE code_contact = ?");
                    $code_prevenir->execute(array($patient['code_prevenir']));
                    $code_prevenir = $code_prevenir->fetch();

                    if(isset($code_prevenir['code_contact'])) {
                        $_SESSION['prevenir'] = array(
                            $code_prevenir['code_contact'], //0
                            $code_prevenir['Nom'], //1
                            $code_prevenir['Prenom'], //2
                            $code_prevenir['Téléphone'], //3
                            $code_prevenir['Adresse'], //4
                            true); //5
                    }
                    else {
                        $_SESSION['prevenir'] = array("", "", "", "", "", false);
                    }

                    $code_confiance = $DB->prepare("SELECT * FROM contact WHERE code_contact = ?");
                    $code_confiance->execute(array($patient['code_confiance']));
                    $code_confiance = $code_confiance->fetch();

                    if(isset($code_confiance['code_contact'])) {
                        $_SESSION['confiance'] = array(
                            $code_confiance['code_contact'], //0
                            $code_confiance['Nom'], //1
                            $code_confiance['Prenom'], //2
                            $code_confiance['Téléphone'], //3
                            $code_confiance['Adresse'], //4
                            true); //5
                    }
                    else {
                        $_SESSION['confiance'] = array("", "", "", "", "", false);
                    }

                    $secu = $DB->prepare("SELECT * FROM secu WHERE Num_secu = ?");
                    $secu->execute(array($_SESSION['patient'][0]));
                    $secu = $secu->fetch();

                    if(isset($secu['Num_secu'])) {
                        $_SESSION['couverture'] = array(
                            $secu['organisme'], //0
                            $secu['assure'], //1
                            $secu['Ald'], //2
                            $secu['Nom_mutuelle'], //3
                            $secu['num_adherent'], //4
                            $secu['chambre_particuliere'], //5
                            true); //6          
                    }
                    else {
                        $_SESSION['couverture'] = array("", "", "", "", "", "", false);
                    }

                    header('Location: patient');
                    exit;                
                }
                
                else {
                    $_SESSION['patient'] = array($num_secu, "", "", "", "", "", "", "", "", "", "", "", "", "", false);
                    $_SESSION['prevenir'] = array("", "", "", "", "", false);
                    $_SESSION['confiance'] = array("", "", "", "", "", false);
                    $_SESSION['couverture'] = array("", "", "", "", "", "", false);
                    header('Location: patient');
                    exit; 
                }
            }
            
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
        <form style="margin:auto; width: 100%; max-width: 500px;" action="" method="post">
            <label style="margin:auto;" for="num_secu">Numéro de sécurité sociale :</label><br>
            <input style="margin:auto;" class="moyen" type="text" name="num_secu" id="num_secu" maxlength="15" required="required"><br>

            <input style="margin:auto;" class="btn-envoi moyen" type="submit" value="Rechercher" name="submit">
        </form>
    </section>
    
</body>
</html>