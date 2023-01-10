<?php 
require 'config.php';
// FUNGSI DATA QUERY ROWS ------------------------------------------------------------------------------
function myquery($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
// FUNGSI QUERY NUM ROWS -------------------------------------------------------------------------------
function myNumRow($query){
    global $conn;
    $myQue = mysqli_query($conn, $query);
    $numRow = mysqli_num_rows($myQue);
    return $numRow;
}
// FUNGSI HITUNG UMUR ----------------------------------------------------------------------------------
function umur($tanggal, $th, $bl, $hr){
    $lahir = new DateTime($tanggal);
    $today = new DateTime("today");
    if ($lahir >= $today){
        exit("0");
    }
    $y = $today->diff($lahir)->y;
    $m = $today->diff($lahir)->m;
    $d = $today->diff($lahir)->d;
    return $y . $th . $m . $bl . $d . $hr;
}
// FUNGSI FORMAT TANGGAL INDONESIA ---------------------------------------------------------------------
function indo_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Aha',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Ahad',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
        'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
}  
// SESI USER -------------------------------------------------------------------------------------------
session_start();
$uname=$_SESSION['uname'];
$user = myquery("select * from user where uname='$uname'");
$u = $user[0];
// Fungsi Registrasi User Baru
// function registrasi($data){
//     global $conn;
//     $nama = $data['name'];
//     $bag = $data['bagian'];
//     $uname = $data['uname'];
//     $pass = mysqli_real_escape_string($conn, $data['pass']);
//     $repass = mysqli_real_escape_string($conn, $data['repass']);
//     $akses = $data['akses'];
//     $ket = $data['ket'];
//     // Enkripsi Password
//     $pass = password_hash($pass, PASSWORD_DEFAULT);
//     mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$bag', '$uname', '$pass', '$akses', '$ket')");
// }
// Fungsi Ganti Password
// function newPass($data){
//     global $conn;
//     $user=$_POST['user'];
//     $lama=$_POST['lama'];
//     $baru=$_POST['baru'];
//     $ulang=$_POST['ulang'];
//     $result = mysqli_query($conn, "select * from user where uname='$user' and pass='$lama'");
//     if( mysqli_num_rows($result) === 1 ){
//         $row = mysqli_fetch_assoc($result);
//         if(password_verify($lama, $row["pass"])){
//             $baru = password_hash($baru, PASSWORD_DEFAULT);
//             mysqli_query($conn, "update user set pass='$baru' where uname='$user'");
//             header("location:pass.php?pesan=ok.php");
//         }else{
//             header("location:pass.php?pesan=tdksama")or die(mysqli_error());
//             // mysql_error();
//         }
//     }else{
//         header("location:pass.php?pesan=gagal")or die(mysqli_error());
//         // mysql_error();
//     }
// }
// FUNGSI GENERATE AUTO NUMBER -------------------------------------------------------------------------
function autoCode($table, $field, $init){
    $qry = myquery("SELECT max(". $field .") as myFil FROM ". $table);
    $row = $qry[0];
    $length = strlen($row['myFil']);
    if($row['myFil'] == ""){
        $angka = 100000;
    }else{
        $angka = substr($row['myFil'], strlen($init));
    } 
    $angka++;
    $angka = strval($angka);
    $tmp = "";
    for($i=1; $i<=($length-strlen($init)-strlen($angka)); $i++){
        $tmp=$tmp."0";
    }
    return $init.$tmp.$angka;
}
// FUNGSI CARI DATABASE --------------------------------------------------------------------------------
function cari($query, $cari){
    return myquery($query);
}
// FUNGSI PAGINATION -----------------------------------------------------------------------------------
function pagination($data, $query){
    global $conn;
    $jumlahData = count(myquery($query));
    $jumlahHal = ceil($jumlahData / $data);
    $halAktif = ( isset($_GET['page']) ) ? $_GET['page'] : 1 ;
    $awalData = ( $data * $halAktif ) - $data;
    $pagi = [ $data, $jumlahHal, $jumlahHal, $halAktif, $awalData, $jumlahData ] ;
    return $pagi;
}
// FUNGSI USER SQL -------------------------------------------------------------------------------------
if(isset($_GET['userSQL'])){
    if($_GET['userSQL']=="edit"){
        // global $conn;
        $userQuery = $_POST['query'];
        $q = mysqli_query($conn, $userQuery);
        if($q){
            header("Location: user.php?userSQL=OK");
        }else{
            header("Location: user.php?userSQL=NO");
        }
    }
}






