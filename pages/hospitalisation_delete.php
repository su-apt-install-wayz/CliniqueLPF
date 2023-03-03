<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";
    $pop = "";

    $medecin= $DB->prepare("SELECT * FROM personnel where Code_personnel=?");
    $medecin->execute(array($_SESSION['hospitalisation'][3]));
    $medecin = $medecin->fetch();

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            $pop = '<div class="popup">
            <form action="" class="pop" method="post">
                <h2>Etes-vous sûr de vouloir supprimer cette hospitalisation ?</h2>
                <input style="background: #ef233c;" type="submit" name="delAdmission" value="Oui">
                <input style="background: #3246D3;" type="submit" name="non" value="Non">
                </form></div>';
            
        }

        if (isset($_POST['delAdmission'])) {
            $delete_admission = $DB->prepare("DELETE FROM hospitalisation WHERE id=? and Num_secu=?;");
            $delete_admission->execute(array($_SESSION['hospitalisation'][5], $_SESSION['hospitalisation'][4]));
            
            $erreur ='<ul class="notifications">
                    <li class="toast success">
                        <div class="column">
                            <span class="material-icons-round icon-notif">check_circle</span>
                            <span class="message-notif">Admission supprimée avec succès.</span>
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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>
    
    <?= $pop?>
    <section class="global">
        <?= $erreur?>
        <form action="" method="post">
            <label for="pre-admission">Pré-admission :</label>
            <select class="moyen" name="pre_admission" id="pre_admission" disabled required="required">
                <option value="<?= $_SESSION['hospitalisation'][1]?>"><?= $_SESSION['hospitalisation'][1]?></option>

            </select><br>

            <label for="date-hospitalisation">Date d'hospitalisation</label>
            <input class="petit" value="<?= $_SESSION['hospitalisation'][0]?>" disabled type="date" name="date_hospitalisation" id="date_hospitalisation" required="required">

            <br>

            <label for="heure-intervention">Heure d'intervention</label>
            <input class="petit" value="<?= $_SESSION['hospitalisation'][2]?>" disabled type="time" name="heure_intervention" id="heure_intervention" required="required">

            <br>

                    
            <label for="nom-medecin">Nom du medecin</label>
            <select class="moyen" name='nom_medecin' size='1' id='nom_medecin' disabled required='required'>
                <option value="<?= $medecin['Nom']?>"><?= $medecin['Nom']?></option>
            </select><br>
        

            <input class="btn-envoi" style="background-color: #ef233c;" type="submit" value="Supprimer l'admission" name="submit">
        </form>
    </section>
    
</body>
</html>