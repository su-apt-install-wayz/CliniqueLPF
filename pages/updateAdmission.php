<?php 

    include_once('../include.php');

    $_SESSION['patient'] = array();
    $_SESSION['prevenir'] = array();
    $_SESSION['confiance'] = array();
    $_SESSION['couverture'] = array();
    $_SESSION['hospitalisation'] = array();

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    $erreur = "";

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {

            function is_secsocnum($num_secu){
                // que des chiffres 
                $num_secu = preg_replace("/[^0-9]/", "", $num_secu); 
                 // 13 chiffres + 2 de cle. 
                if ((strlen($num_secu) != 13) && (strlen($num_secu) != 15)) { return 0;} 
                // premier chiffre : sexe : un ou deux 
                if (($num_secu[0] == 0) || ( $num_secu[0] > 2)){ return 0;} 
                // deux chiffres suivants : annee de naissance 
                // deux chiffres suivants : mois de naissance, entre 1 et 12 
                if (!in_array(substr($num_secu, 3, 2), range(1, 12))){ return 0;} 
                 
                return true;
            }

            if (is_secsocnum($num_secu) ) {

                $hospi = $DB->prepare("SELECT * FROM hospitalisation WHERE Num_secu = ?");
                $hospi->execute(array($num_secu));
                $hospi = $hospi->fetch();

                if(isset($hospi['Num_secu'])) {
                    $_SESSION['hospitalisation'] = array(
                        $hospi['Date_hospitalisation'], //0
                        $hospi['Pre_admission'], //1
                        $hospi['Heure_intervention'], //2
                        $hospi['code_personnel'], //3
                        $num_secu); //4  

                    header('Location: hospitalisation_update');
                    exit; 
                }
                else {
                    $erreur = '<ul class="notifications">
                                    <li class="toast error">
                                        <div class="column">
                                            <span class="material-icons-round icon-notif">error</span>
                                            <span class="message-notif">Pas de préadmission pour ce patient.</span>
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

    <title>Bon retour <?= $_SESSION['personnel'][1]?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">
        <form style="margin:auto; width: 100%; max-width: 500px;" action="" method="post">
            <label style="margin:auto;" for="num_secu">Numéro de sécurité sociale :</label><br>
            <input style="margin:auto;" class="moyen" type="text" name="num_secu" id="num_secu" maxlength="15" required="required"><br>

            <input style="margin:auto;" class="btn-envoi moyen" type="submit" value="Rechercher" name="submit">
            <div class="erreur"><?= $erreur?></div>
        </form>
    </section>
    
</body>
</html>