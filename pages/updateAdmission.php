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
        <form style="margin:auto;" action="" method="post">
            <label style="margin:auto;" for="num-secu">Numéro de sécurité sociale :</label><br>
            <input style="margin:auto;" class="moyen" type="text" name="num-secu" id="num-secu" maxlength="15" required="required"><br>

            <input style="margin:auto;" class="btn-envoi moyen" type="submit" value="Rechercher" name="submit">
        </form>
    </section>
    
</body>
</html>