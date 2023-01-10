<?php
include '../config.php';
include '../functions.php';

// validasi input data USER baru
if(isset($_GET['user'])){
    $uname = $_GET['user'];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE uname='$uname'");
    if( mysqli_num_rows($result) === 1 ){
        echo "form-control form-control-sm is-invalid";
    }else{
        echo "form-control form-control-sm is-valid";
    }
}

// tampilkan icd GROUP bersadarkan CHAPTER yang dipilih
if(isset($_GET['icdChap'])){
    $icdChap = $_GET['icdChap'];
    $result = mysqli_query($conn, "SELECT DISTINCT `group` FROM icd10 WHERE chapter='$icdChap'");
    foreach($result as $i) :
        echo "<option>" . $i['group'] ."</option>";
    endforeach;
}

// tampilkan icd CATEGORY bersadarkan GROUP yang dipilih
// if(isset($_GET['icdGrup'])){
//     $icdGrup = $_GET['icdGrup'];
//     $result = mysqli_query($conn, "SELECT category FROM icd10 WHERE group='$icdGrup'");
//     if($result){
//         $i = $result[0];
//         echo $i['category'];
//     }
// }

// ajax cek kode BIAYA sudah terdaftar atau belum
if(isset($_GET['kodeBiaya'])){
    $kodeBiaya = $_GET['kodeBiaya'];
    $result = mysqli_query($conn, "SELECT * FROM biaya WHERE id='$kodeBiaya'");
    if( mysqli_num_rows($result) === 1 ){
        echo "form-control form-control-sm is-invalid";
    }else{
        echo "form-control form-control-sm is-valid";
    }
}

// ajax cek kode OBAT sudah terdaftar atau belum
if(isset($_GET['kodeObat'])){
    $kodeObat = $_GET['kodeObat'];
    $result = mysqli_query($conn, "SELECT * FROM obat WHERE id='$kodeObat'");
    if( mysqli_num_rows($result) === 1 ){
        echo "form-control form-control-sm is-invalid";
    }else{
        echo "form-control form-control-sm is-valid";
    }
}

// ajax cek kode ICD sudah terdaftar atau belum
if(isset($_GET['kodeICD'])){
    $kodeICD = $_GET['kodeICD'];
    $result = mysqli_query($conn, "SELECT * FROM icd10 WHERE code='$kodeICD'");
    if( mysqli_num_rows($result) === 1 ){
        echo "form-control form-control-sm is-invalid";
    }else{
        echo "form-control form-control-sm is-valid";
    }
}
?>