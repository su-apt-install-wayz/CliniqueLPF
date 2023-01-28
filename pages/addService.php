<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            $service = $DB->prepare("SELECT * FROM service where libelle=?");
            $service->execute([$libelle]);
            $service = $service->fetch();

            if (isset($service['libelle'])) {
                $erreur = '<ul class="notifications">
                <li class="toast error">
                    <div class="column">
                        <span class="material-icons-round icon-notif">error</span>
                        <span class="message-notif">Ce service existe déjà.</span>
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
                $insert_service = $DB->prepare("INSERT INTO service (libelle) VALUES(?);");
                $insert_service->execute([$libelle]);

                $erreur = '<ul class="notifications">
                <li class="toast success">
                    <div class="column">
                        <span class="material-icons-round icon-notif">check_circle</span>
                        <span class="message-notif">Service créé avec succès.</span>
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

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][1])?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <h1>Ajouter un service</h1>
        <form action="" method="post">
            <?= $erreur?>
            <input style="margin: auto; max-width: 500px;" type="text" class="grand" required placeholder="Nom du service" name="libelle">
            <input style="margin: 30px auto 0; max-width: 500px;" type="submit" name="submit" value="Créer le service">
        </form>
    </section>
    
</body>
</html>