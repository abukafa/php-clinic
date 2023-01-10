<?php 
include 'sidebar_alt.php';
$id = $_GET['id'];
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Tindakan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <a href="admin.php"><button type="button" class="btn btn-outline-secondary">
          <span data-feather="arrow-left"  class="feather-13"></span>  
          Kembali
        </button></a>
      </div>
    </div>
  </div>
  <form class="row g-3" action="functions.php?add_tindakAdm=<?= $id ?>" method="post">
    <?php 
    $periksa = myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
    $per = $periksa[0];
    ?>
    <div class="col-md-3">
        <label for="id_pasien" class="form-label">No. RM</label>
        <input type="hidden" class="form-control" name="id_daftar" value="<?= $per['id_daftar'] ?>" readonly>
        <input type="text" class="form-control" name="id_pasien" value="<?= $per['id_pasien'] ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="pasien" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="pasien" value="<?= $per['pasien'] ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
        <input type="text" class="form-control" name="tgl_lahir" value="<?= $per['tgl_lahir'] ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="jk" class="form-label">Jenis Kelamin</label>
        <input type="text" class="form-control" name="jk" value="<?= $per['jk'] ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" required>
    </div>
    <!-- Memanggil Data Tindakan & Jasa Lainnya -->
    <div class="col-md-3">
        <label for="kode" class="form-label">Kode</label>
        <select type="text" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-width="100%" style="width: 100%" name="kode" id="kode" onchange="changeValue(this.value)">
            <option value="">.. pilih ..</option>
            <?php 
            $biaya = myquery("SELECT * FROM biaya ORDER BY id");
            $jaBiaya = "var biaya = new Array();\n";
            foreach($biaya as $b) :
                echo "<option style='white-space: normal' value='". $b['id']. "'>". $b['id'] ." - ". $b['biaya'] ."</option>";
                $jaBiaya .= "biaya['". $b['id'] ."'] = {nama:'". addslashes($b['biaya']) ."', jenis:'". addslashes($b['jenis']) ."', tarif:'". addslashes($b['tarif']) ."', ket:'". addslashes($b['ket']) ."',  satuan:'". addslashes($b['satuan']) ."'};\n";
            endforeach;
            ?>
        </select>
    </div>
    <div class="col-md-3">
        <label for="nama" class="form-label">Tindakan</label>
        <input type="text" class="form-control" name="nama" id="nama" readonly>
    </div>
    <div class="col-md-3">
        <label for="jenis" class="form-label">Jenis</label>
        <input type="text" class="form-control" name="jenis" id="jenis" readonly>
    </div>
    <div class="col-md-3">
        <label for="note" class="form-label">Catatan</label>
        <input type="text" class="form-control" name="note" required>
    </div>
    <div class="col-md-1">
        <label for="qty" class="form-label">Qty</label>
        <input type="text" class="form-control" name="qty" id="qty" onkeyup=hitung()>
    </div>
    <div class="col-md-1">
        <label for="satuan" class="form-label">Satuan</label>
        <input type="text" class="form-control" name="satuan" id="satuan" readonly>
    </div>
    <div class="col-md-2">
        <label for="tarif" class="form-label">Tarif</label>
        <input type="text" class="form-control" name="tarif" id="tarif" onkeyup=hitung() readonly>
    </div>
    <div class="col-md-2">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="text" class="form-control" name="jumlah" id="jumlah" readonly>
    </div>
    <div class="col-md-3">
        <label for="ket" class="form-label">Keterangan</label>
        <input type="text" class="form-control" name="ket" id="ket" readonly>
    </div>
    <script>
      <?= $jaBiaya; ?>
      var nama = document.getElementById('nama');
      var jumlah = document.getElementById('jumlah');
      function changeValue(kode){
        document.getElementById('nama').value = biaya[kode].nama;
        document.getElementById('jenis').value = biaya[kode].jenis;
        document.getElementById('tarif').value = biaya[kode].tarif;
        document.getElementById('ket').value = biaya[kode].ket;
        document.getElementById('satuan').value = biaya[kode].satuan;
        if(nama.value == "Potongan"){
          jumlah.removeAttribute('readonly');
        }else{
          var rOnly = document.createAttribute('readonly');
          jumlah.setAttributeNode(rOnly);
        }
      }
      
      function hitung(){
        var trf = document.getElementById('tarif').value;
        var qty = document.getElementById('qty').value;
        var ttl = trf*qty;
        jumlah.value = ttl;
      }
    </script>
    <div class="col-md-3 align-items-center pt-3">
        <input type="submit" class="btn btn-success" value="Tambah"></button>
        <a type="reset" href="admin.php" class="btn btn-secondary">Batal</a>
        <input type="reset" class="btn btn-outline-secondary" value="Reset">
    </div>
    <div class="col-md-3">
    </div>
    <!-- Tampilkan Total Tagihan -->
    <?php 
    $tagihan = myquery("SELECT SUM(jumlah) as total FROM tindak WHERE id_daftar='$id' AND kasir=''");
    $tag = $tagihan[0];
    ?>
    <div class="col-md-2">
        <label for="total" class="form-label">Total</label>
        <input type="text" class="form-control" name="total" id="total" value="<?= $tag['total'] ?>" onkeyup=hitungBayar() readonly>
    </div>
    <div class="col-md-2">
        <label for="kembali" class="form-label">Kembalian</label>
        <input type="text" class="form-control" name="kembali" id="kembali" onkeyup=hitungBayar() readonly>
    </div>
    <div class="col-md-2">
        <label for="bayar" class="form-label">Bayar</label>
        <input type="text" class="form-control" name="bayar" id="bayar" onkeyup=hitungBayar()>
    </div>
    <script>
      function hitungBayar(){
        var total = document.getElementById('total').value;
        var bayar = document.getElementById('bayar').value;
        var kembali = bayar-total;
        document.getElementById('kembali').value = kembali;
      }
    </script>
  </form>
  <br>
  <?php 
  $tindak = myquery("SELECT * FROM tindak WHERE id_daftar='$id' AND kasir='' ORDER BY kode");
  if($tindak){
  ?>
  <!-- Menampilkan Data BELUUM BAYAR -->
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Nama</th>
          <th class="col-md-4">Jenis</th>
          <th scope="col">Qty</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Note</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          foreach($tindak as $tin) :
            $idt = $tin['id'];
          ?>
          <td><?= $tin['tanggal']; ?></td>
          <td><?= $tin['nama']; ?></td>
          <td><?= $tin['jenis']; ?></td>
          <td><?= $tin['qty'] ." ". $tin['satuan']; ?></td>
          <td><?= number_format($tin['jumlah'], 0, '.', ',') ?></td>
          <!-- Jika Obat Tampilkan Stok obat tsb -->
          <td><?= $tin['note']; ?></td>
          <td align="right">    
            <a onclick="if(confirm('Apakah anda yakin akan menghapus data dengan ID : <?php echo $idt; ?> ??')){ location.href='functions.php?del_tindakAdm=<?= $idt ?>&id=<?= $tin['id_daftar'] ?>' }"><button id="del_tindak" class="btn btn-sm btn-danger float-md-end" <?php if($u['nama'] !== $tin['user']){echo "disabled";} ?>><span class="feather-15" data-feather="trash-2"></span></button></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br>
    <!-- Simpan data dan Lanjut Cetak Struk -->
    <h6><span data-feather="arrow-right"  class="feather-13"></span> Lanjut Pembayaran</h6>  
    <div>
      <a class="btn btn-success" href="functions.php?bayar=<?= $id ?>">Simpan</a>
      <a class="btn btn-success" href="admin_lstruk.php?id=<?= $id ?>" target="_blank"><span data-feather="printer"  class="feather-13"></span> Struk</a>
      <!-- <a class="btn btn-secondary" href="admin_lstruk2.php?id=<?= $id ?>" target="_blank"><span data-feather="printer"  class="feather-13"></span> Rincian</a> -->
    </div>
    <br>
    <?php } ?>
  </div>
  <br>
  
  <!-- Menampilkan Data SUDAH LUNAS -->
  <?php 
  $query = "SELECT * FROM tindak WHERE id_daftar='$id' AND kasir<>'' ORDER BY kode";
  $cek = myNumRow($query);
  if($cek){ ?>
  <div class="table-responsive" style="font-size: 13px">
    <table class="table table-light table-bordered table-sm">
      <thead>
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Nama</th>
          <th class="col-md-4">Jenis</th>
          <th scope="col">Qty</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Note</th>
          <th scope="col">Paid</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          $lunas = myquery($query);
          foreach($lunas as $paid) :
          ?>
          <td><?= $paid['tanggal']; ?></td>
          <td><?= $paid['nama']; ?></td>
          <td><?= $paid['jenis']; ?></td>
          <td><?= $paid['qty'] ." ". $paid['satuan']; ?></td>
          <td><?= number_format($paid['jumlah'], 0, '.', ',') ?></td>
          <!-- Jika Obat Tampilkan Stok obat tsb -->
          <td><?= $paid['note']; ?></td>
          <td align="center">    
            <span data-feather="check"  class="feather-15"></span></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a class="btn btn-secondary mb-4" href="admin_lstruk2.php?id=<?= $id ?>" target="_blank"><span data-feather="printer"  class="feather-13"></span> Rincian</a>
  </div>
  <?php } ?>

  <!-- Selektor Tanggal -->
  <!-- <link rel="stylesheet" href="../assets/css/bootstrap-datepicker3.min.css"> -->
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
</div>   -->