<?php
    error_reporting(E_ALL);
	ini_set("display_errors", 1);

    include_once('../include.php');

    switch ($_SESSION['personnel'][5]) {
        case "secretaire":
            $rang_utilisateur = array(1, 'Secrétaire');
            break;
        
        case "medecin":
            $rang_utilisateur = array(2, 'Médecin');
            break;

        case "admin":
            $rang_utilisateur = array(3, 'Administrateur');
            break;

        default:
            $rang_utilisateur = array(4, 'Aucun accès au site');
    }
?>