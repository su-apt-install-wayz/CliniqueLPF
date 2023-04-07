<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";
    $pop = "";

    $services_liste = $DB->prepare("SELECT * FROM service");
    $services_liste->execute();
    $services_liste = $services_liste->fetchAll();

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            $pop = '<div class="popup">
            <form action="" class="pop" method="post">
                <h2>Etes-vous sûr de vouloir supprimer le service ?</h2>
                <input style="background: #ef233c;" type="submit" name="delService" value="Oui">
                <input style="background: #3246D3;" type="submit" name="non" value="Non">
                </form></div>';
                $_SESSION['service'] = $service;
        }

        if (isset($_POST['delService'])) {

            $service_rempli = $DB->prepare("SELECT hospitalisation.code_personnel from hospitalisation inner join personnel on personnel.Code_personnel = hospitalisation.code_personnel
            inner join service on personnel.Service = service.id where service.libelle = ? ");
            $service_rempli->execute(array($_SESSION['service']));
            $service_rempli = $service_rempli->fetch();

            if(isset($service_rempli['code_personnel'])) {
                $erreur = '<ul class="notifications">
                    <li class="toast error">
                        <div class="column">
                            <span class="material-icons-round icon-notif">error</span>
                            <span class="message-notif">Le service contient des médecins.</span>
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

            else {

                $delete_service = $DB->prepare("DELETE FROM service WHERE libelle=?;");
                $delete_service->execute([$_SESSION['service']]);

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

    <?= $pop?>
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
            <input style="margin: 30px auto 0; max-width: 500px; background: #ef233c;" type="submit" name="submit" value="Supprimer le service">
        </form>
    </section>
    
</body>
</html>