// FUNGSI TAMBAH DATABASE ------------------------------------------------------------------------------
if(isset($_GET['add_diag'])){
    $chapter = $_POST['ii_chapter'];
    $group = $_POST['ii_group'];
    $code = $_POST['ii_code'];
    $description = $_POST['ii_description'];
    $category = $_POST['ii_category'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO icd10 VALUES('', '$chapter', '$group', '$code', '$description', '$category', '$user')");
    header("Location: data.php?table=diagnosa");
}
if(isset($_GET['add_biaya'])){
    $id = $_POST['ib_id'];
    $biaya = $_POST['ib_nama'];
    $jenis = $_POST['ib_jenis'];
    $satuan = $_POST['ib_satuan'];
    $tarif = $_POST['ib_tarif'];
    $ket = $_POST['ib_ket'];
    $note = $_POST['ib_note'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO biaya VALUES('$id', '$biaya', '$jenis', '$satuan', '$tarif', '$ket', '$note', '$user')");
    header("Location: data.php?table=tindakan");
}
if(isset($_GET['add_obat'])){
    $id = $_POST['io_id'];
    $obat = $_POST['io_nama'];
    $jenis = $_POST['io_jenis'];
    $satuan = $_POST['io_satuan'];
    $harga = $_POST['io_harga'];
    $stok = $_POST['io_stok'];
    $note = $_POST['io_note'];
    $minim = $_POST['io_minim'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO obat VALUES('$id', '$obat', '$jenis', '$satuan', '$harga', '$stok', '$minim', '$note', '$user')");
    header("Location: data.php?table=obat");
}
if(isset($_GET['add_masuk'])){
    $tgl = $_POST['m_tgl'];
    $ido = $_POST['m_ido'];
    $obat = $_POST['m_obat'];
    $jenis = $_POST['m_jenis'];
    $harga = $_POST['m_harga'];
    $qty = $_POST['m_qty'];
    $total = $_POST['m_total'];
    $note = $_POST['m_note'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO masuk VALUES('', '$tgl', '$ido', '$obat', '$jenis', '$harga', '$qty', '$total', '$note', '$user')");
    $DBobat = myquery("SELECT * FROM obat WHERE id='$ido'");
    $o = $DBobat[0];
    $stok = $o['stok'] + $qty;
    mysqli_query($conn, "UPDATE obat SET stok='$stok' WHERE id='$ido'");
    header("Location: farmasi_masuk.php");
}
if(isset($_GET['add_keluar'])){
    $tgl = $_POST['k_tgl'];
    $ido = $_POST['k_ido'];
    $obat = $_POST['k_obat'];
    $jenis = $_POST['k_jenis'];
    $harga = $_POST['k_harga'];
    $qty = $_POST['k_qty'];
    $total = $_POST['k_total'];
    $note = $_POST['k_note'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO keluar VALUES('', '$tgl', '-', '$ido', '$obat', '$jenis', '$harga', '$qty', '$total', '$note', '$user')");
    $DBobat = myquery("SELECT * FROM obat WHERE id='$ido'");
    $o = $DBobat[0];
    $stok = $o['stok'] - $qty;
    mysqli_query($conn, "UPDATE obat SET stok='$stok' WHERE id='$ido'");
    // if($stok < 10){
    //     $cek = myNumRow("SELECT * FROM notifikasi WHERE kode='$ido'");
    //     $satuan = $o['satuan'];
    //     if($cek == 0){
    //         mysqli_query($conn, "INSERT INTO notifikasi VALUES('$ido', 'Stok obat : $obat tinggal $stok $satuan !!')");
    //     }else{
    //         mysqli_query($conn, "UPDATE notifikasi SET pesan='Stok obat : $obat tinggal $stok $satuan !!' WHERE kode='$ido'");
    //     }
    // }
    header("Location: farmasi_keluar.php");
}
// INPUT DATA PASIEN & DAFTAR (pasien baru) ------------------------------------------------------------
if(isset($_GET['add_new'])){
    $nrm = $_POST['nrm'];
    $tgl = $_POST['tgl'];
    $nama = $_POST['nama'];
    $noid = $_POST['noid'];
    $lhr = $_POST['lhr'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $kel = $_POST['kel'];
    $kec = $_POST['kec'];
    $kota = $_POST['kota'];
    $status = $_POST['status'];
    $pj = $_POST['pj'];
    $npj = $_POST['npj'];
    $hp = $_POST['hp'];
    $keluh = $_POST['keluh'];
    $poli = $_POST['poli'];
    $jenis = $_POST['jenis'];
    $kasus = $_POST['kasus'];
    $cara = $_POST['cara'];
    $bayar = $_POST['bayar'];
    $lanjut = $_POST['lanjut'];
    $note = $_POST['note'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO pasien VALUES('$nrm', '$tgl', '$noid', '$nama', '$lhr', '$jk', '$alamat', '$kel', '$kec', '$kota', '$status', '$pj', '$npj', '$hp', '', '$user')");
    mysqli_query($conn, "INSERT INTO daftar VALUES('', '$tgl', '$nrm', '$nama', '$lhr', '$jk', '$alamat', '$kel', '$kec', '$kota', '$keluh', '$poli', '$jenis', '$kasus', '$cara', '$bayar', '', '$lanjut', '$note', '$user')");
    header("Location: pasien.php");
}
// INPUT DATA DAFTAR (pasien lama) ---------------------------------------------------------------------
if(isset($_GET['add_old'])){
    $tgl = $_POST['tgl'];
    $nrm = $_POST['nrm'];
    $nama = $_POST['nama'];
    $lahir = $_POST['lahir'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $kel = $_POST['kel'];
    $kec = $_POST['kec'];
    $kota = $_POST['kota'];
    $keluh = $_POST['keluh'];
    $poli = $_POST['poli'];
    $jenis = $_POST['jenis'];
    $kasus = $_POST['kasus'];
    $cara = $_POST['cara'];
    $bayar = $_POST['bayar'];
    $lanjut = $_POST['lanjut'];
    $note = $_POST['note'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO daftar VALUES('', '$tgl', '$nrm', '$nama', '$lahir', '$jk', '$alamat', '$kel', '$kec', '$kota', '$keluh', '$poli', '$jenis', '$kasus', '$cara', '$bayar', '', '$lanjut', '$note', '$user')");
    header("Location: pasien.php");
}
// INPUT ANAMNESA ------------------------------------------------------------------------------------
if(isset($_GET['input_anamnesa'])){
    $id_daftar = $_GET['input_anamnesa'];
    $id_pasien = $_POST['id_pasien'];
    $tanggal = $_POST['tanggal'];
    $pasien = $_POST['pasien'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $poli = $_POST['poli'];
    $keluhan = $_POST['keluhan'];
    $alergi = $_POST['alergi'];
    $dahulu = $_POST['dahulu'];
    $sekarang = $_POST['sekarang'];
    $keluarga = $_POST['keluarga'];
    $darah = $_POST['darah'];
    $nadi = $_POST['nadi'];
    $suhu = $_POST['suhu'];
    $spo = $_POST['spo'];
    $berat = $_POST['berat'];
    $tinggi = $_POST['tinggi'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO anamnesa VALUES('$id_daftar', '$tanggal', '$id_pasien', '$pasien', '$tgl_lahir', '$keluhan', '$alergi', '$sekarang', '$dahulu', '$keluarga', '$darah', '$nadi', '$suhu', '$spo', '$berat', '$tinggi', '$user')");
    mysqli_query($conn, "UPDATE daftar SET poli='$poli' WHERE id='$id_daftar'");
    header("Location: anamnesa.php");
}
// INPUT PEMERIKSAAN ---------------------------------------------------------------------------------
if(isset($_GET['input_periksa'])){
    $id_daftar = $_GET['input_periksa'];
    $id_pasien = $_POST['id_pasien'];
    $pasien = $_POST['pasien'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $ma_anemis = isset($_POST['ma_anemis']) ? "Ya" : "Tidak";
    $ma_ikterik = isset($_POST['ma_ikterik']) ? "Ya" : "Tidak";
    $le_kelenjar = isset($_POST['le_kelenjar']) ? "Besar" : "Normal";
    $le_jvp = isset($_POST['le_jvp']) ? "Meningkat" : "Normal";
    $ja_suara = isset($_POST['ja_suara']) ? "Tidak Teratur" : "Teratur";
    $ja_irama = isset($_POST['ja_irama']) ? $_POST['ja_irama']  : "Normal";
    $pa_suara = isset($_POST['pa_suara']) ? $_POST['pa_suara'] : "Normal";
    $pe_hati = isset($_POST['pe_hati']) ? "Tidak Teraba" : "Teraba";
    $pe_limpa = isset($_POST['pe_limpa']) ? "Tidak Teraba" : "Teraba";
    $pe_usus = isset($_POST['pe_usus']) ? $_POST['pe_usus'] : "Normal";
    $pe_bentuk = isset($_POST['pe_bentuk']) ? $_POST['pe_bentuk'] : "Normal";
    $ge_bak = isset($_POST['ge_bak']) ? "Sulit" : "Normal";
    $ge_bercak = isset($_POST['ge_bercak']) ? "Ya" : "Tidak";
    $ek_atas = isset($_POST['ek_atas']) ? $_POST['ek_atas'] : "Normal";
    $ek_bawah = isset($_POST['ek_bawah']) ? $_POST['ek_bawah'] : "Normal";
    $ek_edema = isset($_POST['ek_edema']) ? "Ya" : "Tidak";
    $lainnya = $_POST['lainnya'];
    $icd = $_POST['icd'];
    $diagnosa = $_POST['diagnosa'];
    $note = $_POST['note'];
    $kasus = $_POST['kasus'];
    $lanjut = $_POST['lanjut'];
    $user = $u['nama'];
    mysqli_query($conn, "INSERT INTO periksa VALUES('$id_daftar', '$id_pasien', '$pasien', '$tgl_lahir', '$jk', '$ma_anemis', '$ma_ikterik', '$le_kelenjar', '$le_jvp', '$ja_suara', '$ja_irama', '$pa_suara', '$pe_hati', '$pe_limpa', '$pe_usus', '$pe_bentuk', '$ge_bak', '$ge_bercak', '$ek_atas', '$ek_bawah', '$edema', '$lainnya', '$icd', '$diagnosa', '$note', '$user')");
    mysqli_query($conn, "UPDATE daftar SET kasus='$kasus', lanjut='$lanjut' WHERE id='$id_daftar'");
    header("Location: tindakan.php?id=" . $id_daftar);
}
// INPUT TINDAKAN --------------------------------------------------------------------------------------
if(isset($_GET['add_tindak'])){
    $id = $_GET['add_tindak'];
    $id_daftar = $_POST['id_daftar'];
    $id_pasien = $_POST['id_pasien'];
    $pasien = $_POST['pasien'];
    $tanggal = $_POST['tanggal'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $tarif = $_POST['tarif'];
    $qty = $_POST['qty'];
    $satuan = $_POST['satuan'];
    $jumlah = $_POST['jumlah'];
    $note = $_POST['note'];
    $user = $u['nama'];   
    mysqli_query($conn, "INSERT INTO tindak VALUES('', '$tanggal', '$id_daftar', '$id_pasien', '$pasien', '$kode', '$nama', '$jenis', '$tarif', '$qty', '$satuan', '$jumlah', '$note', '', '', '$user')");
    header("Location: tindakan.php?id=" . $id);
}
// INPUT TINDAKAN --------------------------------------------------------------------------------------
if(isset($_GET['add_tindakAdm'])){
    $id = $_GET['add_tindakAdm'];
    $id_daftar = $_POST['id_daftar'];
    $id_pasien = $_POST['id_pasien'];
    $pasien = $_POST['pasien'];
    $tanggal = $_POST['tanggal'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $tarif = $_POST['tarif'];
    $qty = $_POST['qty'];
    $satuan = $_POST['satuan'];
    $jumlah = $_POST['jumlah'];
    $note = $_POST['note'];
    $user = $u['nama'];   
    mysqli_query($conn, "INSERT INTO tindak VALUES('', '$tanggal', '$id_daftar', '$id_pasien', '$pasien', '$kode', '$nama', '$jenis', '$tarif', '$qty', '$satuan', '$jumlah', '$note', '', '', '$user')");
    header("Location: admin_pay.php?id=" . $id);
}





// FUNGSI EDIT DATABASE --------------------------------------------------------------------------------
if(isset($_GET['edt_diag'])){
    $id = $_GET['edt_diag'];
    $chapter = $_POST['i_chapter'];
    $group = $_POST['i_group'];
    $code = $_POST['i_code'];
    $description = $_POST['i_description'];
    $category = $_POST['i_category'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE icd10 SET chapter='$chapter', `group`='$group', code='$code', `description`='$description', category='$category', user='$user' WHERE id='$id'");
    header("Location: data.php?table=diagnosa");
}
if(isset($_GET['edt_biaya'])){
    $id = $_POST['b_id'];
    $biaya = $_POST['b_nama'];
    $jenis = $_POST['b_jenis'];
    $satuan = $_POST['b_satuan'];
    $tarif = $_POST['b_tarif'];
    $ket = $_POST['b_ket'];
    $note = $_POST['b_note'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE biaya SET biaya='$biaya', jenis='$jenis', satuan='$satuan', tarif='$tarif', ket='$ket', note='$note', user='$user' WHERE id='$id'");
    header("Location: data.php?table=tindakan");
}
if(isset($_GET['edt_obat'])){
    $id = $_GET['edt_obat'];
    $obat = $_POST['o_nama'];
    $jenis = $_POST['o_jenis'];
    $satuan = $_POST['o_satuan'];
    $harga = $_POST['o_harga'];
    $stok = $_POST['o_stok'];
    $note = $_POST['o_note'];
    $minim = $_POST['o_minim'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE obat SET obat='$obat', jenis='$jenis', satuan='$satuan', harga='$harga', stok='$stok', minim='$minim', note='$note', user='$user' WHERE id='$id'");
    header("Location: data.php?table=obat");
}
// if(isset($_GET['edt_masuk'])){
//     $id = $_GET['edt_masuk'];
//     $tgl = $_POST['m_tgl'];
//     $ido = $_POST['m_ido'];
//     $obat = $_POST['m_obat'];
//     $jenis = $_POST['m_jenis'];
//     $harga = $_POST['m_harga'];
//     $qty = $_POST['m_qty'];
//     $total = $_POST['m_total'];
//     $note = $_POST['m_note'];
//     $user = $u['nama'];
//     mysqli_query($conn, "UPDATE masuk SET tanggal='$tgl', id_obat='$ido', obat='$obat', jenis='$jenis', harga='$harga', qty='$qty', total='$total', note='$note', user='$user' WHERE id='$id'");
//     header("Location: data.php?table=masuk");
// }
// EDIT DATA DAFTAR ------------------------------------------------------------------------------------
if(isset($_GET['edt_daftar'])){
    $id = $_POST['id'];
    $tgl = $_POST['tgl'];
    $nrm = $_POST['nrm'];
    $nama = $_POST['nama'];
    $lahir = $_POST['lahir'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $keluh = $_POST['keluh'];
    $poli = $_POST['poli'];
    $jenis = $_POST['jenis'];
    $kasus = $_POST['kasus'];
    $cara = $_POST['cara'];
    $bayar = $_POST['bayar'];
    $lanjut = $_POST['lanjut'];
    $note = $_POST['note'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE daftar SET tanggal='$tgl', id_pasien='$nrm', pasien='$nama', tgl_lahir='$lahir', jk='$jk', alamat='$alamat', keluhan='$keluh', poli='$poli', jenis='$jenis', kasus='$kasus', cara='$cara', bayar='$bayar', lanjut='$lanjut', note='$note', user='$user' WHERE id='$id'");
    header("Location: pasien.php");
}
// EDIT DATA PASIEN ------------------------------------------------------------------------------------
if(isset($_GET['edt_pasien'])){
    $id = $_GET['edt_pasien'];
    $tgl_reg = $_POST['tgl_reg'];
    $noid = $_POST['noid'];
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $kel = $_POST['kel'];
    $kec = $_POST['kec'];
    $kota = $_POST['kota'];
    $status = $_POST['status'];
    $pj = $_POST['pj'];
    $nama_pj = $_POST['nama_pj'];
    $telepon = $_POST['telepon'];
    $note = $_POST['note'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE pasien SET tgl_reg='$tgl_reg', noid='$noid', nama='$nama', tgl_lahir='$tgl_lahir', jk='$jk', alamat='$alamat', kel='$kel', kec='$kec', kota='$kota', `status`='$status', pj='$pj', nama_pj='$nama_pj', telepon='$telepon', note='$note', user='$user' WHERE id='$id'");
    header("Location: pasien_view.php");
}
// EDIT ANAMNESA ------------------------------------------------------------------------------------
if(isset($_GET['edit_anamnesa'])){
    $id_daftar = $_GET['edit_anamnesa'];
    $id_pasien = $_POST['id_pasien'];
    $tanggal = $_POST['tanggal'];
    $pasien = $_POST['pasien'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $poli = $_POST['poli'];
    $keluhan = $_POST['keluhan'];
    $alergi = $_POST['alergi'];
    $dahulu = $_POST['dahulu'];
    $sekarang = $_POST['sekarang'];
    $keluarga = $_POST['keluarga'];
    $darah = $_POST['darah'];
    $nadi = $_POST['nadi'];
    $suhu = $_POST['suhu'];
    $spo = $_POST['spo'];
    $berat = $_POST['berat'];
    $tinggi = $_POST['tinggi'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE anamnesa SET tanggal='$tanggal', id_pasien='$id_pasien', pasien='$pasien', tgl_lahir='$tgl_lahir', keluhan='$keluhan', alergi='$alergi', sekarang='$sekarang', dahulu='$dahulu', keluarga='$keluarga', darah='$darah', nadi='$nadi', suhu='$suhu', spo='$spo', berat='$berat', tinggi='$tinggi', user='$user' WHERE id_daftar='$id_daftar'");
    mysqli_query($conn, "UPDATE daftar SET poli='$poli' WHERE id='$id_daftar'");
    header("Location: anamnesa.php");
}
// EDIT PEMERIKSAAN ---------------------------------------------------------------------------------
if(isset($_GET['edit_periksa'])){
    $id_daftar = $_GET['edit_periksa'];
    $id_pasien = $_POST['id_pasien'];
    $pasien = $_POST['pasien'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk'];
    $ma_anemis = isset($_POST['ma_anemis']) ? "Ya" : "Tidak";
    $ma_ikterik = isset($_POST['ma_ikterik']) ? "Ya" : "Tidak";
    $le_kelenjar = isset($_POST['le_kelenjar']) ? "Besar" : "Normal";
    $le_jvp = isset($_POST['le_jvp']) ? "Meningkat" : "Normal";
    $ja_suara = isset($_POST['ja_suara']) ? "Tidak Teratur" : "Teratur";
    $ja_irama = isset($_POST['ja_irama']) ? $_POST['ja_irama']  : "Normal";
    $pa_suara = isset($_POST['pa_suara']) ? $_POST['pa_suara'] : "Normal";
    $pe_hati = isset($_POST['pe_hati']) ? "Tidak Teraba" : "Teraba";
    $pe_limpa = isset($_POST['pe_limpa']) ? "Tidak Teraba" : "Teraba";
    $pe_usus = isset($_POST['pe_usus']) ? $_POST['pe_usus'] : "Normal";
    $pe_bentuk = isset($_POST['pe_bentuk']) ? $_POST['pe_bentuk'] : "Normal";
    $ge_bak = isset($_POST['ge_bak']) ? "Sulit" : "Normal";
    $ge_bercak = isset($_POST['ge_bercak']) ? "Ya" : "Tidak";
    $ek_atas = isset($_POST['ek_atas']) ? $_POST['ek_atas'] : "Normal";
    $ek_bawah = isset($_POST['ek_bawah']) ? $_POST['ek_bawah'] : "Normal";
    $ek_edema = isset($_POST['ek_edema']) ? "Ya" : "Tidak";
    $lainnya = $_POST['lainnya'];
    $icd = $_POST['icd'];
    $diagnosa = $_POST['diagnosa'];
    $note = $_POST['note'];
    $kasus = $_POST['kasus'];
    $lanjut = $_POST['lanjut'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE periksa SET ma_anemis='$ma_anemis', ma_ikterik='$ma_ikterik', le_kelenjar='$le_kelenjar', le_jvp='$le_jvp', ja_suara='$ja_suara', ja_irama='$ja_irama', pa_suara='$pa_suara', pe_hati='$pe_hati', pe_limpa='$pe_limpa', pe_usus='$pe_usus', pe_bentuk='$pe_bentuk', ge_bak='$ge_bak', ge_bercak='$ge_bercak', ek_atas='$ek_atas', ek_bawah='$ek_bawah', ek_edema='$ek_edema', lainnya='$lainnya', icd='$icd', diagnosa='$diagnosa', note='$note', user='$user' WHERE id_daftar='$id_daftar'");
    mysqli_query($conn, "UPDATE daftar SET kasus='$kasus', lanjut='$lanjut' WHERE id='$id_daftar'");
    header("Location: tindakan.php?id=". $id_daftar);
}
//  CEKLIS PEMBAYARAN - EDIT DI DATA TINDAK ------------------------------------------------------------
if(isset($_GET['bayar'])){
    $id = $_GET['bayar'];
    $user = $u['nama'];
    mysqli_query($conn, "UPDATE tindak SET kasir='$user' WHERE id_daftar='$id' AND kasir=''");
    mysqli_query($conn, "UPDATE daftar SET status='$user' WHERE id='$id' AND status=''");
    header("Location: admin.php");
}

// CEKLIS AUTO MINUS STOK OBAT -------------------------------------------------------------------------
if(isset($_GET['out_obat'])){
    $kode = $_GET['out_obat'];
    $qty = $_GET['qty'];
    $idaf = $_GET['id'];
    $idti = $_GET['idti'];
    $user = $u['nama'];
    $obat = myquery("SELECT * FROM obat WHERE id='$kode'");
    $o = $obat[0];
    $stok = $o['stok'] - $qty;
    mysqli_query($conn, "UPDATE obat SET stok='$stok' WHERE id='$kode'");
    mysqli_query($conn, "UPDATE tindak SET apoteker='$user' WHERE id='$idti'");
    header("Location: farmasi_edit.php?id=" . $idaf);
}
// FUNGSI RESET SO -------------------------------------------------------------------------------------
if(isset($_GET['reset_so'])){
    mysqli_query($conn, "UPDATE opname SET so=0");
    header("Location: farmasi_stok.php");
}
// FUNGSI EMPTY SO -------------------------------------------------------------------------------------
if(isset($_GET['empty_so'])){
    mysqli_query($conn, "DELETE FROM opname");
    header("Location: farmasi_stok.php");
}






// FUNGSI DELETE ---------------------------------------------------------------------------------------
if(isset($_GET['del_dataobat'])){
    $id = $_GET['del_dataobat'];
    mysqli_query($conn, "DELETE FROM obat WHERE id='$id'");
    header("Location: data.php?table=obat");
}
if(isset($_GET['del_datatindakan'])){
    $id = $_GET['del_datatindakan'];
    mysqli_query($conn, "DELETE FROM biaya WHERE id='$id'");
    header("Location: data.php?table=tindakan");
}
if(isset($_GET['del_datadiagnosa'])){
    $id = $_GET['del_datadiagnosa'];
    mysqli_query($conn, "DELETE FROM icd10 WHERE id='$id'");
    header("Location: data.php?table=diagnosa");
}
if(isset($_GET['del_user'])){
    $id = $_GET['del_user'];
    mysqli_query($conn, "DELETE FROM user WHERE id='$id'");
    header("Location: user.php");
}
if(isset($_GET['del_daftar'])){
    $id = $_GET['del_daftar'];
    mysqli_query($conn, "DELETE FROM daftar WHERE id='$id'");
    header("Location: pasien.php");
}
if(isset($_GET['del_pasien'])){
    $id = $_GET['del_pasien'];
    mysqli_query($conn, "DELETE FROM pasien WHERE id='$id'");
    header("Location: pasien_view.php");
}
if(isset($_GET['del_tindak'])){
    $id = $_GET['del_tindak'];
    $id_periksa = $_GET['id'];
    mysqli_query($conn, "DELETE FROM tindak WHERE id='$id'");
    header("Location: tindakan.php?id=" . $id_periksa);
}
if(isset($_GET['del_tindakAdm'])){
    $id = $_GET['del_tindakAdm'];
    $id_periksa = $_GET['id'];
    mysqli_query($conn, "DELETE FROM tindak WHERE id='$id'");
    header("Location: admin_pay.php?id=" . $id_periksa);
}
if(isset($_GET['del_masuk'])){
    $id = $_GET['del_masuk'];
    $ido = $_GET['ido'];
    $qty = $_GET['qty'];
    mysqli_query($conn, "DELETE FROM masuk WHERE id='$id'");
    $DBobat = myquery("SELECT * FROM obat WHERE id='$ido'");
    $o = $DBobat[0];
    $stok = $o['stok'] - $qty;
    mysqli_query($conn, "UPDATE obat SET stok='$stok' WHERE id='$ido'");
    header("Location: farmasi_masuk.php");
}
if(isset($_GET['del_keluar'])){
    $id = $_GET['del_keluar'];
    $ido = $_GET['ido'];
    $qty = $_GET['qty'];
    mysqli_query($conn, "DELETE FROM keluar WHERE id='$id'");
    $DBobat = myquery("SELECT * FROM obat WHERE id='$ido'");
    $o = $DBobat[0];
    $stok = $o['stok'] + $qty;
    mysqli_query($conn, "UPDATE obat SET stok='$stok' WHERE id='$ido'");
    header("Location: farmasi_keluar.php");
}



?>