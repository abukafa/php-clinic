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
$pdf->Cell(0,0.7,'DATA PASIEN RAWAT JALAN',0,1,'C');
if(isset($_GET['tgl_awal'])){    
    $tgl_awal = $_GET['tgl_awal'];
    $tgl_ahir = $_GET['tgl_ahir'];
    $pdf->Cell(0,0.7, $tgl_awal . " - " . $tgl_ahir ,0,1,'C');
    $query = "SELECT * FROM pasien WHERE tgl_reg BETWEEN '$tgl_awal' AND '$tgl_ahir' ORDER BY tgl_reg DESC";
}else{
    $pdf->Cell(0,0.7, date('D, d M Y') ,0,1,'C');
    $query = "SELECT * FROM pasien ORDER BY tgl_reg DESC";
}

$pdf->ln(0.5);
$pdf->SetFillColor(193,229,252);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Tgl Reg', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'No. RM', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Nama', 1, 0, 'C');
$pdf->Cell(0.75, 0.8, 'LP', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Umur', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Status', 1, 0, 'C');
$pdf->Cell(4.25, 0.8, 'Penanggung', 1, 0, 'C');
$pdf->Cell(2.5, 0.8, 'No. Telp', 1, 0, 'C');
$pdf->Cell(8, 0.8, 'Alamat', 1, 1, 'C');

$pdf->SetFont('Arial','',8);
$no=1;
$pasien = myquery($query);
foreach( $pasien as $pas ) :
$id = $pas['id'];

$pdf->Cell(1, 0.7, $no, 1, 0, 'C');
$pdf->Cell(2, 0.7, $pas['tgl_reg'], 1, 0, 'C');
$pdf->Cell(2, 0.7, $pas['id'], 1, 0, 'C');
$pdf->Cell(4, 0.7, $pas['nama'], 1, 0, '');
$jk = $pas['jk'] == "Laki-laki" ? "L" : "P";
$pdf->Cell(0.75, 0.7, $jk, 1, 0, 'C');
$lahir = date_format(date_create($pas['tgl_lahir']), 'Y');
$umur = date('Y') - $lahir;
$pdf->Cell(1.5, 0.7, $umur, 1, 0, 'C');
$pdf->Cell(1.5, 0.7, $pas['status'], 1, 0, 'C');
$pdf->Cell(1.25, 0.7, $pas['pj'], 'L,T,B', 0, 'L');
$pdf->Cell(3, 0.7, ': ' . $pas['nama_pj'], 'T,R,B', 0, 'L');
$pdf->Cell(2.5, 0.7, $pas['telepon'], 1, 0, 'C');
$pdf->Cell(8, 0.7, $pas['alamat'], 1, 1, '');

$no++;
endforeach;

$pdf->Output("Data-Pasien.pdf","I");
?>