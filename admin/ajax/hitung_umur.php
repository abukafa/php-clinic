<?php
include '../config.php';
include '../functions.php';

$tgl = $_GET['tglLahir'];
echo umur($tgl, " Tahun ", " Bulan ", " Hari ");

?>