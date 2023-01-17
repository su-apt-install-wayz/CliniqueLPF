<?php
    error_reporting(E_ALL);
	ini_set("display_errors", 1);

    include_once('../include.php');

    switch ($_SESSION['personnel'][5]) {
        case "secretaire":
            $rang_utilisateur = array(0, 'Utilisateur');
            break;
        
        case "medecin":
            $rang_utilisateur = array(1, 'Modérateur');
            break;

        case "admin":
            $rang_utilisateur = array(2, 'Administrateur');
            break;

        case 3:
            $rang_utilisateur = array(3, 'Super Administrateur');
            break;

        default:
            $rang_utilisateur = array(4, 'Aucun accès au site');
    }
?>