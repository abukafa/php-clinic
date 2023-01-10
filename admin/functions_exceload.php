<?php 
include 'config.php';
include "../assets/php/excel_reader2.php";

// FUNGSI DATA QUERY ROWS ------------------------------------------------------------------------------------------------
function myquery($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
// SESI USER -------------------------------------------------------------------------------------------------------------
session_start();
$uname=$_SESSION['uname'];
$user = myquery("select * from user where uname='$uname'");
$u = $user[0];
// IMPORT DATA STOK OPNAME -----------------------------------------------------------------------------------------------
if(isset($_GET['import'])){
    if($_GET['import']=="so"){
    $target = basename($_FILES['import_so']['name']) ;
    move_uploaded_file($_FILES['import_so']['tmp_name'], $target);
    chmod($_FILES['import_so']['name'],0777);
    $data = new Spreadsheet_Excel_Reader($_FILES['import_so']['name'],false);
    $jumlah_baris = $data->rowcount($sheet_index=0);
    $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
        $id    = $data->val($i, 1);
        $obat  = $data->val($i, 2);
        $jenis = $data->val($i, 3);
        $so    = $data->val($i, 4);
        $note  = $data->val($i, 5);
        $user   = $u['nama'];
        // if($id != "" && $obat != "" && $jenis != "" && $so != "" && $note != "" && $user != ""){
            mysqli_query($conn, "INSERT INTO opname VALUES ('$id', '$obat', '$jenis', '$so', '$note', '$user')");
            $berhasil++;
        // } 
    }
    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['import_so']['name']);
    header("location:farmasi_stok.php?importOk=$berhasil");
    }
}
// IMPORT DATA OBAT ------------------------------------------------------------------------------------------------------
if(isset($_GET['import'])){
    if($_GET['import']=="obat"){
    $target = basename($_FILES['import_obat']['name']) ;
    move_uploaded_file($_FILES['import_obat']['tmp_name'], $target);
    chmod($_FILES['import_obat']['name'],0777);
    $data = new Spreadsheet_Excel_Reader($_FILES['import_obat']['name'],false);
    $jumlah_baris = $data->rowcount($sheet_index=0);
    $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
        $id     = $data->val($i, 1);
        $obat   = $data->val($i, 2);
        $jenis  = $data->val($i, 3);
        $satuan = $data->val($i, 4);
        $harga  = $data->val($i, 5);
        $stok   = $data->val($i, 6);
        $minim  = $data->val($i, 7);
        $note   = $data->val($i, 8);
        $user   = $u['nama'];
        // if($id != "" && $obat != "" && $jenis != "" && $so != "" && $note != "" && $user != ""){
            mysqli_query($conn, "INSERT INTO obat VALUES ('$id', '$obat', '$jenis', '$satuan', '$harga', '$stok', '$minim', '$note', '$user')");
            $berhasil++;
        // } 
    }
    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['import_obat']['name']);
    header("location:data.php?table=obat&importObatOk=$berhasil");
    }
}
// IMPORT DATA BIAYA ------------------------------------------------------------------------------------------------------
if(isset($_GET['import'])){
    if($_GET['import']=="biaya"){
    $target = basename($_FILES['import_biaya']['name']) ;
    move_uploaded_file($_FILES['import_biaya']['tmp_name'], $target);
    chmod($_FILES['import_biaya']['name'],0777);
    $data = new Spreadsheet_Excel_Reader($_FILES['import_biaya']['name'],false);
    $jumlah_baris = $data->rowcount($sheet_index=0);
    $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
        $id     = $data->val($i, 1);
        $biaya  = $data->val($i, 2);
        $jenis  = $data->val($i, 3);
        $satuan = $data->val($i, 4);
        $tarif  = $data->val($i, 5);
        $ket    = $data->val($i, 6);
        $note   = $data->val($i, 8);
        $user   = $u['nama'];
        // if($id != "" && $biaya != "" && $jenis != "" && $so != "" && $note != "" && $user != ""){
            mysqli_query($conn, "INSERT INTO biaya VALUES ('$id', '$biaya', '$jenis', '$satuan', '$tarif', '$ket', '$note', '$user')");
            $berhasil++;
        // } 
    }
    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['import_biaya']['name']);
    header("location:data.php?table=tindakan&importBiayaOk=$berhasil");
    }
}
// IMPORT DATA ICD-10 ------------------------------------------------------------------------------------------------------
if(isset($_GET['import'])){
    if($_GET['import']=="icd10"){
    $target = basename($_FILES['import_icd10']['name']) ;
    move_uploaded_file($_FILES['import_icd10']['tmp_name'], $target);
    chmod($_FILES['import_icd10']['name'],0777);
    $data = new Spreadsheet_Excel_Reader($_FILES['import_icd10']['name'],false);
    $jumlah_baris = $data->rowcount($sheet_index=0);
    $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
        // $id          = $data->val($i, 1);
        $chapter     = $data->val($i, 2);
        $group       = $data->val($i, 3);
        $code        = $data->val($i, 4);
        $description = $data->val($i, 5);
        $category    = $data->val($i, 6);
        $user        = $u['nama'];
        // if($id != "" && $icd10 != "" && $jenis != "" && $so != "" && $note != "" && $user != ""){
            mysqli_query($conn, "INSERT INTO icd10 VALUES ('', '$chapter', '$group', '$code', '$description', '$category', '$user')");
            $berhasil++;
        // } 
    }
    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['import_icd10']['name']);
    header("location:data.php?table=diagnosa&importIcd10Ok=$berhasil");
    }
}
// IMPORT DATA PASIEN ------------------------------------------------------------------------------------------------------
if(isset($_GET['import'])){
    if($_GET['import']=="pasien"){
    $target = basename($_FILES['import_pasien']['name']) ;
    move_uploaded_file($_FILES['import_pasien']['tmp_name'], $target);
    chmod($_FILES['import_pasien']['name'],0777);
    $data = new Spreadsheet_Excel_Reader($_FILES['import_pasien']['name'],false);
    $jumlah_baris = $data->rowcount($sheet_index=0);
    $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
        $id        = $data->val($i, 1);
        $tgl_reg   = $data->val($i, 2);
        $noid      = $data->val($i, 3);
        $nama      = $data->val($i, 4);
        $tgl_lahir = $data->val($i, 5);
        $jk        = $data->val($i, 6);
        $alamat    = $data->val($i, 7);
        $kel       = $data->val($i, 8);
        $kec       = $data->val($i, 9);
        $kota      = $data->val($i, 10);
        $status    = $data->val($i, 11);
        $pj        = $data->val($i, 12);
        $nama_pj   = $data->val($i, 13);
        $telepon   = $data->val($i, 14);
        $note      = $data->val($i, 15);
        $user      = $u['nama'];
        // if($id != "" && $pasien != "" && $jenis != "" && $so != "" && $note != "" && $user != ""){
            mysqli_query($conn, "INSERT INTO pasien VALUES ('$id', '$tgl_reg', '$noid', '$nama', '$tgl_lahir', '$jk', '$alamat', '$kel', '$kec', '$kota', '$status', '$pj', '$nama_pj', '$telepon', '$note', '$user')");
            $berhasil++;
        // } 
    }
    // hapus kembali file .xls yang di upload tadi
    unlink($_FILES['import_pasien']['name']);
    header("location:pasien_view.php?importPasienOk=$berhasil");
    }
}





