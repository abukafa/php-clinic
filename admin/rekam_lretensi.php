<?php
require('../assets/pdf/fpdf.php');
require 'functions.php';

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../img/kop.png',1,0.6,18.5 ,2); 
$pdf->Line(1,2.7,28.5,2.7);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,2.8,28.5,2.8);   
$pdf->SetLineWidth(0);

$pdf->ln(2.2);
$pdf->SetFont('Arial','B',14);
$m=date('m');
if ($m >= 07 and $m <= 12) {
$y2=date('Y');
}else{
$y2=date('Y')-1;
}
$pdf->Cell(0,0.7,'DATA RETENSI REKAM MEDIS',0,1,'C');
$pdf->SetFont('Arial','B',11);
$bln = $_GET['bln'];
$tglAhir = date('Y-m-d', strtotime('-'.$bln.' month'));
// $pdf->Cell(0,0.5, 'Tanggal Akhir : '. indo_date(date_create($tglAhir),'j F Y', '') ,0,1,'C');
$pdf->Cell(0,0.5, 'Tanggal Akhir : '. date_format(date_create($tglAhir), 'j M Y') ,0,1,'C');

// $pdf->Cell(1, 0, $query, 1, 0, 'L');
// var_dump($query);
$pdf->ln(0.5);
$pdf->SetFillColor(193,229,252);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'NRM', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Nama', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'LP', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Umur', 1, 0, 'C');
$pdf->Cell(2.25, 0.8, 'Tgl Akhir', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Poliklinik', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Pemeriksa', 1, 0, 'C');
$pdf->Cell(8.75, 0.8, 'Diagnosa', 1, 1, 'C');

$no=1;
$query = "SELECT max(daftar.tanggal) as tgl, daftar.id, daftar.id_pasien, daftar.pasien, daftar.jk, daftar.tgl_lahir, daftar.poli, periksa.icd, periksa.diagnosa, periksa.user FROM daftar INNER JOIN periksa ON periksa.id_daftar=daftar.id WHERE tanggal < '$tglAhir' GROUP BY id_pasien ORDER BY tgl DESC";
$daftar = myquery($query);
foreach( $daftar as $daf ):
$id=$daf['id'];
$pdf->SetFont('Arial','',8);
$pdf->Cell(1, 0.7, $no, 1, 0, 'C');
$pdf->Cell(2, 0.7, $daf['id_pasien'], 1, 0, 'C');
$pdf->Cell(4, 0.7, $daf['pasien'], 1, 0, '');
$jk = $daf['jk'] == "Laki-laki" ? "L" : "P";
$pdf->Cell(1, 0.7, $jk, 1, 0, 'C');
$lahir = date_format(date_create($daf['tgl_lahir']), 'Y');
$umur = date('Y') - $lahir;
$pdf->Cell(1.5, 0.7, $umur, 1, 0, 'C');
$pdf->Cell(2.25, 0.7, $daf['tgl'], 1, 0, 'C');
$pdf->Cell(3, 0.7, $daf['poli'], 1, 0, 'C');
$pdf->Cell(4, 0.7, $daf['user'], 1, 0, 'C');
$pdf->Cell(8.75, 0.7, $daf['icd'] ." - ". substr($daf['diagnosa'], 0, 55) ."..", 1, 1, '');
$no++;
endforeach;

$pdf->Output("Rekap-RM.pdf","I");
?>