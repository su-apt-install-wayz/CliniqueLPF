<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";
    $pop = "";

    $personnel_liste = $DB->prepare("SELECT * FROM personnel where Nom !=? and Prenom!=?");
    $personnel_liste->execute([$_SESSION['personnel'][1], $_SESSION['personnel'][2]]);
    $personnel_liste = $personnel_liste->fetchAll();

    $personnel_ad = $DB->prepare("SELECT * FROM hospitalisation inner join personnel on personnel.Code_personnel = hospitalisation.code_personnel where Identifiant = ?");
    $personnel_ad->execute(array($_SESSION['personne']));
    $personnel_ad = $personnel_ad->fetch();

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {   
            $pop = '<div class="popup">
            <form action="" class="pop" method="post">
                <h2>Etes-vous sûr de vouloir supprimer cette personne ?</h2>
                <input style="background: #ef233c;" type="submit" name="delPerson" value="Oui">
                <input style="background: #3246D3;" type="submit" name="non" value="Non">
                </form></div>';
                $_SESSION['personne'] = $personnel;
        }

        if (isset($_POST['delPerson'])) {

            if(isset($personnel_ad['code_personnel'])) {
                $erreur = '<ul class="notifications">
                    <li class="toast error">
                        <div class="column">
                            <span class="material-icons-round icon-notif">error</span>
                            <span class="message-notif">Le personnel a encore des admissions.</span>
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
                $delete_personnel = $DB->prepare("DELETE FROM personnel WHERE Identifiant=?;");
                $delete_personnel->execute([$_SESSION['personne']]);

                $erreur = '<ul class="notifications">
                    <li class="toast success">
                        <div class="column">
                            <span class="material-icons-round icon-notif">check_circle</span>
                            <span class="message-notif">Personnel supprimé avec succès.</span>
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

    <script src="../js/valeur_input.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= htmlspecialchars($_SESSION['personnel'][2])?> 👋</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <?= $pop?>
    <section class="global">
        <h1>Retirer un personnel</h1>
        <?= $erreur?>
        <form action="" method="post">
            <select class="moyen" style="margin: 30px auto 0; max-width: 500px;" size='1' name="personnel" required='required'>
                <?php 
                    foreach ($personnel_liste as $personnel) {
                ?>
                        <option value="<?= $personnel['Identifiant']?>"><?= $personnel['Nom']." "?><?= $personnel['Prenom']. " : "?><?= $personnel['role']?></option>
                <?php
                    }
                ?>
            </select>

            <input style="margin: 30px auto 0; max-width: 500px; background: #ef233c;" type="submit" name="submit" value="Supprimer le personnel">
        </form>
    </section>
    
</body>
</html>