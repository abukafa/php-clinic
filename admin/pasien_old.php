<?php 
include 'sidebar_alt.php';
?>
<main>
    <!-- Header & Pembatas -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pendaftaran Pasien Lama</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            <a href="pasien.php"><button type="button" class="btn btn-outline-secondary">
                <span data-feather="arrow-left"  class="feather-15"></span>
                Kembali
            </button></a>
            </div>
            <div class="btn-group me-2">
            <a href="pasien_view.php"><button type="button" class="btn btn-outline-secondary">
                <span data-feather="user"  class="feather-15"></span>
                Pasien
            </button></a>
            </div>
        </div>
    </div>
    <!-- Form Input Data Rawat Jalan -->
    <form class="row g-3" action="functions.php?add_old" method="POST">
        <div class="col-md-3">
            <label for="tgl" class="form-label">Tanggal</label>
            <input type="text" class="form-control" name="tgl" id="tgl" value="<?= date('Y-m-d') ?>" require>
        </div>
        <!-- Memanggil data Pasien dengan id (NRM) -->
        <div class="col-md-3">
            <label for="nrm" class="form-label">No. RM</label>
            <div class="input-group">
                <select type="list" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-width="100%" style="width: 100%" name="nrm" id="nrm" onchange="pilihPasien(this.value)">
                    <option value="" data-width="100%" style="width: 100%;">.. pilih ..</option>
                    <?php 
                    $pasien = myquery("SELECT * FROM pasien ORDER BY nama");
                    $jsArray2 = "var pasNo = new Array();\n";
                    foreach($pasien as $p) :
                        echo "<option style='white-space:normal' value='". $p['id']. "'>". $p['id'] ." - ". $p['nama'] ."</option>";
                        $jsArray2 .= "pasNo['". $p['id'] ."'] = {tgl_reg:'". addslashes($p['tgl_reg']) ."', noid:'". addslashes($p['noid']) ."', nama:'". addslashes($p['nama']) ."', lahir:'". addslashes($p['tgl_lahir']) ."', jk:'". addslashes($p['jk']) ."', alamat:'". addslashes($p['alamat']) ."', kel:'". addslashes($p['kel']) ."', kec:'". addslashes($p['kec']) ."', kota:'". addslashes($p['kota']) ."', status:'". addslashes($p['status']) ."', pj:'". addslashes($p['pj']) ."', nama_pj:'". addslashes($p['nama_pj']) ."', telepon:'". addslashes($p['telepon']) ."'};\n";
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label for="tgl_reg" class="form-label">Tanggal Registrasi</label>
            <input type="text" class="form-control" name="tgl_reg" id="tgl_reg" readonly>
        </div>
        <div class="col-md-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" readonly>
        </div>
        <div class="col-md-3">
            <label for="noid" class="form-label">No. Identitas</label>
            <input type="text" class="form-control" name="noid" id="noid" readonly>
        </div>
        <div class="col-md-3">
            <label for="lahir" class="form-label">Tanggal Lahir</label>
            <input type="text" class="form-control" name="lahir" id="lahir" readonly>
        </div>
        <div class="col-md-3">
            <label for="umur" class="form-label">Umur</label>
            <input type="text" class="form-control" name="umur" id="umur" readonly>
        </div>
        <div class="col-md-3">
            <label for="jk" class="form-label">Jenis Kelamin</label>
            <input type="text" class="form-control" name="jk" id="jk" readonly>
        </div>
        <div class="col-md-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="alamat" readonly>
        </div>
        <div class="col-md-3">
            <label for="kel" class="form-label">Kelurahan</label>
            <input type="text" class="form-control" name="kel" id="kel" readonly>
        </div>
        <div class="col-md-3">
            <label for="kec" class="form-label">Kecamatan</label>
            <input type="text" class="form-control" name="kec" id="kec" readonly>
        </div>
        <div class="col-md-3">
            <label for="kota" class="form-label">Kota</label>
            <input type="text" class="form-control" name="kota" id="kota" readonly>
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" name="status" id="status" readonly>
            <!-- <select type="text" class="form-select" name="status" readonly>
                <option>Menikah</option>
                <option>Lajang</option>
                <option>Janda</option>
                <option>Duda</option>
            </select> -->
        </div>
        <div class="col-md-3">
            <label for="hp" class="form-label">No. Handphone</label>
            <input type="text" class="form-control" name="hp" id="hp" readonly>
        </div>
        <div class="col-md-3">
            <label for="pj" class="form-label">Penanggung jawab</label>
            <input type="text" class="form-control" name="pj" id="pj" readonly>
            <!-- <select type="text" class="form-select" name="pj" readonly>
                <option value="-">.. pilih ..</option>
                <option>Ayah</option>
                <option>Ibu</option>
                <option>Suami</option>
                <option>Istri</option>
                <option>Lainnya</option>
            </select> -->
        </div>
        <div class="col-md-3">
            <label for="npj" class="form-label">Nama Penanggung jawab</label>
            <input type="text" class="form-control" name="npj" id="npj" readonly>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Rawat Jalan</h1></div>

        <!-- disembunyikan dipakai -->
        <div class="col-md-12" hidden>
            <label for="keluh" class="form-label">Keluhan</label>
            <input type="text" class="form-control" name="keluh" value="-">
        </div>
        <div class="col-md-4" hidden>
            <label for="poli" class="form-label">Poli yang dituju</label>
            <select type="text" class="form-select" name="poli">
                <option value="-">.. pilih ..</option>
                <option>Umum</option>
                <option>KIA</option>
                <option>Hypnotherapy</option>
            </select>
        </div>
        <!---------------------------------->
        <div class="col-md-3">
            <label for="jenis" class="form-label">Jenis Kunjungan</label>
            <select type="text" class="form-select" name="jenis" required>
                <option>Lama</option>
                <option>Baru</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="kasus" class="form-label">Jenis Kasus</label>
            <select type="text" class="form-select" name="kasus" required>
                <option>-</option>
                <option>Baru</option>
                <option>Lama</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="cara" class="form-label">Cara Kunjungan</label>
            <select type="text" class="form-select" name="cara" required>
                <option value="-">.. pilih ..</option>
                <option>Datang Sendiri</option>
                <option>Rujukan Dokter lain</option>
                <option>Rujukan Bidan lain</option>
                <option>lainnya</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="bayar" class="form-label">Jenis Pembayaran</label>
            <select type="text" class="form-select" name="bayar" required>
                <option value="-">.. pilih ..</option>
                <option>Umum</option>
                <option>Gratis</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="lanjut" class="form-label">Tindak Lanjut Pelayanan</label>
            <select type="text" class="form-select" name="lanjut" required>
                <option>-</option>
                <option>Dirawat</option>
                <option>Dirujuk</option>
                <option>Pulang</option>
            </select>
        </div>
        <div class="col-md-9">
            <label for="note" class="form-label">Catatan</label>
            <input type="text" class="form-control" name="note">
        </div>
        <div class="col-md-3 align-items-center pt-3">
            <input type="submit" class="btn btn-success" value="Simpan"></button>
            <a href="pasien.php" type="reset" class="btn btn-secondary">Batal</a>
        </div>
    </form>
    <br>

    <!-- Selektor Tanggal -->
    <!-- <script src="../assets/js/jquery-editable-select.js"></script> -->
    <link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">
    <script src="../assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-select.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $('.selectpicker').selectpicker();
        // $('#nrm').editableSelect();
        $(function() {
            $('#tgl').datepicker({ 
            autoclose: true,
            todayHighlight: true,
            format : 'yyyy-mm-dd' 
            });
        });
        <?= $jsArray2; ?>
        function pilihPasien(nrm){
            document.getElementById('nama').value = pasNo[nrm].nama;
            document.getElementById('tgl_reg').value = pasNo[nrm].tgl_reg;
            document.getElementById('noid').value = pasNo[nrm].noid;
            document.getElementById('lahir').value = pasNo[nrm].lahir;
            document.getElementById('jk').value = pasNo[nrm].jk;
            document.getElementById('alamat').value = pasNo[nrm].alamat;
            document.getElementById('kel').value = pasNo[nrm].kel;
            document.getElementById('kec').value = pasNo[nrm].kec;
            document.getElementById('kota').value = pasNo[nrm].kota;
            document.getElementById('status').value = pasNo[nrm].status;
            document.getElementById('hp').value = pasNo[nrm].telepon;
            document.getElementById('pj').value = pasNo[nrm].pj;
            document.getElementById('npj').value = pasNo[nrm].nama_pj;
            // document.getElementById('umur').value = umur(tglLahir.value, "-", "-", "-");
        };
        // ajax hitung umur
        var nrm = document.getElementById('nrm');
        var tglLhr = document.getElementById('lahir');
        var myUmur = document.getElementById('umur');
        nrm.addEventListener('change', function(){
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(){
                if( xhr.readyState == 4 && xhr.status == 200 ){
                    myUmur.value = xhr.responseText;
                }
            }
            xhr.open('GET', 'ajax/hitung_umur.php?tglLahir=' + tglLhr.value, true);
            xhr.send();
        });
    </script>
</main>