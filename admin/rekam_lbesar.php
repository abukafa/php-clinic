<?php
require('../assets/pdf/fpdf.php');
require 'functions.php';

$pdf = new FPDF("P","cm","A4");
$pdf->SetMargins(1,0,0,0);
$pdf->SetAutoPageBreak(true);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../img/kop.png',1,0.6,13.5,1.5); 
$pdf->Line(1,2.2,20,2.2);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,2.3,20,2.3);   
$pdf->SetLineWidth(0);

$pdf->ln(3);
$pdf->SetFont('Arial','B',14);

$pdf->Cell(0,0.7,'10 BESAR PENYAKIT',0,1,'C');
$pdf->SetFont('Arial','B',11);
$query = "SELECT icd, diagnosa, COUNT(*) as num FROM `periksa` GROUP BY icd ORDER BY num DESC LIMIT 10";
if($_GET['tgl']<>""){  
    $a = $_GET['tgl'];
    $n = date('Y-m-d');
    $pdf->Cell(0,0.7, $a . " - " . $n ,0,1,'C');
}else{
    $pdf->Cell(0,0.7, "Update : ". date('d M Y') ,0,1,'C');
}

// $pdf->Cell(1, 0, $query, 1, 0, 'L');
// var_dump($query);
$pdf->ln(0.5);
$pdf->SetFillColor(193,229,252);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1, 0.9, 'No', 1, 0, 'C');
$pdf->Cell(2, 0.9, 'ICD-10', 1, 0, 'C');
$pdf->Cell(14, 0.9, 'Diagnosa', 1, 0, 'C');
$pdf->Cell(2, 0.9, 'Jumlah', 1, 1, 'C');

$no=1;
$periksa = myquery($query);
foreach( $periksa as $per ):
$pdf->SetFont('Arial','',8);
$pdf->Cell(1, 0.8, $no, 1, 0, 'C');
$pdf->Cell(2, 0.8, $per['icd'], 1, 0, 'C');
$pdf->Cell(14, 0.8, $per['diagnosa'], 1, 0, 'L');
$pdf->Cell(2, 0.8, $per['num'], 1, 1, 'C');
$no++;
endforeach;

$pdf->Output("Rekap-RM.pdf","I");
?>