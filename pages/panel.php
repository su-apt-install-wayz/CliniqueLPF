<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $stats = $DB->prepare("select distinct count(hospitalisation.Num_secu) as nbr_patient , service.libelle from hospitalisation 
    inner join personnel on personnel.Code_personnel=hospitalisation.code_personnel 
    inner join service on service.id=personnel.Service
    group by service.id;");
    $stats->execute();
    $stats = $stats->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 🖐</h1>
        <div class="panel">
            <div class="cards">
                <?php
                    foreach ($stats as $liste) {
                ?>
                <div class="card">
                    <h2><?= $liste['libelle']?></h2>
                    <h5 class="prof">Service</h5>
                    <h5 class="count"><p><?= $liste['nbr_patient']?> <span>hospitalisation(s)</span></p></h5>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
    
</body>
</html>