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
$pdf->Cell(0,0.7,'DATA REKAM MEDIS',0,1,'C');
$pdf->SetFont('Arial','B',11);
$query = "SELECT max(daftar.tanggal) as tgl, daftar.id, daftar.id_pasien, daftar.pasien, daftar.jk, daftar.tgl_lahir, daftar.alamat, daftar.kel, daftar.kec, daftar.kota, daftar.poli, daftar.jenis, daftar.cara, daftar.kasus, daftar.lanjut, daftar.bayar, periksa.icd, periksa.diagnosa, periksa.user, periksa.note FROM daftar INNER JOIN periksa ON periksa.id_daftar=daftar.id ";
if(isset($_GET['tgl'])){  
    if($_GET['tgl'] == ""){
        $filTgl = "Update : ". date('d M Y');
    }else{
        $tgl_awal = $_GET['tgl'];
        $tgl_ahir = date('Y-m-d');
        $filTgl = $tgl_awal . " .s.d. " . $tgl_ahir;
    }
    if($_GET['filter'] == "" || $_GET['data'] == ""){
        $fil = "";
        $dat = "";
        $query .= "WHERE ";
    }else{
        $fil = $_GET['filter'];
        $dat = $_GET['data'];
        switch($fil){
            case "daftar.jk" : $view = "Jenis Kelamin"; break;
            case "daftar.poli" : $view = "Poliklinik"; break;
            case "daftar.jenis" : $view = "Jenis Kunjungan"; break;
            case "daftar.cara" : $view = "Cara Kunjungan"; break;
            case "daftar.kasus" : $view = "Kasus"; break;
            case "daftar.lanjut" : $view = "Tindak Lanjut"; break;
            case "daftar.bayar" : $view = "Pembayaran"; break;
            case "daftar.kel" : $view = "Alamat (Kel.)"; break;
            case "periksa.icd" : $view = "ICD-10"; break;
            case "periksa.diagnosa" : $view = "Diagnosa"; break;
            case "periksa.user" : $view = "Nama Pemeriksa"; break;
          }
        $pdf->Cell(0,0.6, "Berdasarkan ". $view . " : " . $dat ,0,1,'C');
        $query .= "WHERE ". $fil ." LIKE '%$dat%' AND ";
    }
    $awal = $_GET['tgl'];  
    $ahir = date('Y-m-d');
    $a = date_create($awal);
    $tgl_awal = date_format($a, 'j M Y');
    $tgl_ahir = date('j M Y');
    $query .= "tanggal BETWEEN '$awal' AND '$ahir' ORDER BY tanggal DESC";
}else{
    $filTgl = date('D, d M Y');
    $query .= "ORDER BY tanggal DESC";
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
$pdf->Cell(4, 0.8, 'Nama', 1, 0, 'C');
$pdf->Cell(1, 0.8, 'LP', 1, 0, 'C');
$pdf->Cell(1.5, 0.8, 'Umur', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Poliklinik', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Kunjungan', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Kasus', 1, 0, 'C');
$pdf->Cell(8.75, 0.8, 'Diagnosa', 1, 1, 'C');

$no=1;
$daftar = myquery($query);
foreach( $daftar as $daf ):
$id=$daf['id'];
$pdf->SetFont('Arial','',8);
$pdf->Cell(1, 0.7, $no, 1, 0, 'C');
$pdf->Cell(2.25, 0.7, $daf['tgl'], 1, 0, 'C');
$pdf->Cell(2, 0.7, $daf['id_pasien'], 1, 0, 'C');
$pdf->Cell(4, 0.7, $daf['pasien'], 1, 0, '');
$jk = $daf['jk'] == "Laki-laki" ? "L" : "P";
$pdf->Cell(1, 0.7, $jk, 1, 0, 'C');
$lahir = date_format(date_create($daf['tgl_lahir']), 'Y');
$umur = date('Y') - $lahir;
$pdf->Cell(1.5, 0.7, $umur, 1, 0, 'C');
$pdf->Cell(3, 0.7, $daf['poli'], 1, 0, 'C');
$pdf->Cell(2, 0.7, $daf['jenis'], 1, 0, 'C');
$pdf->Cell(2, 0.7, $daf['kasus'], 1, 0, 'C');
$periksa = myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
$per = (!$periksa) ? [] : $periksa[0];
// var_dump($periksa);
$pdf->Cell(8.75, 0.7, (!$periksa) ? '' : $per['icd'] ." - ". substr($per['diagnosa'], 0, 55) ."..", 1, 1, '');
$no++;
endforeach;

$pdf->Output("Rekap-RM.pdf","I");
?>