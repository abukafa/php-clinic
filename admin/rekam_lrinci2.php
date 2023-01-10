<?php
require('../assets/pdf/fpdf.php');
require 'functions.php';
$pdf = new FPDF("P","cm","A4");

$pdf->SetMargins(1,1,1);
$pdf->SetAutoPageBreak(true);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../img/kop.png',1,0.6,18 ,2); 
// $pdf->Line(1,2.7,28.5,2.7);
// $pdf->SetLineWidth(0.1);      
// $pdf->Line(1,2.8,28.5,2.8);   
// $pdf->SetLineWidth(0);

$pdf->ln(2);
$pdf->SetFont('Arial','B',14);
$m=date('m');
if ($m >= 07 and $m <= 12) {
$y2=date('Y');
}else{
$y2=date('Y')-1;
}

$idd = $_GET['id'];
$daftar = myquery("SELECT * FROM daftar WHERE id='$idd'");
$daf = $daftar[0];
$idp = $daf['id_pasien'];
$pasien = myquery("SELECT * FROM pasien WHERE id='$idp'");
$pas = $pasien[0];
$anamnesa = myquery("SELECT * FROM anamnesa WHERE id_daftar='$idd'");
$ana = $anamnesa ? $anamnesa[0] : '';
$periksa = myquery("SELECT * FROM periksa WHERE id_daftar='$idd'");
$per = $periksa ? $periksa[0] : '';

$pdf->Cell(0,0.7,'FORM REKAM MEDIS',0,1,'C');
$pdf->SetFillColor(193,229,252);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(4, 0.8, 'No. RM : '. $idp, 1, 1, 'C');
$pdf->ln(0.35);

$pdf->SetFont('Arial','',8);
$pdf->Cell(3, 0.7, 'Nama Pasien', 'B,L,T', 0, 'L');
$pdf->Cell(8, 0.7, ': '. $daf['pasien'], 'B,T', 0, 'L');
$jk = $daf['jk'] == "Laki-laki" ? "L" : "P";
$pdf->Cell(1, 0.7, $jk, 1, 0, 'C');
$pdf->Cell(1, 0.7, ' TD', 'T', 0, 'L');
$pdf->Cell(2.5, 0.7, ': '. !$anamnesa ? $ana : $ana['darah'], 'T', 0, 'L');
$pdf->Cell(1, 0.7, ' TN', 'T', 0, 'L');
$pdf->Cell(2.5, 0.7, ': '. !$anamnesa ? $ana : $ana['nadi'], 'R,T', 1, 'L');

$lahir = date_format(date_create($daf['tgl_lahir']), 'Y');
$umur = date('Y') - $lahir . " Tahun";
$pdf->Cell(3, 0.7, 'Tanggal Lahir', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['tgl_lahir'] .' - '. $umur, 'B,R,T', 0, 'L');
$pdf->Cell(1, 0.7, ' Suhu', '', 0, 'L');
$pdf->Cell(2.5, 0.7, ': '. !$anamnesa ? $ana : $ana['suhu'], '', 0, 'L');
$pdf->Cell(1, 0.7, ' SPO', '', 0, 'L');
$pdf->Cell(2.5, 0.7, ': '. !$anamnesa ? $ana : $ana['spo'], 'R', 1, 'L');

$pdf->Cell(3, 0.7, 'Status', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $pas['status'], 'B,R,T', 0, 'L');
$pdf->Cell(1, 0.7, ' BB', 'B', 0, 'L');
$pdf->Cell(2.5, 0.7, ': '. !$anamnesa ? $ana : $ana['berat'] .' kg', 'B', 0, 'L');
$pdf->Cell(1, 0.7, ' TB', 'B', 0, 'L');
$pdf->Cell(2.5, 0.7, ': '. !$anamnesa ? $ana : $ana['tinggi'] .' cm', 'B,R', 1, 'L');

