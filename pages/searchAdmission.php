<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $admissions = $DB->prepare("SELECT Date_hospitalisation, Pre_admission, Heure_intervention, hospitalisation.code_personnel, Num_secu, id, personnel.Nom FROM hospitalisation
    inner join personnel on personnel.Code_personnel = hospitalisation.code_personnel 
    where Num_secu = ? and statut = 'A faire';");
    $admissions->execute(array($_SESSION['hospitalisation'][4]));
    $admissions = $admissions->fetchAll();

    $patient = $DB->prepare("SELECT * FROM patient where Num_secu = ?;");
    $patient->execute(array($_SESSION['hospitalisation'][4]));
    $patient = $patient->fetch();

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
        <h1>Admission(s) pour le patient <span style="color: #3246D3;"><?= $patient['Nom_Naissance']." ".$patient['Prenom']?></span></h1>

        <div class="liste_admissions">
            <?php
                foreach ($admissions as $liste) {
            ?>
                <div class="admissions_carte">
                    <p>Numéro : <span style="color: #3246D3;"><?= $liste['Num_secu']?></span></p>
                    <p>Pour : <span style="color: #3246D3;"><?= $liste['Pre_admission']?></span></p>
                    <p>Date intervention : <span style="color: #3246D3;"><?= $liste['Date_hospitalisation']?></span></p>
                    <p>Heure intervention : <span style="color: #3246D3;"><?= $liste['Heure_intervention']?></span></p>
                    <p>Médecin : <span style="color: #3246D3;">Dr. <?= $liste['Nom']?></span></p>
                    <div class="boutons">
                        <a href="hospitalisation_update.php?id=<?= $liste['id']?>">Modifier</a>
                        <a style="background-color: #ef233c;" href="hospitalisation_delete.php?id=<?= $liste['id']?>">Supprimer</a>
                    </div>
                </div>
            <?php
                }
            ?>
        </div>
        
    </section>
    
</body>
</html>