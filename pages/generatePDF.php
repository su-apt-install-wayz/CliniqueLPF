<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $services_liste = $DB->prepare("SELECT * FROM service");
    $services_liste->execute();
    $services_liste = $services_liste->fetchAll();    
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
        <h1>Générer un PDF</h1>

        <form action="newPDF.php" method="post">
            <input class="petit" style="margin: 30px auto 0; max-width: 500px;" type="date" name="date" id="date" required="required">

            <select class="petit" style="margin: 30px auto 0; max-width: 500px;" name='service' size='1' id='service' required='required'>
                <?php 
                    foreach ($services_liste as $services) {
                ?>
                        <option value="<?= $services['libelle']?>" n><?= $services['libelle']?></option>
                <?php
                    }
                ?>
            </select>
            <input type="submit" style="margin: 30px auto 0; max-width: 500px;" value="Générer PDF"/>  
        </form>
    </section>
    
</body>
</html>