$pdf->Cell(3, 0.7, 'Penanggung', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $pas['pj'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, ' Mata', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Konjungtiva Anemis', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ma_anemis'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Nama Penanggung', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $pas['nama_pj'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Konjungtiva Ikterik', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ma_ikterik'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'No. Telepon', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $pas['telepon'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Leher', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Kelenjar Getah Bening', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['le_kelenjar'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Alamat', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['alamat'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'JVP', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['le_jvp'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Poliklinik', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['poli'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Jantung', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Suara', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ja_suara'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Kunjungan', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['jenis'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Irama', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ja_irama'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Kasus', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['kasus'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Paru-paru', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Suara', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['pa_suara'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Cara Kunjungan', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['cara'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Perut', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Hati', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['pe_hati'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Tindak Lanjut', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['lanjut'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Limpa', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['pe_limpa'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Pembayaran', 'B,L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. $daf['bayar'], 'B,R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Bising Usus', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['pe_usus'], 'B,R,T', 1, 'L');

$pdf->Cell(4, 0.7, 'Riwayat Penyakit Sekarang', 'L,T', 0, 'L');
$pdf->Cell(8, 0.7, ': '. !$anamnesa ? $ana : $ana['sekarang'], 'R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Bentuk', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['pe_bentuk'], 'B,R,T', 1, 'L');

$pdf->Cell(4, 0.7, 'Riwayat Penyakit Dahulu', 'L', 0, 'L');
$pdf->Cell(8, 0.7, ': '. !$anamnesa ? $ana : $ana['dahulu'], 'R', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Gemital', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'BAK', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ge_bak'], 'B,R,T', 1, 'L');

$pdf->Cell(4, 0.7, 'Riwayat Penyakit Keluarga', 'L', 0, 'L');
$pdf->Cell(8, 0.7, ': '. !$anamnesa ? $ana : $ana['keluarga'], 'R', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Bercak', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ge_bercak'], 'B,R,T', 1, 'L');

$pdf->Cell(4, 0.7, 'Keluhan Utama', 'B,L', 0, 'L');
$pdf->Cell(8, 0.7, ': '. !$anamnesa ? $ana : $ana['keluhan'], 'B,R', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Ekstremitas', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Atas', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ek_atas'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Diagnosa (ICD-10)', 'L,T', 0, 'L');
$pdf->Cell(9, 0.7, ': '. !$periksa ? $per : $per['icd'] .' - '. $per['diagnosa'], 'R,T', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Bawah', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ek_bawah'], 'B,R,T', 1, 'L');

$pdf->Cell(12, 0.7, '', 'B,L', 0, 'L');
$pdf->Cell(1.75, 0.7, '', 'L,B,T', 0, 'L');
$pdf->Cell(3, 0.7, 'Edema', 'B,T', 0, 'L');
$pdf->Cell(2.25, 0.7, ': '. !$periksa ? $per : $per['ek_edema'], 'B,R,T', 1, 'L');

$pdf->Cell(3, 0.7, 'Catatan Dokter', 'T,L', 0, 'L');
$pdf->Cell(9, 0.7, ': '. !$periksa ? $per : $per['note'], 'T,R', 0, 'L');
$pdf->Cell(1.75, 0.7, 'Lainnya', 'T', 0, 'L');
$pdf->Cell(5.25, 0.7, ': '. !$periksa ? $per : $per['lainnya'], 'T,R', 1, 'L');
$pdf->Cell(12, 0.7, '', 'L,B,R', 0, 'L');
$pdf->Cell(7, 0.7, '', 'B,R', 1, 'L');

$pdf->ln(0.35);
$pdf->SetFont('Arial','B',9);
$pdf->cell(19, 0.7, 'Tindakan dan Pemeriksaan', 1, 1, 'C');
$pdf->cell(1, 0.7, 'No', 1, 0, 'C');
$pdf->cell(2, 0.7, 'Kode', 1, 0, 'C');
$pdf->cell(5, 0.7, 'Tindakan', 1, 0, 'C');
$pdf->cell(3.5, 0.7, 'Jenis', 1, 0, 'C');
$pdf->cell(2.5, 0.7, 'Tarif', 1, 0, 'C');
$pdf->cell(2.5, 0.7, 'Qty', 1, 0, 'C');
$pdf->cell(2.5, 0.7, 'Jumlah', 1, 1, 'C');
$biaya = myquery("SELECT * FROM tindak WHERE id_daftar='$idd' ORDER BY kode");
$no=1;
foreach($biaya as $b):
$pdf->SetFont('Arial','',8);
$pdf->cell(1, 0.7, $no, 1, 0, 'C');
$pdf->cell(2, 0.7, $b['kode'], 1, 0, 'C');
$pdf->cell(5, 0.7, $b['nama'], 1, 0, 'L');
$pdf->cell(3.5, 0.7, $b['jenis'], 1, 0, 'C');
$pdf->cell(2.5, 0.7, number_format($b['tarif'], 0, '.', ','), 1, 0, 'R');
$pdf->cell(2.5, 0.7, $b['qty'] .' '. $b['satuan'], 1, 0, 'C');
$pdf->cell(2.5, 0.7, number_format($b['jumlah'], 0, '.', ','), 1, 1, 'R');
$no++;
endforeach;

// $pdf->SetFont('Arial','B',9);
// $pdf->cell(19, 0.7, 'Terapi Obat', 1, 1, 'C');
// $pdf->cell(1, 0.7, 'No', 1, 0, 'C');
// $pdf->cell(2, 0.7, 'Kode', 1, 0, 'C');
// $pdf->cell(5, 0.7, 'Merk Obat', 1, 0, 'C');
// $pdf->cell(3.5, 0.7, 'Kandungan', 1, 0, 'C');
// $pdf->cell(2.5, 0.7, 'Tarif', 1, 0, 'C');
// $pdf->cell(2.5, 0.7, 'Qty', 1, 0, 'C');
// $pdf->cell(2.5, 0.7, 'Jumlah', 1, 1, 'C');
// $obat = myquery("SELECT * FROM tindak WHERE id_daftar='$idd' AND LEFT(kode,1)='F'");
// $no=1;
// foreach($obat as $o):
// $pdf->SetFont('Arial','',8);
// $pdf->cell(1, 0.7, $no, 1, 0, 'C');
// $pdf->cell(2, 0.7, $b['kode'], 1, 0, 'C');
// $pdf->cell(5, 0.7, $b['nama'], 1, 0, 'L');
// $pdf->cell(3.5, 0.7, $b['jenis'], 1, 0, 'C');
// $pdf->cell(2.5, 0.7, number_format($b['tarif'], 0, '.', ','), 1, 0, 'R');
// $pdf->cell(2.5, 0.7, $b['qty'] .' '. $b['satuan'], 1, 0, 'C');
// $pdf->cell(2.5, 0.7, number_format($b['jumlah'], 0, '.', ','), 1, 1, 'R');
// $no++;
// endforeach;

$pdf->ln(0.35);
$pdf->cell(4.75, 0.7, 'RM', 1, 0, 'C');
$pdf->cell(4.75, 0.7, 'Admin', 1, 0, 'C');
$pdf->cell(4.75, 0.7, 'Pemeriksa', 1, 0, 'C');
$pdf->cell(4.75, 0.7, 'Apoteker', 1, 1, 'C');

$pdf->cell(4.75, 1, !$periksa ? $per : $per['user'], 1, 0, 'C');
$pdf->cell(4.75, 1, '', 1, 0, 'C');
$pdf->cell(4.75, 1, !$periksa ? $per : $per['user'], 1, 0, 'C');
$pdf->cell(4.75, 1, '', 1, 1, 'C');

$pdf->Output("Form-RM.pdf","I");
?>