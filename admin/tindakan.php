<?php 
include 'sidebar_alt.php';
$id = $_GET['id'];
?>
<main>
  <div id="line" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2" type="button" onclick="myFunction()">
      <span id="chev2" data-feather="chevron-down" style="display:block"></span>
      <span id="chev1" data-feather="chevron-up" style="display:none"></span>
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <a href="dokter_edit.php?edit=<?= $id; ?>"><button type="button" class="btn btn-outline-secondary">
          <span data-feather="arrow-left"  class="feather-13"></span>  
          Kembali
        </button></a>
      </div>
    </div>
  </div>
  <!-- Menampilkan 1 data Query Diagnosa -->
  <div id="myDIV" style="display:none">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h2>Hasil Diagnosa</h2>
    </div>
    <div class="row g-3">
      <?php 
      $cek = myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
      $row = $cek[0];
      ?>
      <div class="col-md-3">
          <label for="id_pasien" class="form-label">No. RM</label>
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
      <!-- Tabel Pemeriksaan -->
      <div class="table-responsive">
        <table class="table table-sm table-bordered">
          <tbody style="background-color:#e9ecef">
          <tr>
            <th class="col-md-2"><span data-feather="chevron-right"></span> Mata</th>
            <th class="col-md-2"><span data-feather="chevron-right"></span> Leher</th>
            <th class="col-md-2"><span data-feather="chevron-right"></span> Jantung</th>
            <th class="col-md-2"><span data-feather="chevron-right"></span> Perut</th>
            <th class="col-md-2"><span data-feather="chevron-right"></span> Genital</th>
            <th class="col-md-2"><span data-feather="chevron-right"></span> Ekstremitas</th>
          </tr>
          <tr>
            <td>Anemis : <?= $row['ma_anemis']; ?></td>
            <td>Kelenjar : <?= $row['le_kelenjar']; ?></td>
            <td>Suara : <?= $row['ja_suara']; ?></td>
            <td>Hati : <?= $row['pe_hati']; ?></td>
            <td>BAK : <?= $row['ge_bak']; ?></td>
            <td>Atas : <?= $row['ek_atas']; ?></td>
          </tr>
          <tr>
            <td>Ikterik : <?= $row['ma_ikterik']; ?></td>
            <td>JVP : <?= $row['le_jvp']; ?></td>
            <td>Irama : <?= $row['ja_irama']; ?></td>
            <td>Limpa : <?= $row['pe_limpa']; ?></td>
            <td>Bercak : <?= $row['ge_bercak']; ?></td>
            <td>Bawah : <?= $row['ek_bawah']; ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <th><span data-feather="chevron-right"></span> Paru</th>
            <td>Bising Usus : <?= $row['pe_usus']; ?></td>
            <td></td>
            <td>Edema : <?= $row['ek_edema']; ?></td>
          </tr>
            <td></td>
            <td></td>
            <td>Suara : <?= $row['pa_suara']; ?></td>
            <td>Bentuk : <?= $row['pe_bentuk']; ?></td>
            <td></td>
            <td></td>
          </tr>
          </tbody>
          <tr>
            <td colspan="6" style="color:snow"></td>
          </tr>
          <tbody style="background-color:#e9ecef">
          <tr>
            <th colspan="3"><span data-feather="chevron-right"></span> Pemeriksaan Lainnya</th>
            <th colspan="3"><span data-feather="chevron-right"></span> Catatan</th>
          </tr>
          <tr>
            <td colspan="3"><?= $row['lainnya']; ?></td>
            <td colspan="3"><?= $row['note']; ?></td>
          </tr>
          </tbody>
          <tr>
            <td colspan="6" style="color:snow"></td>
          </tr>
          <tbody style="background-color:#e9ecef">
          <tr>
            <th><span data-feather="chevron-right"></span> Kode</th>
            <th colspan="5"><span data-feather="chevron-right"></span> Diagnosa</th>
          </tr>
          <tr>
            <td><?= $row['icd']; ?></td>
            <td colspan="5"><?= $row['diagnosa']; ?></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <script>
    function myFunction() {
      var x = document.getElementById("myDIV");
      var y = document.getElementById("chev2");
      var z = document.getElementById("chev1");
      var l = document.getElementById("line");
      if (x.style.display === "none") {
        x.style.display = "block";
        z.style.display = "block";
        y.style.display = "none";
        l.setAttribute("class", "d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3");
      } else {
        x.style.display = "none";
        z.style.display = "none";
        y.style.display = "block";
        l.setAttribute("class", "d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom");
      }
    }
  </script>
  <!-- <script> 
    function myShowFunction() {
    document.getElementById("panel").style.display = "block";
    }
  </script> -->
  <!-- Form Input data Tindakan -->
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Terapi & Tindakan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <a><span class="float-md-end" data-feather="arrow-down"></span></a>
      </div>
    </div>
  </div>
  <form class="row g-3" action="functions.php?add_tindak=<?= $id; ?>" method="POST">
    <div class="col-md-2">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" required>
    </div>
    <div class="col-md-6">
        <label for="kode" class="form-label">Kode</label>
        <select type="text" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-width="100%" style="width: 100%" name="kode" id="kode"  onchange="changeValue(this.value)">
          <option value="">.. pilih ..</option>
            <?php 
            $obat = myquery("SELECT * FROM obat ORDER BY jenis DESC");
            $jaObat = "var obat = new Array();\n";
            foreach($obat as $o) :
                echo "<option style='white-space: normal' value='". $o['id']. "'>". $o['id'] ." - ". $o['obat'] ." - ". $o['jenis'] ."</option>";
                $jaObat .= "obat['". $o['id'] ."'] = {merek:'". addslashes($o['obat']) ."', kandung:'". addslashes($o['jenis']) ."', harga:'". addslashes($o['harga']) ."', stok:'". addslashes($o['stok']) ."',  satuan:'". addslashes($o['satuan']) ."'};\n";
            endforeach;
            $biaya = myquery("SELECT * FROM biaya ORDER BY id");
            $jaBiaya = "var biaya = new Array();\n";
            foreach($biaya as $b) :
                echo "<option style='white-space: normal' value='". $b['id']. "'>". $b['id'] ." - ". $b['biaya'] ." - ". $b['jenis'] ."</option>";
                $jaBiaya .= "biaya['". $b['id'] ."'] = {nama:'". addslashes($b['biaya']) ."', jenis:'". addslashes($b['jenis']) ."', tarif:'". addslashes($b['tarif']) ."', ket:'". addslashes($b['ket']) ."',  satuan:'". addslashes($b['satuan']) ."'};\n";
            endforeach;
            ?>
        </select>
    </div>
    <div class="col-md-2" hidden>
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" id="nama" readonly>
    </div>
    <div class="col-md-4">
        <label for="jenis" class="form-label">Jenis</label>
        <input type="text" class="form-control" name="jenis" id="jenis" readonly>
    </div>
    <div class="col-md-2">
        <label for="note" class="form-label">Dosis / Catatan</label>
        <input type="text" class="form-control" name="note" id="note" required>
    </div>
    <div class="col-md-1">
        <label for="qty" class="form-label">Qty</label>
        <input type="text" class="form-control" name="qty" id="qty" onkeyup=etang() required>
        <!-- <div class="valid-feedback">Stok OK..</div>
        <div class="invalid-feedback">Stok Kurang !!</div> -->
    </div>
    <div class="col-md-1">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text" class="form-control" name="satuan" id="satuan" readonly>
    </div>
    <div class="col-md-2">
        <label for="tarif" class="form-label">Tarif</label>
        <input type="text" class="form-control" name="tarif" id="tarif" onchange=etang() readonly>
    </div>
    <div class="col-md-2">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="text" class="form-control" name="jumlah" id="jumlah" onchange=etang() readonly>
        <input type="hidden" class="form-control" name="id_daftar" value="<?= $row['id_daftar']; ?>" readonly>
        <input type="hidden" class="form-control" name="id_pasien" value="<?= $row['id_pasien']; ?>" readonly>
        <input type="hidden" class="form-control" name="pasien" value="<?= $row['pasien']; ?>" readonly>
    </div>
    <div class="col-md-4">
        <label for="ket" class="form-label">Keterangan</label>
        <input type="text" class="form-control" name="ket" id="ket" readonly>
	</div>
    <div class="col-md-3 align-items-center pt-3">
        <input type="submit" id="submit" class="btn btn-success" value="Simpan" disabled></button>
        <a href="dokter.php" type="reset" class="btn btn-secondary">Selesai</a>
        <input type="reset" class="btn btn-outline-secondary" value="Reset">
    </div>
    <script type="text/javascript">
      function changeValue(kode){
        str = document.getElementById('kode').value;
        if( str.substr(NaN ,1) == "R" ){
          <?= $jaObat; ?>
          document.getElementById('nama').value = obat[kode].merek;
          document.getElementById('jenis').value = obat[kode].kandung;
          document.getElementById('tarif').value = obat[kode].harga;
          document.getElementById('ket').value = obat[kode].stok;
          document.getElementById('satuan').value = obat[kode].satuan;
        }else{
          <?= $jaBiaya; ?>
          document.getElementById('nama').value = biaya[kode].nama;
          document.getElementById('jenis').value = biaya[kode].jenis;
          document.getElementById('tarif').value = biaya[kode].tarif;
          document.getElementById('ket').value = biaya[kode].ket;
          document.getElementById('satuan').value = biaya[kode].satuan;
        }
      }
      function etang(){
        var ket = document.getElementById('ket');
        var qty = document.getElementById('qty');
        var trf = document.getElementById('tarif');
        var btn = document.getElementById('submit');
        var dis = document.createAttribute('disabled');
          if(qty.value <= 0){
            qty.className = "form-control";
            btn.setAttributeNode(dis);
          }else if (parseInt(qty.value) > parseInt(ket.value)){
            qty.className = "form-control is-invalid";
            btn.setAttributeNode(dis);
          }else if(parseInt(qty.value) <= parseInt(ket.value) || isNaN(ket.value)){
            qty.className = "form-control is-valid";
            btn.removeAttribute('disabled');
          }
        jml = qty.value * trf.value;
        document.getElementById('jumlah').value = jml;
      }
    </script>
  </form>
  <br>
  <!-- Menampilkan Tabel Data Tindakan -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Tanggal</th>
          <th class="col-4">Jenis</th>
          <th scope="col">Nama</th>
          <th scope="col">Qty</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Note</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          $tindak = myquery("SELECT * FROM tindak WHERE id_daftar='$id' AND kasir='' ORDER BY kode");
          foreach($tindak as $tin) :
          ?>
          <td><?= $tin['tanggal']; ?></td>
          <td><?= $tin['jenis']; ?></td>
          <td><?= $tin['nama']; ?></td>
          <td><?= $tin['qty'] ." ". $tin['satuan']; ?></td>
          <td><?= number_format($tin['jumlah'], 0, '.', ',') ?></td>
          <!-- Jika Obat Tampilkan Stok obat tsb -->
          <td><?= $tin['note']; ?></td>
          <td align="right">    
            <a onclick="if(confirm('Apakah anda yakin akan menghapus data dengan ID : <?php echo $tin['id']; ?> ??')){ location.href='functions.php?del_tindak=<?= $tin['id']; ?>&id=<?= $id; ?>' }" class="btn btn-sm btn-danger <?= $tin['apoteker']<>"" ? 'disabled' : '' ?>"><span data-feather="trash-2"  class="feather-15"></span></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">
    <script src="../assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/bootstrap-select.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('.selectpicker').selectpicker();
        $(function() {
            $('#tanggal').datepicker({ 
            autoclose: true,
            todayHighlight: true,
            format : 'yyyy-mm-dd' 
            });
        });
      </script>
  </div>
