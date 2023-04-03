<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";

    $admission = $DB->prepare("SELECT * from hospitalisation where id = ?;");
    $admission->execute(array($_GET['id']));
    $admission = $admission->fetch();

    $medecins_liste = $DB->prepare("SELECT * FROM personnel where role='medecin' and Code_personnel!=?");
    $medecins_liste->execute(array($admission['code_personnel']));
    $medecins_liste = $medecins_liste->fetchAll();

    $medecin= $DB->prepare("SELECT * FROM personnel where Code_personnel=?");
    $medecin->execute(array($admission['code_personnel']));
    $medecin = $medecin->fetch();

    $aujourdhui = date("Y-m-d");
    $futur=date('Y-m-d', strtotime('+1 year'));

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            $code_personnel = $DB->prepare("SELECT * FROM personnel WHERE Nom = ?");
            $code_personnel->execute(array($nom_medecin));
            $code_personnel = $code_personnel->fetch();

            $update_admission = $DB->prepare("UPDATE hospitalisation SET Date_hospitalisation=?, Pre_admission=?, Heure_intervention=?, code_personnel=? WHERE id=?;");
            $update_admission->execute(array($date_hospitalisation, $pre_admission, $heure_intervention, $code_personnel['Code_personnel'], $admission['id']));
            
            $erreur ='<ul class="notifications">
            <li class="toast success">
                <div class="column">
                    <span class="material-icons-round icon-notif">check_circle</span>
                    <span class="message-notif">Admission modifiée avec succès.</span>
                </div>
                <span class="material-icons-outlined icon-notif close" onclick="remove()">close</span>
            </li>
        </ul>
        <script>
            const toast = document.querySelector(".toast");

            function hideToast() {
                setTimeout(function() {
                    toast.classList.add("hide")
                }, 5000);
            }

            function remove() {
                toast.classList.add("hide");
            }

            hideToast();
        </script>';
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/notification.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <?= $erreur?>
        <form action="" method="post">
            <label for="pre-admission">Pré-admission :</label>
            <select class="moyen" name="pre_admission" id="pre_admission" required="required">
                <option value="<?= $admission['Pre_admission']?>"><?= $admission['Pre_admission']?></option>
                <?php
                    if($admission['Pre_admission']== 'Ambulatoire') {
                ?>
                        <option value="Hospitalisation" >Hospitalisation</option> 
                <?php
                    }
                    else {
                ?>
                        <option value="Ambulatoire" >Ambulatoire</option>
                        <option value="Non" >Non</option>
                <?php
                    }
                ?>


            </select><br>

            <!-- <label for="num-secu">Numéro de sécurité sociale :</label><br>
            <input type="text" name="num-secu" id="num-secu" maxlength="15" required="required"><br> -->

            <label for="date-hospitalisation">Date d'hospitalisation</label>
            <input class="petit" value="<?= $admission['Date_hospitalisation']?>" type="date" name="date_hospitalisation" min="<?= $aujourdhui?>" max="<?= $futur?>" id="date_hospitalisation" required="required">

            <br>

            <label for="heure-intervention">Heure d'intervention</label>
            <input class="petit" value="<?=$admission['Heure_intervention']?>" type="time" name="heure_intervention" id="heure_intervention" required="required">

            <br>

                    
            <label for="nom-medecin">Nom du medecin</label>
            <select class="moyen" name='nom_medecin' size='1' id='nom_medecin' required='required'>
                <option value="<?= $medecin['Nom']?>"><?= $medecin['Nom']?></option>
                <?php 
                    foreach ($medecins_liste as $liste) {
                ?>
                <option value="<?= $liste['Nom']?>"><?= $liste['Nom']?></option>
                <?php
                    }
                ?>
            </select><br>
        

            <input class="btn-envoi" type="submit" value="Modifier l'admission" name="submit">
        </form>
    </section>
    
</body>
</html>