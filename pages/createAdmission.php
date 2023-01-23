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
            $patient = $DB->prepare("SELECT * FROM patient WHERE Num_secu = ?");
            $patient->execute(array($num_secu));
            $patient = $patient->fetch();

            if(isset($patient['Num_secu'])) {
                header('Location: patient_existant');
                exit;                
            }
            else {
                $_SESSION['num'] = $num_secu;
                header('Location: patient');
                exit; 
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