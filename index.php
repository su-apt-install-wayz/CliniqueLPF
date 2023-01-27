<?php
    error_reporting(E_ALL);
	ini_set("display_errors", 1);
    include_once('include.php');

    $nombre = random_int(1000, 9999);
    $notif = "";

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['connexion'])) {
            if ($_SESSION['captcha'] == $captcha) {
                [$erreur] = $_CONNEXION->connexion_user($identifiant, $password);
            }
            else {
                $notif = '<ul class="notifications">
                <li class="toast error">
                    <div class="column">
                        <span class="material-icons-round icon-notif">error</span>
                        <span class="message-notif">Captcha incorrect.</span>
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

    $_SESSION['captcha'] = $nombre;
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('./include/link.php') ?>

    <link rel="stylesheet" href="css/formulaire.css">
    <link rel="stylesheet" href="css/notification.css">
    <link rel="shortcut icon" href="./images/public/LPF.svg" type="image/x-icon">

    <title>Clinique LPF</title>

</head>

    <body>
        <div class="left">
            <h1 class="logo">Clinique <span>LPF</span></h1>
            <form method="POST">
                <h1>Se connecter 🖐</h1>
                <p>Renseignez votre identifiant pour continuer sur le panel.</p>
                <label for="identifiant">Votre identifiant</label>

                <?php if(isset($erreur)) { echo $erreur; } ?>
                <?= $notif?>
                <input type="text" name="identifiant" id="identifiant" maxlength="20">

                <label for="password">Votre mot de passe</label>
                <div class="div-input">
                    <input type="password" name="password" id="password" maxlength="32">
                    <span class="material-icons-outlined" onclick='toggle()'>visibility</span>
                </div>
                <label for="captcha">Vérifie zebi</label>
                <div class="div-input">
                    <input type="text" name="captcha" id="captcha" maxlength="4">
                    <div class="captcha"><?= $nombre?></div>
                </div>

                <input type="submit" name="connexion" value="Se connecter">
            </form>
        </div>
        <div class="right">
            <img src="./images/public/right.png" alt="">
        </div>

        <script src="./js/password.js"></script>
        
    </body>

</html>