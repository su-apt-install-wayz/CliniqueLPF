<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $semChoix=date('W');
    $anneeChoix=date('Y');

    $timeStampPremierJanvier = strtotime($anneeChoix . '-01-01');
    $jourPremierJanvier = date('w', $timeStampPremierJanvier);
    
    //-- recherche du N° de semaine du 1er janvier -------------------
    $numSemainePremierJanvier = date('W', $timeStampPremierJanvier);
    
    //-- nombre à ajouter en fonction du numéro précédent ------------
    $decallage = ($numSemainePremierJanvier == 1) ? $semChoix - 1 : $semChoix;
    //-- timestamp du jour dans la semaine recherchée ----------------
    $timeStampDate = strtotime('+' . $decallage . ' weeks', $timeStampPremierJanvier);
    //-- recherche du lundi de la semaine en fonction de la ligne précédente ---------
    $jourDebutSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d', strtotime('last monday', $timeStampDate));
    $jourFinSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d',strtotime('sunday', $timeStampDate));

    $stats = $DB->prepare("select distinct count(hospitalisation.Num_secu) as nbr_patient , service.libelle from hospitalisation 
    inner join personnel on personnel.Code_personnel=hospitalisation.code_personnel 
    inner join service on service.id=personnel.Service where hospitalisation.Date_hospitalisation >= '$jourDebutSemaine' and hospitalisation.Date_hospitalisation <= '$jourFinSemaine'
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


    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</h1>
        <div class="panel">
            <p>Pour cette semaine :</p>
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

                    
                        scales: {

                        yAxes: [{
                        beginAtZero: true,
                        gridLines:{
                        display:false
                        }
                        }]

                        }
                    });
                </script>
            </div>
        </div>
    </section>
    
</body>
</html>