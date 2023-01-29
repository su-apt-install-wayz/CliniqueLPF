<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            
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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Ajouter un service</h1>
        <form action="" method="post">
            <?= $erreur?>
            <input style="margin: auto; max-width: 500px;" type="text" class="grand" required placeholder="Nom du service" name="libelle">
            <input style="margin: 30px auto 0; max-width: 500px;" type="submit" name="submit" value="Créer le service">
        </form>
    </section>
    
</body>
</html>