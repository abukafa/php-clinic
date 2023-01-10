<?php
include '../config.php';
include '../functions.php';
?>

<!-- Memanggil data Pasien dengan id (NRM) -->
<div id="myForm" class="col-md-3">
    <label for="nrm" class="form-label">No. RM</label>
    <div class="input-group">
        <select type="list" class="form-select" data-live-search="true" data-style="btn-secondary" data-width="100%" style="width: 100%" name="nrm" id="nrm" onchange="pilihPasien(this.value)">
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


<script type="text/javascript">
// $('.selectpicker').selectpicker();
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
</script>