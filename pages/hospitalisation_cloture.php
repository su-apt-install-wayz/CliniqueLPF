<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index.php');
        exit;
    }

    require_once('./src/info_user.php');

    $cloture = $DB->prepare("UPDATE hospitalisation SET statut='Terminé' WHERE id= ?;");
    $cloture->execute(array($_GET['id']));
    $cloture = $cloture->fetch();

    header('Location: panel.php');
    exit;
?>