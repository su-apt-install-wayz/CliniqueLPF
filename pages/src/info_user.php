<?php
    error_reporting(E_ALL);
	ini_set("display_errors", 1);

    include_once('../include.php');

    switch ($_SESSION['personnel'][6]) {
        case "Secrétaire":
            $rang_utilisateur = array(1, 'Secrétaire');
            break;
        
        case "Médecin":
            $rang_utilisateur = array(2, 'Médecin');
            break;

        case "Administrateur":
            $rang_utilisateur = array(3, 'Administrateur');
            break;

        default:
            $rang_utilisateur = array(4, 'Aucun accès au site');
    }
?>