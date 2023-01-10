<?php
include '../config.php';
include '../functions.php';

$kode = $_GET['kode'];
$cekKasus = myNumRow("SELECT * FROM periksa WHERE icd='$kode'");
// echo $cekKasus;
// echo $kode;
if($cekKasus >= 1){
    echo "Lama";
}else{
    echo "Baru";
}
?>