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

    $admissions = $DB->prepare("SELECT hospitalisation.id, Date_hospitalisation, Pre_admission, Heure_intervention, hospitalisation.Num_secu, personnel.Nom, personnel.Prenom, patient.Nom_Naissance, patient.Prenom FROM clinique.hospitalisation inner join patient on hospitalisation.Num_secu = patient.Num_secu
    inner join personnel on personnel.Code_personnel = hospitalisation.code_personnel
    WHERE statut = 'A faire' and hospitalisation.Date_hospitalisation >= '$jourDebutSemaine' and hospitalisation.Date_hospitalisation <= '$jourDernierCinqiemeSemaine'
    and hospitalisation.code_personnel = ?");
    $admissions->execute(array($_GET['id']));
    $admissions = $admissions->fetchAll();

    $medecin = $DB->prepare("SELECT Nom, Prenom from personnel where Code_personnel = ?");
    $medecin->execute(array($_GET['id']));
    $medecin = $medecin->fetch();

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
        <h1>Admissions pour le médecin <span style="color: #3246D3;"><?= $medecin['Nom']?></span></h1>
        <div class="panel">

            <div class="admissions">
              
            <p>Pour les 5 prochaines semaines :</p>

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
                    <a href="hospitalisation_update.php?id=<?= $liste2['id']?>">Modifier</a>
                    <a style="background-color: #ef233c;" href="hospitalisation_delete.php?id=<?= $liste2['id']?>">Supprimer</a>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </section>
    
</body>
</html>