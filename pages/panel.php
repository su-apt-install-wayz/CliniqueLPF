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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
                        $libelle[] = $liste['libelle'];
                        $nbre[] = $liste['nbr_patient'];
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

            <div class="stats">
                <div>
                    <canvas id="myChart"></canvas>
                </div>
                <div>
                    <canvas id="myChart2"></canvas>
                </div>

                <script>
                    const ctx = document.getElementById('myChart');


                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                        labels: <?= json_encode($libelle)?>,
                        datasets: [{
                            label: 'Hospitalisations',
                            data: <?= json_encode($nbre)?>,
                            borderWidth: 1,
                            hoverOffset: 4
                        }]
                        },

                    
                        options: {
                        scales: {
                            y: {
                            beginAtZero: true
                            }
                        }
                        }
                    });

                    const ctx2 = document.getElementById('myChart2');


                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                        labels: <?= json_encode($libelle)?>,
                        datasets: [{
                            label: 'Hospitalisations',
                            data: <?= json_encode($nbre)?>,
                            borderWidth: 1,
                            hoverOffset: 4
                        }]
                        },

                    
                        options: {
                        scales: {
                            y: {
                            beginAtZero: true
                            }
                        }
                        }
                    });
                </script>
            </div>
        </div>
    </section>
    
</body>
</html>