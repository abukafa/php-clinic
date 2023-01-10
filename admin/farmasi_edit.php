<?php 
include 'sidebar.php';
$id = $_GET['id'];
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pengambilan Obat</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <a href="farmasi.php"><button type="button" class="btn btn-sm btn-outline-secondary">
          <span data-feather="arrow-left"  class="feather-13"></span>  
          Kembali
        </button></a>
      </div>
    </div>
  </div>
  <form class="row g-3">
    <?php 
    $periksa = myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
    $per = $periksa[0];
    ?>
    <div class="col-md-3">
        <label for="id" class="form-label">No. RM</label>
        <input type="text" class="form-control" name="id" value="<?= $per['id_pasien']; ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" value="<?= $per['pasien']; ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="lhr" class="form-label">Tanggal Lahir</label>
        <input type="text" class="form-control" name="lhr" value="<?= $per['tgl_lahir']; ?>" readonly>
    </div>
    <div class="col-md-3">
        <label for="jk" class="form-label">Jenis Kelamin</label>
        <input type="text" class="form-control" name="jk" value="<?= $per['jk']; ?>" readonly>
    </div>
    <div class="col-md-2">
        <label for="icd" class="form-label">ICD-10</label>
        <input type="text" class="form-control" name="icd" value="<?= $per['icd']; ?>" readonly>
    </div>
    <div class="col-md-4">
        <label for="diag" class="form-label">Diagnosa</label>
        <input type="text" class="form-control" name="diag" value="<?= $per['diagnosa']; ?>" readonly>
    </div>
    <div class="col-md-6">
        <label for="ctn" class="form-label">Catatan</label>
        <input type="text" class="form-control" name="ctn" value="<?= $per['note']; ?>" readonly>
    </div>
    <br>
    <!-- Tampilkan data Tindakan - Hanya Jenis Obat -->
    <div class="table-responsive mt-5">
      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Kode</th>
            <th scope="col">Merek Obat</th>
            <th class="col-md-4">Kandungan</th>
            <th scope="col">Catatan</th>
            <th scope="col">Qty</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Diambil</th>
            <th scope="col">STOK</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php 
            $no=1;
            $tindak = myquery("SELECT * FROM tindak WHERE id_daftar='$id' AND LEFT(kode,1)='R'");
            foreach($tindak as $tin) :
              $kode = $tin['kode'];
            ?>
            <td><?= $no ?></td>
            <td><?= $kode ?></td>
            <td><?= $tin['nama'] ?></td>
            <td><?= $tin['jenis'] ?></td>
            <td><?= $tin['note'] ?></td>
            <td><?= $tin['qty'] . " " . $tin['satuan'] ?></td>
            <!-- Cek Stok Obat dari data Obat -->
            <?php 
            $obat = myquery("SELECT * FROM obat WHERE id='$kode'");
            $o = $obat[0];
            ?>
            <td><?= $o['note'] ?></td>
            <td>
              <!-- Query Ceklist pengambilan obat Otomatis Mengurangi Stok -->
              <div class="form-check form-switch">
                <?php if($tin['apoteker'] == ""){ ?>
                <input type="checkbox" class="form-check-input" id="cekstok" onclick="window.location.href='functions.php?out_obat=<?= $kode ?>&qty=<?= $tin['qty'] ?>&id=<?= $id ?>&idti=<?= $tin['id'] ?>'">
                <?php }else{ ?>
                <input type="checkbox" class="form-check-input" id="cekstok" checked disabled>
                <?php } ?>                
              </div>
            </td>
            <td><?= $o['stok'] ?></td>
          </tr>
          <?php 
          $no++;
          endforeach;
          ?>
        </tbody>
      </table>
      <br>
      <div>
        <!-- Query Ceklis Resep sudah diambil -->
        <a class="btn btn-success" href="farmasi.php">Selesai</a>
      </div>
      <br>
      <!-- Modal Entri Data Obat -->
      <!-- <div class="modal fade" id="staticBackdropLive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLiveLabel">Edit Data Obat - Resep Dokter</h5>
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
                  <label class="form-label" for="kdo">Kode Obat</label>
                  <select type="text" class="form-control form-control-sm" name="kdo" id="kdo" >
                      <option value="-">.. pilih ..</option>
                      <option>Umum</option>
                      <option>KIA</option>
                      <option>Hypnotherapy</option>
                  </select>
                </div>
                <div class="mb-2">
                  <label class="form-label" for="jenis">Jenis</label>
                  <input type="text" class="form-control form-control-sm" name="jenis" id="jenis" readonly>
                </div>
                <div class="mb-2">
                  <label class="form-label" for="nama">Nama Obat</label>
                  <input type="text" class="form-control form-control-sm" name="nama" id="nama" readonly>
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
      </div>  -->
    </div>
  </form>
  <br>
</main>