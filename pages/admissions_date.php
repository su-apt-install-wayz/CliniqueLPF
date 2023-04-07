<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $date = $_POST['date'];

    $aujourdhui = date("Y-m-d");

    $admissions = $DB->prepare("SELECT hospitalisation.id, Date_hospitalisation, Pre_admission, Heure_intervention, hospitalisation.Num_secu, personnel.Nom, patient.Nom_Naissance, patient.Prenom FROM clinique.hospitalisation inner join patient on hospitalisation.Num_secu = patient.Num_secu
    inner join personnel on personnel.Code_personnel = hospitalisation.code_personnel
    WHERE statut = 'A faire' and personnel.Code_personnel = ? and hospitalisation.Date_hospitalisation = ?");
    $admissions->execute(array($_SESSION['personnel'][0], $date));
    $admissions = $admissions->fetchAll();

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

            <div class="admissions">
                <h1>Pré-admissions pour la date sélectionnée</h1>

                <?php
                    foreach ($admissions as $liste2) {
                ?>
                <div class="ligne">
                    <p><?= $liste2['Num_secu']?></p>
                    <p><?= $liste2['Nom_Naissance']?></p>
                    <p><?= $liste2['Prenom']?></p>
                    <p><?= $liste2['Pre_admission']?></p>
                    <p><?= $liste2['Date_hospitalisation']?></p>
                    <p><?= $liste2['Heure_intervention']?></p>
                    <p>Dr. <?= $liste2['Nom']?></p>
                    <?php
                        if($_SESSION['personnel'][6]=='Médecin') {
                            if($liste2['Date_hospitalisation'] < $aujourdhui) {
                    ?>
                            <a href="hospitalisation_cloture.php?id=<?= $liste2['id']?>">Clôturer</a>
                    <?php
                            }
                        }
                    ?>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
    
</body>
</html>