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
$pdf->Cell(0,0.7,'DATA OBAT MASUK',0,1,'C');
$pdf->SetFont('Arial','B',11);
$query = "SELECT * FROM masuk ";
if(isset($_GET['tgl'])){  
    if($_GET['tgl'] == ""){
        $filTgl = "Update : ". date('d M Y');
        $query .= "ORDER BY tanggal DESC";
    }else{
        $awal = $_GET['tgl'];  
        $ahir = date('Y-m-d');
        $a = date_create($awal);
        $tgl_awal = date_format($a, 'j M Y');
        $tgl_ahir = date('j M Y');
        $filTgl = $tgl_awal ." s.d. ". $tgl_ahir;
        $query .= "WHERE tanggal BETWEEN '$awal' AND '$ahir' ORDER BY tanggal DESC";
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
$pdf->Cell(3, 0.8, 'Kode', 1, 0, 'C');
$pdf->Cell(4, 0.8, 'Merk Obat', 1, 0, 'C');
$pdf->Cell(10, 0.8, 'Kandungan', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Harga', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'Qty', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Total', 1, 0, 'C');
$pdf->Cell(2.25, 0.8, 'Ket', 1, 1, 'C');

$no=1;
$daftar = myquery($query);
foreach( $daftar as $daf ):
$id=$daf['id'];
$pdf->SetFont('Arial','',8);
$pdf->Cell(1, 0.7, $no, 1, 0, 'C');
$pdf->Cell(2.25, 0.7, $daf['tanggal'], 1, 0, 'C');
$pdf->Cell(3, 0.7, $daf['id_obat'], 1, 0, 'C');
$pdf->Cell(4, 0.7, $daf['obat'], 1, 0, '');
$pdf->Cell(10, 0.7, $daf['jenis'], 1, 0, '');
$pdf->Cell(2, 0.7, number_format($daf['harga'], 0, '.', ','), 1, 0, 'R');
$pdf->Cell(1, 0.7, $daf['qty'], 1, 0, 'C');
$pdf->Cell(2, 0.7, number_format($daf['jumlah'], 0, '.', ','), 1, 0, 'R');
$pdf->Cell(2.25, 0.7, $daf['note'], 1, 1, 'C');
$no++;
endforeach;

$pdf->Output("Rekap-RM.pdf","I");
?>