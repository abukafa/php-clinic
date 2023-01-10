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
// $m=date('m');
// if ($m >= 07 and $m <= 12) {
// $y2=date('Y');
// }else{
// $y2=date('Y')-1;
// }
$pdf->Cell(0,0.7,'DATA OBAT KELUAR',0,1,'C');
$pdf->SetFont('Arial','B',11);
if(isset($_GET['tgl'])){  
    if($_GET['tgl'] <> ""){
        $a = $_GET['tgl'];  
        $n = date('Y-m-d');
        $filTgl = date_format(date_create($a), 'j M Y') ." s.d. ". date_format(date_create($n), 'j M Y');
        $query = "SELECT * FROM `keluar` WHERE tanggal BETWEEN '$a' AND '$n' UNION SELECT id, tanggal, id_pasien, kode, nama, jenis, tarif, qty, jumlah, note, apoteker FROM `tindak` WHERE LEFT(kode,1)='R' AND tanggal BETWEEN '$a' AND '$n' ORDER BY tanggal DESC";
    }
}

$pdf->Cell(0,0.6, $filTgl ,0,1,'C');

// $pdf->Cell(1, 0, $query, 1, 0, 'L');
// var_dump($query);
$pdf->ln(0.5);
$pdf->SetFillColor(193,229,252);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1, 0.8, 'No', 1, 0, 'C');
$pdf->Cell(2.25, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'NRM', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Kode', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Merk Obat', 1, 0, 'C');
$pdf->Cell(8.25, 0.8, 'Kandungan', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Harga', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Qty', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Total', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'ket', 1, 1, 'C');

$no=1;
$keluarUnionTindak = myquery($query);
foreach( $keluarUnionTindak as $kut ):
$pdf->SetFont('Arial','',8);
$pdf->Cell(1, 0.7, $no, 1, 0, 'C');
$pdf->Cell(2.25, 0.7, $kut['tanggal'], 1, 0, 'C');
$pdf->Cell(2, 0.7, $kut['id_pasien'], 1, 0, 'C');
$pdf->Cell(3, 0.7, $kut['id_obat'], 1, 0, 'C');
$pdf->Cell(4, 0.7, $kut['obat'], 1, 0, '');
$pdf->Cell(8.25, 0.7, $kut['jenis'], 1, 0, '');
$pdf->Cell(2, 0.7, number_format($kut['harga'], 0, '.', ','), 1, 0, 'R');
$pdf->Cell(1, 0.7, $kut['qty'], 1, 0, 'C');
$pdf->Cell(2, 0.7, number_format($kut['jumlah'], 0, '.', ','), 1, 0, 'R');
$pdf->Cell(2, 0.7, $kut['note'], 1, 1, 'C');
$no++;
endforeach;

$pdf->Output("Rekap-RM.pdf","I");
?>