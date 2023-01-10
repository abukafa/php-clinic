<?php 
include 'sidebar.php';
?>
<main>
  <!-- Header & Pembatas -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Registrasi Pasien Baru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <a href="pasien.php"><button type="button" class="btn btn-outline-secondary">
          <span data-feather="arrow-left"  class="feather-15"></span>
          Kembali
        </button></a>
      </div>
    </div>
  </div>
  <!-- Form Input Data PASIEN BARU + Rawat Jalan AUTO save ke dua database -->
  <form class="row g-3" action="functions.php?add_new" method="POST">
    <div class="col-md-3">
        <label for="nrm" class="form-label">No. RM</label>
        <input type="text" class="form-control" name="nrm" value="<?= autoCode('pasien', 'id', '') ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="tgl" class="form-label">Tanggal Registrasi</label>
        <input type="text" class="form-control" name="tgl" id="tgl" value="<?= date('Y-m-d') ?>" required>
    </div>
    <div class="col-md-6">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" required>
    </div>
    <div class="col-md-3">
        <label for="noid" class="form-label">No. Identitas</label>
        <input type="text" class="form-control" name="noid" required>
    </div>
    <div class="col-md-3">
        <label for="lhr" class="form-label">Tanggal Lahir</label>
        <input type="text" class="form-control" name="lhr" id="lhr" required>
    </div>
    <div class="col-md-3">
        <label for="umur" class="form-label">Umur</label>
        <input type="text" class="form-control" name="umur" id="umur" readonly>
    </div>
    <div class="col-md-3">
        <label for="jk" class="form-label">Jenis Kelamin</label>
        <Select type="text" class="form-select" name="jk" required>
          <option value="-">.. pilih ..</option>
          <option>Laki-laki</option>
          <option>Perempuan</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" name="alamat" required>
    </div>
    <div class="col-md-3">
        <label for="kel" class="form-label">Kelurahan</label>
        <input type="text" class="form-control" name="kel">
    </div>
    <div class="col-md-3">
        <label for="kec" class="form-label">Kecamatan</label>
        <input type="text" class="form-control" name="kec">
    </div>
    <div class="col-md-3">
        <label for="kota" class="form-label">Kota</label>
        <input type="text" class="form-control" name="kota">
    </div>
    <div class="col-md-3">
        <label for="status" class="form-label">Status</label>
        <select type="text" class="form-select" name="status" required>
            <option value="-">.. pilih ..</option>
            <option>Menikah</option>
            <option>Lajang</option>
            <option>Janda</option>
            <option>Duda</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="hp" class="form-label">No. Handphone</label>
        <input type="text" class="form-control" name="hp" required>
    </div>
    <div class="col-md-3">
        <label for="pj" class="form-label">Penanggung jawab</label>
        <select type="text" class="form-select" name="pj" required>
            <option value="-">.. pilih ..</option>
            <option>Ayah</option>
            <option>Ibu</option>
            <option>Suami</option>
            <option>Istri</option>
            <option>Lainnya</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="npj" class="form-label">Nama Penanggung jawab</label>
        <input type="text" class="form-control" name="npj" required>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Rawat Jalan</h1></div>
            
        <!-- disembunyikan tidak dipakai -->
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
                <option>Baru</option>
                <option>Lama</option>
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
  <script src="../assets/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript">
    $(function() {
        $('#tgl').datepicker({ 
        autoclose: true,
        todayHighlight: true,
        format : 'yyyy-mm-dd' 
        });
    });
    $(function() {
        $('#lhr').datepicker({ 
        autoclose: true,
        todayHighlight: true,
        format : 'yyyy-mm-dd' 
        });
    });
    // ajax hitung umur
    var tglLhr = document.getElementById('lhr');
    var myUmur = document.getElementById('umur');
    tglLhr.addEventListener('input', function(){
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