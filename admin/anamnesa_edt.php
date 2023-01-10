<?php 
include 'sidebar.php';
// Memilih Query Input atau Edit
if(isset($_GET['input'])){
    $id = $_GET['input'];
    $cek = myquery("SELECT * FROM daftar WHERE id='$id'");
    $row = $cek[0];
    $id = $row['id'];
}elseif(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $cek = myquery("SELECT * FROM anamnesa WHERE id_daftar='$id'");
    $row = $cek[0];
    $id = $row['id_daftar'];
}
?>
<main>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= isset($_GET['input']) ? "Input Anamnesa" : "Edit Anamnesa" ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="anamnesa.php"><button type="button" class="btn btn-outline-secondary">
                <span data-feather="arrow-left"  class="feather-13"></span>  
                Kembali
                </button></a>
            </div>
        </div>
    </div>
    <!-- Form Pengisian Anamnesa & TTV -->
    <form class="row g-3" action="functions.php?<?= isset($_GET['input']) ? "input_anamnesa=". $id : "edit_anamnesa=". $id ?>" method="POST">
        <div class="col-md-3">
            <label for="id_pasien" class="form-label">No. RM</label>
            <input type="hidden" class="form-control" name="id_daftar" value="<?= $id; ?>" readonly>
            <input type="text" class="form-control" name="id_pasien" value="<?= $row['id_pasien']; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="text" class="form-control" name="tanggal" value="<?= $row['tanggal']; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="pasien" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="pasien" value="<?= $row['pasien']; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="text" class="form-control" name="tgl_lahir" value="<?= $row['tgl_lahir']; ?>" readonly>
        </div>
        <div class="col-md-4">
            <label for="poli" class="form-label">Poli yang dituju</label>
            <select type="text" class="form-select" name="poli">
                <?php if(isset($_GET['edit'])){
                    $daftar = myquery("SELECT * FROM daftar WHERE id='$id'");
                    $daf = $daftar[0];
                    ?>
                <option value="<?= $daf['poli']; ?>"><?= $daf['poli']; ?></option>
                <?php }else{ ?>
                <option value="-">.. pilih ..</option>
                <?php } ?>
                <option>Umum</option>
                <option>KIA</option>
                <option>Hypnotherapy</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="keluhan" class="form-label">Keluhan Utama</label>
            <input type="text" class="form-control" name="keluhan" value="<?= isset($_GET['edit']) ? $row['keluhan'] : '' ?>" required>
        </div>
        <div class="col-md-4">
            <label for="alergi" class="form-label">Alergi Obat</label>
            <input type="text" class="form-control" name="alergi" value="<?= isset($_GET['edit']) ? $row['alergi'] : '-' ?>" required>
        </div>
        <div class="col-md-4">
            <label for="sekarang" class="form-label">Riwayat Penyakit Sekarang</label>
            <input type="text" class="form-control" name="sekarang" value="<?= isset($_GET['edit']) ? $row['sekarang'] : '-' ?>" required>
        </div>
        <div class="col-md-4">
            <label for="dahulu" class="form-label">Riwayat Penyakit Dahulu</label>
            <input type="text" class="form-control" name="dahulu" value="<?= isset($_GET['edit']) ? $row['dahulu'] : '-' ?>" required>
        </div>
        <div class="col-md-4">
            <label for="keluarga" class="form-label">Riwayat Penyakit Keluarga</label>
            <input type="text" class="form-control" name="keluarga" value="<?= isset($_GET['edit']) ? $row['keluarga'] : '-' ?>" required>
        </div>
        <!-- Form Pengisian Anamnesa & TTV -->
        <h1 class="h2">TTV</h1>
        <div class="col-md-2">
            <label for="darah" class="form-label">Tekanan Darah (mmHg)</label>
            <input type="text" class="form-control" name="darah" value="<?= isset($_GET['edit']) ? $row['darah'] : '' ?>" required>
        </div>
        <div class="col-md-2">
            <label for="nadi" class="form-label">Denyut Nadi (x/m)</label>
            <input type="text" class="form-control" name="nadi" value="<?= isset($_GET['edit']) ? $row['nadi'] : '' ?>" required>
        </div>
        <div class="col-md-2">
            <label for="suhu" class="form-label">Suhu Tubuh (&deg;C)</label>
            <input type="text" class="form-control" name="suhu" value="<?= isset($_GET['edit']) ? $row['suhu'] : '' ?>" required>
        </div>
        <div class="col-md-2">
            <label for="spo" class="form-label">SPO 2 (%)</label>
            <input type="text" class="form-control" name="spo" value="<?= isset($_GET['edit']) ? $row['spo'] : '' ?>" required>
        </div>
        <div class="col-md-2">
            <label for="berat" class="form-label">Berat Badan (kg)</label>
            <input type="text" class="form-control" name="berat" value="<?= isset($_GET['edit']) ? $row['berat'] : '' ?>" required>
        </div>
        <div class="col-md-2">
            <label for="tinggi" class="form-label">Tinggi Badan (cm)</label>
            <input type="text" class="form-control" name="tinggi" value="<?= isset($_GET['edit']) ? $row['tinggi'] : '' ?>" required>
        </div>
        <div class="col-md-3 align-items-center pt-3">
            <input type="submit" class="btn btn-success" value="Simpan"></button>
            <a href="anamnesa.php" type="reset" class="btn btn-secondary">Batal</a>
        </div>
    </form>
    
    <br>
</main>