<?php

require('../fpdf/fpdf.php');
require_once('./src/info_user.php');

$dateSaisie = strtotime($_POST['date']);
$serviceChoisi = $_POST['service'];


$semChoix=date('W', $dateSaisie);
$anneeChoix=date('Y');

$timeStampPremierJanvier = strtotime($anneeChoix . '-01-01');
$jourPremierJanvier = date('w', $timeStampPremierJanvier);

//-- recherche du N° de semaine du 1er janvier -------------------
$numSemainePremierJanvier = date('W', $timeStampPremierJanvier);

//-- nombre à ajouter en fonction du numéro précédent ------------
$decallage = ($numSemainePremierJanvier == 1) ? $semChoix - 1 : $semChoix;
//-- timestamp du jour dans la semaine recherchée ----------------
$timeStampDate = strtotime('+' . $decallage . ' weeks', $timeStampPremierJanvier);
//-- recherche du lundi de la semaine en fonction de la ligne précédente ---------
$jourDebutSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d', strtotime('last monday', $timeStampDate));
$jourFinSemaine = ($jourPremierJanvier == 1) ? date('Y-m-d', $timeStampDate) : date('Y-m-d',strtotime('sunday', $timeStampDate));

$stats = $DB->prepare("
select patient.Num_secu, patient.Nom_naissance, patient.Prenom, hospitalisation.Date_hospitalisation, hospitalisation.Heure_intervention, hospitalisation.Pre_admission, personnel.Nom, service.libelle from service
inner join personnel on service.id = personnel.Service
inner join hospitalisation on personnel.Code_personnel = hospitalisation.code_personnel
inner join patient on hospitalisation.Num_secu = patient.Num_secu
where service.libelle = ? AND hospitalisation.Date_hospitalisation >= '$jourDebutSemaine' and hospitalisation.Date_hospitalisation <= '$jourFinSemaine';");
$stats->execute(array($serviceChoisi));
$stats = $stats->fetchAll();

$stats2 = $DB->prepare("
select patient.Num_secu, patient.Nom_naissance, patient.Prenom, hospitalisation.Date_hospitalisation, hospitalisation.Heure_intervention, hospitalisation.Pre_admission, personnel.Nom, service.libelle from service
inner join personnel on service.id = personnel.Service
inner join hospitalisation on personnel.Code_personnel = hospitalisation.code_personnel
inner join patient on hospitalisation.Num_secu = patient.Num_secu
where service.libelle = ? AND hospitalisation.Date_hospitalisation >= '$jourDebutSemaine' and hospitalisation.Date_hospitalisation <= '$jourFinSemaine';");
$stats2->execute(array($serviceChoisi));
$stats2 = $stats2->fetch();





$pdf = new FPDF('L','mm','A3');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,"Liste des Pre-admissions pour le service : ".$stats2['libelle'],0,1,'C');
$pdf->Cell(0,10,"Semaine du : ".$jourDebutSemaine." au ".$jourFinSemaine,0,1,'C');
$pdf->Cell(60,10,"Nom : ",1,0,'C');
$pdf->Cell(60,10,"Prenom : ",1,'','C');
$pdf->Cell(60,10,"Type : ",1,0,'C');
$pdf->Cell(60,10,"Num secu : ",1,0,'C');
$pdf->Cell(40,10,"Date : ",1,0,'C');
$pdf->Cell(40,10,"Heure : ",1,0,'C');
$pdf->Cell(60,10,"Medecin : ",1,1,'C');

foreach($stats as $liste2){

    $pdf->Cell(60,10,utf8_decode($liste2['Nom_naissance']),1,0,'C');
    $pdf->Cell(60,10,utf8_decode($liste2['Prenom']),1,'','C');
    $pdf->Cell(60,10,$liste2['Pre_admission'],1,0,'C');
    $pdf->Cell(60,10,$liste2['Num_secu'],1,0,'C');
    $pdf->Cell(40,10,$liste2['Date_hospitalisation'],1,0,'C');
    $pdf->Cell(40,10,$liste2['Heure_intervention'],1,0,'C');
    $pdf->Cell(60,10,utf8_decode($liste2['Nom']),1,1,'C');
 
    
}
$pdf->Output();
?>