// FUNGSI EXPORT PASIEN ---------------------------------------------------------------------------------------------------
if(isset($_GET['export'])){
    if($_GET['export']=="pasien"){
        $querypasien = myquery("SELECT * FROM pasien ORDER BY nama");
        $output = '
        <b>DATA PASIEN</b><br>
        <b>'. date("d-m-Y") .'</b><br>
        <table>
            <tr>
                <th>No</th>
                <th>NRM</th>
                <th>Tgl Registrasi</th>
                <th>No. ID</th>
                <th>Nama</th>
                <th>Tgl Lahir</th>
                <th>JK</th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                <th>Kecamatan</th>
                <th>Kota</th>
                <th>Status</th>
                <th>Penanggung</th>
                <th>Nama Penanggung</th>
                <th>Telepon</th>
                <th>Catatan</th>
            </tr>
        ';
        $no=1;
        foreach($querypasien as $pas):
        $output .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$pas['id'].'</td>
                <td>'.$pas['tgl_reg'].'</td>
                <td>'.$pas['noid'].'</td>
                <td>'.$pas['nama'].'</td>
                <td>'.$pas['tgl_lahir'].'</td>
                <td>'.$pas['jk'].'</td>
                <td>'.$pas['alamat'].'</td>
                <td>'.$pas['kel'].'</td>
                <td>'.$pas['kec'].'</td>
                <td>'.$pas['kota'].'</td>
                <td>'.$pas['status'].'</td>
                <td>'.$pas['pj'].'</td>
                <td>'.$pas['nama_pj'].'</td>
                <td>'.$pas['telepon'].'</td>
                <td>'.$pas['note'].'</td>
            </tr>
        ';
        $no++;
        endforeach;
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=Pasien.xls");
        echo $output;
    }
}
// FUNGSI EXPORT OBAT ---------------------------------------------------------------------------------------------------
if(isset($_GET['export'])){
    if($_GET['export']=="obat"){
        $queryObat = myquery("SELECT * FROM obat ORDER BY jenis, id");
        $output = '
        <b>DATA OBAT</b><br>
        <b>'. date("d-m-Y") .'</b><br>
        <table>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Merek</th>
                <th>Kandungan</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Minimum</th>
                <th>Catatan</th>
                <th>User</th>
            </tr>
        ';
        $no=1;
        foreach($queryObat as $ob):
        $output .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$ob['id'].'</td>
                <td>'.$ob['obat'].'</td>
                <td>'.$ob['jenis'].'</td>
                <td>'.$ob['satuan'].'</td>
                <td>'.$ob['harga'].'</td>
                <td>'.$ob['stok'].'</td>
                <td>'.$ob['minim'].'</td>
                <td>'.$ob['note'].'</td>
                <td>'.$ob['user'].'</td>
            </tr>
        ';
        $no++;
        endforeach;
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=Obat.xls");
        echo $output;
    }
}
// FUNGSI EXPORT BIAYA -------------------------------------------------------------------------------------------------
if(isset($_GET['export'])){
    if($_GET['export']=="biaya"){
        $queryBiaya = myquery("SELECT * FROM biaya ORDER BY jenis, id");
        $output = '
        <b>DATA BIAYA PERIKSA & TINDAKAN</b><br>
        <b>'. date("d-m-Y") .'</b><br>
        <table>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Satuan</th>
                <th>Tarif</th>
                <th>Ket</th>
                <th>Catatan</th>
                <th>User</th>
            </tr>
        ';
        $no=1;
        foreach($queryBiaya as $by):
        $output .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$by['id'].'</td>
                <td>'.$by['biaya'].'</td>
                <td>'.$by['jenis'].'</td>
                <td>'.$by['satuan'].'</td>
                <td>'.$by['tarif'].'</td>
                <td>'.$by['ket'].'</td>
                <td>'.$by['note'].'</td>
                <td>'.$by['user'].'</td>
            </tr>
        ';
        $no++;
        endforeach;
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=Biaya.xls");
        echo $output;
    }
}
// FUNGSI EXPORT ICD-10 -------------------------------------------------------------------------------------------------
if(isset($_GET['export'])){
    if($_GET['export']=="icd10"){
        $queryICD = myquery("SELECT * FROM icd10 ORDER BY chapter, code");
        $output = '
        <b>DATA ICD-10</b><br>
        <b>'. date("d-m-Y") .'</b><br>
        <table>
            <tr>
                <th>No</th>
                <th>Chapter</th>
                <th>Group</th>
                <th>Code</th>
                <th>Description</th>
                <th>Category</th>
                <th>User</th>
            </tr>
        ';
        $no=1;
        foreach($queryICD as $ic):
        $output .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$ic['chapter'].'</td>
                <td>'.$ic['group'].'</td>
                <td>'.$ic['code'].'</td>
                <td>'.$ic['description'].'</td>
                <td>'.$ic['category'].'</td>
                <td>'.$ic['user'].'</td>
            </tr>
        ';
        $no++;
        endforeach;
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=ICD-10.xls");
        echo $output;
    }
}
// FUNGSI EXPORT STOCK OPNAME -------------------------------------------------------------------------------------------
if(isset($_GET['export'])){
    if($_GET['export']=="so"){
        $querySO = myquery("SELECT * FROM opname ORDER BY jenis, obat");
        $output = '
        <b>DATA STOCK OPNAME</b><br>
        <b>'. date("d-m-Y") .'</b><br>
        <table>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Merk</th>
                <th>Kandungan</th>
                <th>SO</th>
                <th>Keterangan</th>
                <th>User</th>
            </tr>
        ';
        $no=1;
        foreach($querySO as $so):
        $output .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$so['id'].'</td>
                <td>'.$so['obat'].'</td>
                <td>'.$so['jenis'].'</td>
                <td>'.$so['so'].'</td>
                <td>'.$so['note'].'</td>
                <td>'.$so['user'].'</td>
            </tr>
        ';
        $no++;
        endforeach;
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=stock_opname.xls");
        echo $output;
    }
}
// FUNGSI EXPORT RM -----------------------------------------------------------------------------------------------------
if(isset($_GET['export'])){
    if($_GET['export']=="rekam"){
        $query = "SELECT max(daftar.tanggal) as tgl, daftar.id, daftar.id_pasien, daftar.pasien, daftar.jk, daftar.tgl_lahir, daftar.alamat, daftar.kel, daftar.kec, daftar.kota, daftar.poli, daftar.jenis, daftar.cara, daftar.kasus, daftar.lanjut, daftar.bayar, periksa.icd, periksa.diagnosa, periksa.user, periksa.note FROM daftar INNER JOIN periksa ON periksa.id_daftar=daftar.id ";
        if($_GET['filter']!=="" && $_GET['data']!==""){
            $fil = $_GET['filter'];
            $dat = $_GET['data'];
            $query .= "WHERE ". $fil ." LIKE '%$dat%' AND ";
            $filter = "Berdasarkan ".$fil." = ".$dat;
        }else{
            $query .= "WHERE ";
        }
        if($_GET['tgl']!==""){
            $a = $_GET['tgl'];
            $n = date('Y-m-d');
            $query .= "tanggal BETWEEN '$a' AND '$n' ";
            $tanggal = $a." - ".$n;
        }else{
            $n = date('Y-m-d');
            $query .= "tanggal='$n' ";
            $tanggal = $n;
        }
        $query .= "GROUP BY id_pasien ORDER BY tgl DESC";
        $joinTable = myquery($query);
        $output = '
        <b>DATA REKAM MEDIS</b><br>
        <b>'.$tanggal.'</b><br>
        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No. RM</th>
                <th>Nama Pasien</th>
                <th>Tgl Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                <th>Kecamatan</th>
                <th>Kota</th>
                <th>Poli yang dituju</th>
                <th>Jenis Kunjungan</th>
                <th>Cara Kunjungan</th>
                <th>Kasus</th>
                <th>Pembayaran</th>
                <th>Tindak Lanjut</th>
                <th>ICD-10</th>
                <th>Diagnosa</th>
                <th>Pemeriksa</th>
                <th>Catatan</th>
            </tr>
        ';
        $no=1;
        foreach($joinTable as $tab):
        $output .= '
            <tr>
                <td>'.$no.'</td>
                <td>'.$tab['tanggal'].'</td>
                <td>'.$tab['id_pasien'].'</td>
                <td>'.$tab['pasien'].'</td>
                <td>'.$tab['tgl_lahir'].'</td>
                <td>'.$tab['jk'].'</td>
                <td>'.$tab['alamat'].'</td>
                <td>'.$tab['kel'].'</td>
                <td>'.$tab['kec'].'</td>
                <td>'.$tab['kota'].'</td>
                <td>'.$tab['poli'].'</td>
                <td>'.$tab['jenis'].'</td>
                <td>'.$tab['cara'].'</td>
                <td>'.$tab['kasus'].'</td>
                <td>'.$tab['bayar'].'</td>
                <td>'.$tab['lanjut'].'</td>
                <td>'.$tab['icd'].'</td>
                <td>'.$tab['diagnosa'].'</td>
                <td>'.$tab['user'].'</td>
                <td>'.$tab['note'].'</td>
            </tr>
        ';
        $no++;
        endforeach;
        $output .= '</table>';
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=rekam_medis.xls");
        echo $output;
    }
}





?>