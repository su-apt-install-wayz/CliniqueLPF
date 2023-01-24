<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][1])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Bon retour <?= htmlspecialchars($_SESSION['personnel'][1])?> 🖐</h1>
        <div class="panel">
            <div class="cards">
                <div class="card">
                    <h2>Neurologie</h2>
                    <h5 class="prof">Service</h5>
                    <h5 class="count"><p>24 <span>patients</span></p></h5>
                </div>
                <div class="card">
                    <h2>Neurologie</h2>
                    <h5 class="prof">Service</h5>
                    <h5 class="count"><p>24 <span>patients</span></p></h5>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>