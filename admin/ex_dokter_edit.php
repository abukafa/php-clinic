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
    $cek = myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
    $row = $cek[0];
    $id = $row['id_daftar'];
}
?>
<main>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?= isset($_GET['input']) ? "Input Diagnosa" : "Edit Diagnosa" ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            <a href="dokter.php"><button type="button" class="btn btn-sm btn-outline-secondary">
                <span data-feather="arrow-left"  class="feather-13"></span>  
                Kembali
            </button></a>
            </div>
        </div>
    </div>
    <!-- Form Pemeriksaan dan Diagnosa -->
    <form class="row g-3" action="functions.php?<?= isset($_GET['input']) ? "input_periksa=". $id : "edit_periksa=". $id ?>" method="POST">
        <div class="col-md-3">
            <label for="id_pasien" class="form-label">No. RM</label>
            <input type="hidden" class="form-control" name="id_daftar" value="<?= $id; ?>" readonly>
            <input type="text" class="form-control" name="id_pasien" value="<?= $row['id_pasien']; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="pasien" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="pasien" value="<?= $row['pasien']; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="text" class="form-control" name="tgl_lahir" value="<?= $row['tgl_lahir']; ?>" readonly>
        </div>
        <div class="col-md-3">
            <label for="jk" class="form-label">Jenis Kelamin</label>
            <input type="text" class="form-control" name="jk" value="<?= $row['jk']; ?>" readonly>
        </div>
        <div class="col-md-2">
            <label for="mata" class="form-label">Mata</label>
            <select type="text" class="form-select" name="ma_anemis">
                <option value="<?= isset($_GET['edit']) ? $row['ma_anemis'] : '' ?>"><?= isset($_GET['edit']) ? $row['ma_anemis'] : '.. Anemis' ?></option>
                <option>Ya</option>
                <option>Tidak</option>
            </select>
            <select type="text" class="form-select" name="ma_ikterik">
                <option value="<?= isset($_GET['edit']) ? $row['ma_ikterik'] : '' ?>"><?= isset($_GET['edit']) ? $row['ma_ikterik'] : '.. Ikterik' ?></option>
                <option>Ya</option>
                <option>Tidak</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="leher" class="form-label">Leher</label>
            <select type="text" class="form-select" name="le_kelenjar">
                <option value="<?= isset($_GET['edit']) ? $row['le_kelenjar'] : '' ?>"><?= isset($_GET['edit']) ? $row['le_kelenjar'] : '.. Kelenjar' ?></option>
                <option>Besar</option>
                <option>Normal</option>
            </select>
            <select type="text" class="form-select" name="le_jvp">
                <option value="<?= isset($_GET['edit']) ? $row['le_jvp'] : '' ?>"><?= isset($_GET['edit']) ? $row['le_jvp'] : '.. JVP' ?></option>
                <option>Meningkat</option>
                <option>Normal</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="jantung" class="form-label">Jantung</label>
            <select type="text" class="form-select" name="ja_suara">
                <option value="<?= isset($_GET['edit']) ? $row['ja_suara'] : '' ?>"><?= isset($_GET['edit']) ? $row['ja_suara'] : '.. Suara' ?></option>
                <option>Teratur</option>
                <option>Tidak Teratur</option>
            </select>
            <select type="text" class="form-select" name="ja_irama">
                <option value="<?= isset($_GET['edit']) ? $row['ja_irama'] : '' ?>"><?= isset($_GET['edit']) ? $row['ja_irama'] : '.. Irama' ?></option>
                <option>Gallop</option>
                <option>Murmur</option>
                <option>Normal</option>
            </select>
            <label for="jantung" class="form-label pt-1">Paru</label>
            <select type="text" class="form-select" name="pa_suara">
                <option value="<?= isset($_GET['edit']) ? $row['pa_suara'] : '' ?>"><?= isset($_GET['edit']) ? $row['pa_suara'] : '.. Suara' ?></option>
                <option>Wheezing</option>
                <option>Ronhe</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="perut" class="form-label">Perut</label>
            <select type="text" class="form-select" name="pe_hati">
                <option value="<?= isset($_GET['edit']) ? $row['pe_hati'] : '' ?>"><?= isset($_GET['edit']) ? $row['pe_hati'] : '.. Hati' ?></option>
                <option>Teraba</option>
                <option>Tidak Teraba</option>
            </select>
            <select type="text" class="form-select" name="pe_limpa">
                <option value="<?= isset($_GET['edit']) ? $row['pe_limpa'] : '' ?>"><?= isset($_GET['edit']) ? $row['pe_limpa'] : '.. Limpa' ?></option>
                <option>Teraba</option>
                <option>Tidak Teraba</option>
            </select>
            <select type="text" class="form-select" name="pe_usus">
                <option value="<?= isset($_GET['edit']) ? $row['pe_usus'] : '' ?>"><?= isset($_GET['edit']) ? $row['pe_usus'] : '.. Usus' ?></option>
                <option>Positif</option>
                <option>Negatif</option>
            </select>
            <select type="text" class="form-select" name="pe_bentuk">
                <option value="<?= isset($_GET['edit']) ? $row['pe_bentuk'] : '' ?>"><?= isset($_GET['edit']) ? $row['pe_bentuk'] : '.. Bentuk' ?></option>
                <option>Distensi</option>
                <option>Supel</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="gemital" class="form-label">Genital</label>
            <select type="text" class="form-select" name="ge_bak">
                <option value="<?= isset($_GET['edit']) ? $row['ge_bak'] : '' ?>"><?= isset($_GET['edit']) ? $row['ge_bak'] : '.. BAK' ?></option>
                <option>Normal</option>
                <option>Sulit</option>
            </select>
            <select type="text" class="form-select" name="ge_bercak">
                <option value="<?= isset($_GET['edit']) ? $row['ge_bercak'] : '' ?>"><?= isset($_GET['edit']) ? $row['ge_bercak'] : '.. Bercak' ?></option>
                <option>Ya</option>
                <option>Tidak</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="ekstrem" class="form-label">Ekstremitas</label>
            <select type="text" class="form-select" name="ek_atas">
                <option value="<?= isset($_GET['edit']) ? $row['ek_atas'] : '' ?>"><?= isset($_GET['edit']) ? $row['ek_atas'] : '.. Atas' ?></option>
                <option>Dingin</option>
                <option>Hangat</option>
            </select>
            <select type="text" class="form-select" name="ek_bawah">
                <option value="<?= isset($_GET['edit']) ? $row['ek_bawah'] : '' ?>"><?= isset($_GET['edit']) ? $row['ek_bawah'] : '.. Bawah' ?></option>
                <option>Dingin</option>
                <option>Hangat</option>
            </select>
            <select type="text" class="form-select" name="ek_edema">
                <option value="<?= isset($_GET['edit']) ? $row['ek_edema'] : '' ?>"><?= isset($_GET['edit']) ? $row['ek_edema'] : '.. Edema' ?></option>
                <option>Ya</option>
                <option>Tidak</option>
            </select>
        </div>
        <div class="col-md-12">
            <label for="lain" class="form-label">Pemeriksaan Lainnya</label>
            <input type="text" class="form-control" name="lainnya" value="<?= isset($_GET['edit']) ? $row['lainnya'] : '' ?>">
        </div>
        <!-- Memanggil data Diagnosa berdasarkan Kode ICD-10 -->
        <div class="col-md-2">
            <label for="icd" class="form-label">ICD-10</label>
            <select type="text" class="form-select" name="icd" id="icd" onchange="diagnos(this.value)">
                <option value="<?= isset($_GET['edit']) ? $row['icd'] : '' ?>"><?= isset($_GET['edit']) ? $row['icd'] : '.. Kode' ?></option>
                <?php 
                $icd10 = myquery("SELECT * FROM icd10 ORDER BY code");
                $jsArray2 = "var diag = new Array();\n";
                foreach($icd10 as $i) :
                    echo "<option value='". $i['code']. "'>". $i['code'] ." - ". $i['description'] ."</option>";
                    $jsArray2 .= "diag['". $i['code'] ."'] = {desc:'". addslashes($i['description']) ."'};\n";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="diag" class="form-label">Diagnosa</label>
            <input type="text" class="form-control" name="diagnosa" id="diagnosa" value="<?= isset($_GET['edit']) ? $row['diagnosa'] : '' ?>" readonly>
        </div>
            <script type="text/javascript">
                <?= $jsArray2; ?>
                function diagnos(icd){
                    document.getElementById('diagnosa').value = diag[icd].desc;
                }
            </script>
        <div class="col-md-6">
            <label for="ctn" class="form-label">Catatan</label>
            <input type="text" class="form-control" name="note" value="<?= isset($_GET['edit']) ? $row['note'] : '' ?>">
        </div>
        <div class="col-md-3 align-items-center pt-3">
            <!-- Simpan data dan Lanjut ke Form Tindakan -->
            <h6><span data-feather="arrow-right"  class="feather-13"></span> Lanjut ke Tindakan</h6>    
            <a href="dokter.php" type="reset" class="btn btn-secondary">Batal</a>
            <input type="submit" class="btn btn-success" value="Lanjutkan"></button>
            <!-- <a href="tindakan.php" type="reset" class="btn btn-success">Lanjutkan</a> -->
        </div>
    </form>
    <br>
</main>