</main>





    <!-- Modal Edit Data Tindakan -->
    <!-- <div class="modal fade" id="staticBackdropLive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLiveLabel">Edit Data Terapi & Tindakan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form role="form" action="farmasi_editact.php" method="post">
              <div class="mb-2">
                <label class="form-label" for="tgl">Tanggal</label>
                <input type="text" class="form-control form-control-sm" name="tgl" id="tgl">
              </div>
              <div class="mb-2">
                <label class="form-label" for="nrm">No. RM</label>
                <input type="text" class="form-control form-control-sm" name="nrm" id="nrm" readonly>
              </div>
              <div class="mb-2">
                <label class="form-label" for="nama">Nama Pasien</label>
                <input type="text" class="form-control form-control-sm" name="nama" id="nama" readonly>
              </div>
              <div class="mb-2">
                Memanggil data Tindakan, Obat & Tarif
                <label class="form-label" for="kode">Kode</label>
                <select type="text" class="form-select form-select-sm" name="kode" id="kode" >
                    <option value="-">.. pilih ..</option>
                </select>
              </div>
              <div class="mb-2">
                <label class="form-label" for="jenis">Jenis</label>
                <input type="text" class="form-control form-control-sm" name="jenis" id="jenis" readonly>
              </div>
              <div class="mb-2">
                <label class="form-label" for="nama">Nama Tindakan / Obat</label>
                <input type="text" class="form-control form-control-sm" name="nama" id="nama" readonly>
              </div>
              <div class="mb-2">
                Jika Obat Tampilkan Stok obat tsb
                <label class="form-label" for="note">Catatan / Stok</label>
                <input type="text" class="form-control form-control-sm" name="note" id="note" readonly>
              </div>
              <div class="mb-2">
                  <label for="ket" class="form-label">Keterangan</label>
                  <input type="text" class="form-control form-control-sm" id="ket">
              </div>
              <div class="mb-2">
                  <label for="qty" class="form-label">Qty</label>
                  <input type="text" class="form-control form-control-sm" id="qty">
              </div>
              <div class="mb-2">
                <label class="form-label" for="harga">Harga</label>
                <input type="text" class="form-control form-control-sm" name="harga" id="harga" readonly>
              </div>
              <div class="mb-2">
                  <label for="adm" class="form-label">Admin</label>
                  <input type="text" class="form-control form-control-sm" id="adm" readonly>
              </div>
              <br>
              <div class="modal-footer">  
                <button type="submit" class="btn btn-success">Rubah</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>          -->
    <!-- Selektor Tanggal -->