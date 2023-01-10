<?php 
include 'sidebar_alt.php';
// Memilih Query Input atau Edit
if(isset($_GET['input'])){
    $param = "input=";
    $id = $_GET['input'];
    $cek = myquery("SELECT * FROM daftar WHERE id='$id'");
    $row = $cek[0];
    $id = $row['id'];
}elseif(isset($_GET['edit'])){
    $param = "edit=";
    $id = $_GET['edit'];
    $daftar = myquery("SELECT * FROM daftar WHERE id='$id'");
    $daf = $daftar[0];
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
            <a href="dokter.php"><button type="button" class="btn btn-outline-secondary">
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
        <!-- Form Check Pemeriksaan -->
        <fieldset class="col-md-2 mb-3">
            <legend>Mata</legend>
            <div class="form-check">
                <input type="checkbox" name="ma_anemis" class="form-check-input" <?= isset($_GET['edit']) && $row['ma_anemis'] == 'Ya' ? 'checked' : '' ?>>
                <label class="form-check-label">Konjungtiva Anemis</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="ma_ikterik" class="form-check-input" <?= isset($_GET['edit']) && $row['ma_ikterik'] == 'Ya' ? 'checked' : '' ?>>
                <label class="form-check-label">Konjungtiva Ikterik</label>
            </div>
        </fieldset>
        <fieldset class="col-md-2 mb-3">
            <legend>Leher</legend>
            <div class="form-check">
                <input type="checkbox" name="le_kelenjar" class="form-check-input" <?= isset($_GET['edit']) && $row['le_kelenjar'] == 'Besar' ? 'checked' : '' ?>>
                <label class="form-check-label">Kelenjar Getah Bening</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="le_jvp" class="form-check-input" <?= isset($_GET['edit']) && $row['le_jvp'] == 'Meningkat' ? 'checked' : '' ?>>
                <label class="form-check-label">JVP</label>
            </div>
        </fieldset>
        <fieldset class="col-md-2 mb-3">
            <legend>Jantung</legend>
            <div class="mb-3 form-check">
                <input type="checkbox" name="ja_suara" class="form-check-input" <?= isset($_GET['edit']) && $row['ja_suara'] == 'Tidak Teratur' ? 'checked' : '' ?>>
                <label class="form-check-label">Suara : Tidak Teratur</label>
            </div>
            <div class="form-check">
                <input type="radio" name="ja_irama" class="form-check-input" value="Gallop" <?= isset($_GET['edit']) && $row['ja_irama'] == 'Gallop' ? 'checked' : '' ?>>
                <label class="form-check-label">Irama : Gallop</label>
            </div>
            <div class="mb-3 form-check">
                <input type="radio" name="ja_irama" class="form-check-input" value="Murmur" <?= isset($_GET['edit']) && $row['ja_irama'] == 'Murmur' ? 'checked' : '' ?>>
                <label class="form-check-label">Irama : Murmur</label>
            </div>
            <legend>Paru</legend>
            <div class="form-check">
                <input type="radio" name="pa_suara" class="form-check-input" value="Wheezing" <?= isset($_GET['edit']) && $row['pa_suara'] == 'Wheezing' ? 'checked' : '' ?>>
                <label class="form-check-label">Suara : Wheezing</label>
            </div>
            <div class="form-check">
                <input type="radio" name="pa_suara" class="form-check-input" value="Ronhe" <?= isset($_GET['edit']) && $row['pa_suara'] == 'Ronhe' ? 'checked' : '' ?>>
                <label class="form-check-label">Suara : Ronhe</label>
            </div>
        </fieldset>
        <fieldset class="col-md-2 mb-3">
            <legend>Perut</legend>
            <div class="form-check">
                <input type="checkbox" name="pe_hati" class="form-check-input" <?= isset($_GET['edit']) && $row['pe_hati'] == 'Tidak Teraba' ? 'checked' : '' ?>>
                <label class="form-check-label">Hati : Tidak Teraba</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="pe_limpa" class="form-check-input" <?= isset($_GET['edit']) && $row['pe_limpa'] == 'Tidak Teraba' ? 'checked' : '' ?>>
                <label class="form-check-label">Limpa : Tidak Teraba</label>
            </div>
            <div class="form-check">
                <input type="radio" name="pe_usus" class="form-check-input" value="Normal" <?= isset($_GET['edit']) && $row['pe_usus'] == 'Normal' ? 'checked' : '' ?>>
                <label class="form-check-label">Bising Usus (+) Normal</label>
            </div>
            <div class="form-check">
                <input type="radio" name="pe_usus" class="form-check-input" value="Berlebih" <?= isset($_GET['edit']) && $row['pe_usus'] == 'Berlebih' ? 'checked' : '' ?>>
                <label class="form-check-label">Bising Usus (+) Berlebih</label>
            </div>
            <div class="mb-3 form-check">
                <input type="radio" name="pe_usus" class="form-check-input" value="Negatif" <?= isset($_GET['edit']) && $row['pe_usus'] == 'Negatif' ? 'checked' : '' ?>>
                <label class="form-check-label">Bising Usus (-)</label>
            </div>
            <div class="form-check">
                <input type="radio" name="pe_bentuk" class="form-check-input" value="Distensi" <?= isset($_GET['edit']) && $row['pe_bentuk'] == 'Distensi' ? 'checked' : '' ?>>
                <label class="form-check-label">Bentuk : Distensi</label>
            </div>
            <div class="mb-3 form-check">
                <input type="radio" name="pe_bentuk" class="form-check-input" value="Supel" <?= isset($_GET['edit']) && $row['pe_bentuk'] == 'Supel' ? 'checked' : '' ?>>
                <label class="form-check-label">Bentuk : Supel</label>
            </div>
        </fieldset>
        <fieldset class="col-md-2 mb-3">
            <legend>Genital</legend>
            <div class="form-check">
                <input type="checkbox" name="ge_bak" class="form-check-input" <?= isset($_GET['edit']) && $row['ge_bak'] == 'Sulit' ? 'checked' : '' ?>>
                <label class="form-check-label">BAK : Sulit</label>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="ge_bercak" class="form-check-input" <?= isset($_GET['edit']) && $row['ge_bercak'] == 'Ya' ? 'checked' : '' ?>>
                <label class="form-check-label">Bercak</label>
            </div>
        </fieldset>
        <fieldset class="col-md-2 mb-3">
        <legend>Ekstremitas</legend>
            <div class="form-check">
                <input type="radio" name="ek_atas" class="form-check-input" value="Dingin" <?= isset($_GET['edit']) && $row['ek_atas'] == 'Dingin' ? 'checked' : '' ?>>
                <label class="form-check-label">Atas : Dingin</label>
            </div>
            <div class="mb-3 form-check">
                <input type="radio" name="ek_atas" class="form-check-input" value="Hangat" <?= isset($_GET['edit']) && $row['ek_atas'] == 'Hangat' ? 'checked' : '' ?>>
                <label class="form-check-label">Atas : Hangat</label>
            </div>
            <div class="form-check">
                <input type="radio" name="ek_bawah" class="form-check-input" value="Dingin" <?= isset($_GET['edit']) && $row['ek_bawah'] == 'Dingin' ? 'checked' : '' ?>>
                <label class="form-check-label">Bawah : Dingin</label>
            </div>
            <div class="mb-3 form-check">
                <input type="radio" name="ek_bawah" class="form-check-input" value="Hangat" <?= isset($_GET['edit']) && $row['ek_bawah'] == 'Hangat' ? 'checked' : '' ?>>
                <label class="form-check-label">Bawah : Hangat</label>
            </div>
            <div class="form-check">
                <input type="checkbox" name="ek_edema" class="form-check-input" <?= isset($_GET['edit']) && $row['ek_edema'] == 'Ya' ? 'checked' : '' ?>>
                <label class="form-check-label">Edema</label>
            </div>
        </fieldset>
        <div class="col-md-6">
            <label for="lain" class="form-label">Pemeriksaan Lainnya</label>
            <textarea type="text" class="form-control" name="lainnya"><?= isset($_GET['edit']) ? $row['lainnya'] : '' ?></textarea>
        </div>
        <div class="col-md-6">
            <label for="ctn" class="form-label">Catatan</label>
            <textarea type="text" class="form-control" name="note"><?= isset($_GET['edit']) ? $row['note'] : '' ?></textarea>
        </div>
        <!-- Memanggil data Diagnosa berdasarkan Kode ICD-10 -->
        <div class="col-md-8">
            <label for="icd" class="form-label">ICD-10</label>
            <select type="text" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-width="100%" style="max-width: 100%" name="icd" id="icd" onchange="diagnos(this.value)">
                <option value="<?= isset($_GET['edit']) ? $row['icd'] : '' ?>"><?= isset($_GET['edit']) ? $row['icd'] ." - ". $row['diagnosa'] : '.. kode' ?></option>
                <?php 
                $icd10 = myquery("SELECT * FROM icd10 ORDER BY description");
                $jsArray2 = "var diag = new Array();\n";
                foreach($icd10 as $i) :
                    echo "<option style='white-space: normal' value='". $i['code']. "'>". $i['code'] ." - ". $i['description'] ."</option>";
                    $jsArray2 .= "diag['". $i['code'] ."'] = {code:'". addslashes($i['code']) ."', desc:'". addslashes($i['description']) ."'};\n";
                endforeach;
                ?>
            </select>
        </div>
        <div class="col-md-12" hidden>
            <label for="diag" class="form-label">Diagnosa</label>
            <input type="text" class="form-control" name="diagnosa" id="diagnosa" value="<?= isset($_GET['edit']) ? $row['diagnosa'] : '' ?>" readonly>
        </div>
        <div class="col-md-2">
            <label for="lanjut" class="form-label">Tindak Lanjut</label>
            <select type="text" class="form-select" name="lanjut" id="lanjut">
                <option><?= isset($_GET['edit']) ? $daf['lanjut'] : '.. pilih' ?></option>
                <option>Dirawat</option>
                <option>Dirujuk</option>
                <option>Pulang</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="kasus" class="form-label">Jenis Kasus</label>
            <input type="text" class="form-control" name="kasus" id="kasus" value="<?= isset($_GET['edit']) ? $daf['kasus'] : '' ?>" readonly>
        </div>
        <div class="col-md-3 align-items-center pt-5">
            <!-- Simpan data dan Lanjut ke Form Tindakan -->
            <h6><span data-feather="arrow-right"  class="feather-13"></span> Lanjut ke Tindakan</h6>    
            <input type="reset" class="btn btn-outline-secondary" value="Reset">
            <a href="dokter.php" type="reset" class="btn btn-secondary">Batal</a>
            <input type="submit" class="btn btn-success" value="Lanjutkan"></button>
            <!-- <a href="tindakan.php" type="reset" class="btn btn-success">Lanjutkan</a> -->
        </div>
    </form>
    <br>
</main>

<!-- javascript -->
<link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">
<script src="../assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script> 
<script src="../assets/js/bootstrap-select.min.js"></script>
<script>
    // selectable select option
    $('.selectpicker').selectpicker();
    // deskripsi diagnosa dari icd (disembunyikan)
    <?= $jsArray2; ?>
    function diagnos(icd){
        document.getElementById('diagnosa').value = diag[icd].desc;    
    };
    // ajax cek kasus lama atau baru
    var myicd = document.getElementById('icd');
    var kasus = document.getElementById('kasus');
    icd.addEventListener('change', function(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if( xhr.readyState == 4 && xhr.status == 200 ){
                kasus.value = xhr.responseText;
            }
        }
        xhr.open('GET', 'ajax/kasus.php?kode=' + myicd.value, true);
        xhr.send();
    });
</script>