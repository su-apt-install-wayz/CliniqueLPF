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

    $finCinqiemeSemaine = strtotime("+4 weeks", strtotime($jourFinSemaine));
    $jourDernierCinqiemeSemaine = date("Y-m-d", $finCinqiemeSemaine);   


    $admissions = $DB->prepare("SELECT hospitalisation.id, Date_hospitalisation, Pre_admission, Heure_intervention, hospitalisation.Num_secu, personnel.Nom, patient.Nom_Naissance, patient.Prenom FROM clinique.hospitalisation inner join patient on hospitalisation.Num_secu = patient.Num_secu
    inner join personnel on personnel.Code_personnel = hospitalisation.code_personnel
    WHERE statut = 'A faire' and personnel.role = 'Médecin' and hospitalisation.Date_hospitalisation >= '$jourDebutSemaine' and hospitalisation.Date_hospitalisation <= '$jourDernierCinqiemeSemaine';");
    $admissions->execute();
    $admissions = $admissions->fetchAll();

    $stats = $DB->prepare("SELECT distinct count(hospitalisation.Num_secu) as nbr_patient , personnel.Nom , service.libelle , hospitalisation.code_personnel from hospitalisation
    inner join personnel on personnel.Code_personnel=hospitalisation.code_personnel 
    inner join service on service.id=personnel.Service  where statut = 'A faire' and hospitalisation.Date_hospitalisation >= '$jourDebutSemaine' and hospitalisation.Date_hospitalisation <= '$jourDernierCinqiemeSemaine'
    group by hospitalisation.code_personnel;");
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
        <h1>Liste des médecins</h1>
        <div class="panel">
  
            <div class="cards">
                <?php
                    foreach ($stats as $liste) {
                ?>
                <a href="admissions_medecin.php?id=<?=$liste['code_personnel']?>">
                    <div class="card">
                        <h2>Dr. <?= $liste['Nom']?></h2>
                        <h5 class="prof"><?= $liste['libelle']?></h5>
                        <h5 class="count"><p><?= $liste['nbr_patient']?> <span>hospitalisation(s)</span></p></h5>
                    </div>
                </a>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
    
</body>
</html>