<?php
require('../assets/pdf/fpdf.php');

$pdf = new FPDF("L","cm",array(5.5,9));

$pdf->SetMargins(1,0,0,0);
$pdf->SetAutoPageBreak(true);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../img/pc-f.png',0,0,9,5.5); 
$pdf->ln(4.25);
$pdf->SetFont('Arial','B',10);
$pdf->cell(7.8,0.5,'Mariyah Alqibthiyah',0,1,'R');
$pdf->cell(7.8,0.5,'20220078',0,1,'R');

$pdf->AddPage();
$pdf->Image('../img/pc-b.png',0,0,9,5.5); 

$pdf->Output("Kartu-" . ".pdf","I");
?>