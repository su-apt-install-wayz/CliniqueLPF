<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";

    $services_liste = $DB->prepare("SELECT * FROM service");
    $services_liste->execute();
    $services_liste = $services_liste->fetchAll();

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            $delete_service = $DB->prepare("DELETE FROM service WHERE libelle=?;");
            $delete_service->execute([$service]);

            $erreur = '<ul class="notifications">
            <li class="toast success">
                <div class="column">
                    <span class="material-icons-round icon-notif">check_circle</span>
                    <span class="message-notif">Service supprimé avec succès.</span>
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

    <section class="global">
        <h1>Supprimer un service</h1>
        <form action="" method="post">
            <?= $erreur?>
            <select class="moyen" style="margin: 30px auto 0; max-width: 500px;" name='service' size='1' id='service' required='required'>
                <?php 
                    foreach ($services_liste as $services) {
                ?>
                        <option value="<?= $services['libelle']?>"><?= $services['libelle']?></option>
                <?php
                    }
                ?>
            </select>
            <input style="margin: 30px auto 0; max-width: 500px;" type="submit" name="submit" value="Supprimer le service">
        </form>
    </section>
    
</body>
</html>