<?php
require('../assets/pdf/fpdf.php');
require 'functions.php';

$pdf = new FPDF("P","cm", "A4");
$pdf->SetMargins(1,0,0,0);
$pdf->SetAutoPageBreak(true);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../img/kop.png',1,0.6,13.5,1.5); 
// $pdf->Line(1,2.2,20,2.2);
// $pdf->SetLineWidth(0.1);      
// $pdf->Line(1,2.3,20,2.3);   
// $pdf->SetLineWidth(0);

$pdf->ln(2.5);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(19,0.7,"RINCIAN PEMBAYARAN",0,1,'C');

$id=$_GET['id'];
$daftar=myquery("SELECT * FROM daftar WHERE id='$id'");
$daf = (!$daftar) ? [] : $daftar[0];

$pdf->ln(0.5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(1.5, 0.5, 'No. RM' , 0, 0, 'L');
$pdf->Cell(8, 0.5, ': '. $daf['id_pasien'], 0, 0, 'L');
$pdf->Cell(2.15, 0.5, 'Tanggal' , 0, 0, 'L');
$pdf->Cell(8, 0.5, ': '. $daf['tanggal'], 0, 1, 'L');
$pdf->Cell(1.5, 0.5, 'Nama' , 0, 0, 'L');
$pdf->Cell(8, 0.5, ': '. $daf['pasien'], 0, 0, 'L');
$pdf->Cell(2.15, 0.5, 'Poliklinik' , 0, 0, 'L');
$pdf->Cell(8, 0.5, ': '. $daf['poli'], 0, 1, 'L');
$lahir = date_format(date_create($daf['tgl_lahir']), 'Y');
$umur = date('Y') - $lahir . " Tahun";
$pdf->Cell(1.5, 0.5, 'Umur' , 0, 0, 'L');
$pdf->Cell(8, 0.5, ': '. $umur, 0, 0, 'L');
$pdf->Cell(2.15, 0.5, 'Pembayaran' , 0, 0, 'L');
$pdf->Cell(7.5, 0.5, ': '. $daf['bayar'], 0, 1, 'L');
$pdf->Cell(1.5, 0.5, 'Alamat' , 0, 0, 'L');
$pdf->Cell(8, 0.5, ': '. $daf['alamat'], 0, 0, 'L');
$periksa=myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
$per= (!$periksa) ? [] : $periksa[0];
$pdf->Cell(2.15, 0.5, 'Diagnosa' , 0, 0, 'L');
$pdf->MultiCell(7.5, 0.5, ': '. $per['icd'] .' - '. $per['diagnosa'], 0, 'L');

$pdf->ln(0.5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1, 0.7, 'NO ' ,1,0, 'C');
$pdf->Cell(2.5, 0.7, 'TANGGAL ' ,1,0, 'C');
$pdf->Cell(3.5, 0.7, 'JENIS ' ,1,0, 'C');
$pdf->Cell(5.5, 0.7, 'URAIAN ' ,1,0, 'C');
$pdf->Cell(2, 0.7, 'TARIF ' , 1, 0, 'C');
$pdf->Cell(2, 0.7, 'QTY ' , 1, 0, 'C');
$pdf->Cell(2.5, 0.7, 'JUMLAH ' , 1, 1, 'C');

$no=1;
$tindak = myquery("SELECT * FROM tindak WHERE id_daftar='$id' ORDER BY kode");
if($tindak){
foreach($tindak as $tin):
$pdf->SetFont('Arial','',10);
$pdf->Cell(1, 0.7, $no ,0,0, 'C');
$pdf->Cell(2.5, 0.7, $tin['tanggal'] ,0,0, 'C');
$pdf->Cell(3.5, 0.7, substr($tin['jenis'], 0, 14) ,0,0, 'L');
// $pdf->Cell(3.5, 0.7, $tin['jenis'] ,0,0, 'L');
$pdf->Cell(5.5, 0.7, substr($tin['nama'], 0, 25) ,0,0, 'L');
// $pdf->Cell(5.5, 0.7, $tin['nama'] ,0,0, 'L');
$pdf->Cell(2, 0.7, number_format($tin['tarif'], 0, '.', ',') ,0,0, 'R');
$pdf->Cell(2, 0.7, $tin['qty'] .' '. $tin['satuan'] ,0,0, 'C');
$pdf->Cell(2.5, 0.7, number_format($tin['jumlah'], 0, '.', ',') , 0, 1, 'R');
$no++;
endforeach;
}
$tagihan = myquery("SELECT SUM(jumlah) as total FROM tindak WHERE id_daftar='$id'");
$tag = (!$tagihan) ? [] : $tagihan[0];
$pdf->SetFont('Arial','B',10);
$pdf->Cell(16.5, 0.7,'Total : ',1,0, 'R');
$pdf->Cell(2.5, 0.7, number_format($tag['total'], 0, '.', ',') ,1,1, 'R');

$pdf->ln(0.5);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(12, 0.5, ucwords(Terbilang($tag['total'])) . " Rupiah", 0, 1, 0, 'C');

$pdf->ln(0.5);
$pdf->Cell(12.5, 0.6,'', '', 0, 'C');
$pdf->Cell(2, 0.5,'', 0, 0, 'C');
$pdf->Cell(5, 0.5,"Admin :", 0, 1, 'L');
$pdf->Cell(12.5, 0.6,'', '', 0, 'C');
$pdf->Cell(2, 0.5,'', 0, 0, 'C');
$pdf->Cell(7, 0.6, $daf['user'], 0, 1, 'L');

$pdf->Output("struk-" . $id . ".pdf","I");

function Terbilang($x){
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}
?>