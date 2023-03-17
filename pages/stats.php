<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $medecin = $DB->prepare("SELECT count(*) as nbr_medecin, role FROM personnel inner join service on service.id = personnel.Service and Service = ? group by role;    ");
    $medecin->execute(array($_SESSION['personnel'][5]));
    $medecin = $medecin->fetchAll();


    $stats = $DB->prepare("select count(hospitalisation.Num_secu) as nbr_patient, statut from hospitalisation 
    inner join personnel on personnel.Code_personnel=hospitalisation.code_personnel 
    where personnel.Nom = ? and personnel.Prenom = ? group by hospitalisation.statut;");
    $stats->execute(array($_SESSION['personnel'][1], $_SESSION['personnel'][2]));
    $stats = $stats->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <div class="panel">
            <h1>Vos statistiques</h1>
            <div class="cards">
                <?php
                    foreach ($stats as $liste) {
                ?>
                <div class="card">
                    <h2><?= $liste['statut']?></h2>
                    <h5 class="prof">Service</h5>
                    <h5 class="count"><p><?= $liste['nbr_patient']?> <span>hospitalisation(s)</span></p></h5>
                </div>
                <?php
                    }
                ?>
            </div>
            <h1>Votre service</h1>
            <div class="cards">
                <?php
                    foreach ($medecin as $liste2) {
                        if($liste2['role']=='Administrateur'){
                            $liste2['role'] = 'Admin';
                        }
                ?>
                <div class="card">
                    <h2><?= $liste2['role']?></h2>
                    <h5 class="prof">Service</h5>
                    <h5 class="count"><p><?= $liste2['nbr_medecin']?> <span><?= $liste2['role']?>(s)</span></p></h5>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
    
</body>
</html>