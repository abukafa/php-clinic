<?php 
include 'sidebar.php';
$p = date('M Y');
$n = date('Y-m-d');
$w = date('Y-m-d', strtotime('-1 week'));
$m = date('Y-m-d', strtotime('-1 month'));
$s = date('Y-m-d', strtotime('-6 month'));
$y = date('Y-m-d', strtotime('-1 year'));
?>
<main> 
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Rekam Medis</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!-- Filter Data Rekam Medis -->
      <?php if($u['bagian']=="RM" || $u['akses']=="Superuser"){ ?> 
      <form action="" method="get">
        <div class="input-group">
          <div class="input-group-text p-0">
            <select class="form-select bg-light border-0" name="filter" id="filter" onchange=setFocus()>
              <option value="">.. Filter ..</option>
              <option value="daftar.jk">Jenis Kelamin</option>
              <option value="daftar.kel">Alamat (Kel.)</option>
              <option value="daftar.poli">Poliklinik</option>
              <option value="periksa.user">Nama Dokter</option>
              <option value="periksa.icd">ICD-10</option>
              <option value="periksa.diagnosa">Diagnosa</option>
              <option value="daftar.jenis">Jenis Kunjungan</option>
              <option value="daftar.cara">Cara Kunjungan</option>
              <option value="daftar.kasus">Kasus</option>
`             <option value="daftar.lanjut">Tindak Lanjut</option>
              <option value="daftar.bayar">Pembayaran</option>
            </select>
          </div>
          <input type="text" name="data" id="data" class="form-control" placeholder="Filter Data..">
          <select name="tgl_awal" id="tgl_awal" class="input-group-text bg-light px-1" onchange="this.form.submit()">
            <option value="">Semua</option>
            <option value="<?php echo $n ?>">1 Hari</option>
            <option value="<?php echo $w ?>">1 Pekan</option>
            <option value="<?php echo $m ?>">1 Bulan</option>
            <option value="<?php echo $y ?>">1 Tahun</option>
          </select>
        </div>
        <script>
          function setFocus(){
            document.getElementById('data').focus();
          }
        </script>
      </form>
      <?php } ?>
    </div>
  </div>
  <!-- Cek filter Data -->
  <?php
  $query = "SELECT max(daftar.tanggal) as tgl, daftar.id, daftar.id_pasien, daftar.pasien, daftar.jk, daftar.tgl_lahir, daftar.alamat, daftar.kel, daftar.kec, daftar.kota, daftar.poli, daftar.jenis, daftar.cara, daftar.kasus, daftar.lanjut, daftar.bayar, periksa.icd, periksa.diagnosa, periksa.user, periksa.note FROM daftar INNER JOIN periksa ON periksa.id_daftar=daftar.id ";
  if(isset($_GET['tgl_awal'])){
    $a = $_GET['tgl_awal'];
    if($_GET['filter'] == "" || $_GET['data'] == ""){
      $query .= "WHERE ";
      $view = "";
      $fil = "";
      $dat = "";
    }else{
      $fil = $_GET['filter'];
      $dat = $_GET['data'];
      $query .= "WHERE ".$fil." LIKE '%$dat%' AND ";
      switch($fil){
        case "daftar.jk" : $view = "Jenis Kelamin"; break;
        case "daftar.poli" : $view = "Poliklinik"; break;
        case "daftar.jenis" : $view = "Jenis Kunjungan"; break;
        case "daftar.cara" : $view = "Cara Kunjungan"; break;
        case "daftar.kasus" : $view = "Kasus"; break;
        case "daftar.lanjut" : $view = "Tindak Lanjut"; break;
        case "daftar.bayar" : $view = "Pembayaran"; break;
        case "daftar.kel" : $view = "Alamat (Kel.)"; break;
        case "periksa.icd" : $view = "ICD-10"; break;
        case "periksa.diagnosa" : $view = "Diagnosa"; break;
        case "periksa.user" : $view = "Nama Pemeriksa"; break;
      }
    }
    $query .= "tanggal BETWEEN '$a' AND '$n' ";
    $date = date_create($a);
  ?>
  <!-- Menu Laporan -->
  <div class="btn-group float-md-end">
    <a onclick="getRetensi()" type="button" class="btn btn-outline-secondary">
      <span data-feather="archive"  class="feather-15"></span>  
      Retensi
    </a>
    <script>
      function getRetensi(){
        var bln = prompt('Masukan Jumlah Bulan :');
        window.open("rekam_lretensi.php?bln="+bln, "_blank");
      }
    </script>
  </div>
  <div class="btn-group float-md-end me-2">
    <a href="rekam_lrekap.php?filter=<?= $fil ?>&data=<?= $dat ?>&tgl=<?= $a ?>" target="_blank" type="button" class="btn btn-outline-secondary">
      <span data-feather="printer"  class="feather-15"></span>  
      Laporan
    </a>
    <a href="rekam_lbesar.php?tgl=<?= $a ?>" target="_blank" type="button" class="btn btn-outline-secondary">
      <span data-feather="printer"  class="feather-15"></span>  
      10 Besar
    </a>
  </div>
  <h5>Data Berdasarkan <?= $view . " : " . $_GET['data'] ?></h5>
  <h5><?= date_format($date, 'j M Y') . " - " . date('j M Y') ?></h5>
  <br>
  <?php 
  $query .= "GROUP BY id_pasien ORDER BY tgl DESC";
  }else{ 
      echo "<h5>Data Rekam Medis - ".date('j M Y')."</h5><br>";
      $pagi = pagination(30, $query);
      $query .= "GROUP BY id_pasien ORDER BY tgl DESC limit $pagi[4], $pagi[0]";
  } 
  ?>
  <!-- Tampilkan Data Rekam Medis -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">NRM</th>
          <th scope="col">Nama</th>
          <th scope="col">JK</th>
          <th scope="col">Umur</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Poliklinik</th>
          <th scope="col">Kasus</th>
          <th scope="col">Diagnosa</th>
          <th scope="col">Pemeriksa</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          // Data Antrian pemeriksaan - dari Tabel Daftar
          $no=1;
          $joinTable = myquery($query);
          foreach($joinTable as $tab) : 
          $id = $tab['id'];
          ?>
          <td><?= $no ?></td>
          <td><?= $tab['id_pasien'] ?></td>
          <td><?= $tab['pasien'] ?></td>
          <td><?= $tab['jk'] == "Laki-laki" ? "L" : "P" ?></td>
          <td align="center"><?php
          $lahir = date_format(date_create($tab['tgl_lahir']), 'Y');
          $umur = date('Y') - $lahir;
          echo $umur . "</td>"; 
          ?>
          <td><?= $tab['tgl'] ?></td>
          <td><?= $tab['poli'] ?></td>
          <td><?= $tab['kasus'] ?></td>
          <td><?= $tab['diagnosa'] ?></td>
          <td><?= $tab['user'] ?></td>
          <td align="right">    
            <?php if($u['bagian']=="RM" || $u['akses']=="Superuser"){ ?>  
            <!-- <a class="btn btn-sm btn-success" href="rekam_lperson.php?nrm=<?= $tab['id_pasien'] ?>" target="_blank"><span data-feather="printer"  class="feather-15"></span></a> -->
            <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#history<?= $tab['id_pasien'] ?>"><span data-feather="eye"  class="feather-15"></span></a>
            <?php } ?>
          </td>
        </tr>

        <!-- Modal Edit Data OBAT -->
        <div class="modal fade" id="history<?= $tab['id_pasien'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLiveLabel">Data Rekam Medis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-3">
                    <label class="form-label" for="id_pasien">No. RM</label>
                    <input type="text" class="form-control form-control-sm" name="id_pasien" value="<?= $tab['id_pasien']; ?>" readonly>
                  </div>
                  <div class="col-md-9">
                    <label class="form-label" for="pasien">Nama Pasien</label>
                    <input type="hidden" class="form-control form-control-sm" name="o_id">
                    <input type="text" class="form-control form-control-sm" name="pasien" value="<?= $tab['pasien']; ?>" readonly>
                  </div>
                </div>
                <br>
                <div>
                  <ol class="list-group">
                    <?php
                    $nrm = $tab['id_pasien'];
                    $rekam = myquery("SELECT daftar.tanggal, periksa.icd, periksa.diagnosa, periksa.user FROM daftar INNER JOIN periksa ON daftar.id=periksa.id_daftar WHERE daftar.id_pasien='$nrm' ORDER BY tanggal DESC");
                    foreach($rekam as $rek) :
                    ?>
                    <li class="list-group-item list-group-item-secondary"><?= $rek['tanggal'] .' - '. $rek['user'] .' - ['. $rek['icd'] .'] - '. $rek['diagnosa'] ?></li>
                    <?php 
                    endforeach; 
                    ?>
                  </ul>
                </div>
              </div>
              <div class="modal-footer">  
                <a type="button" class="btn btn-success" href="rekam_lperson.php?nrm=<?= $tab['id_pasien'] ?>" target="_blank">Rincian</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
            </div>
          </div>
        </div> 

        <?php 
        $no++;
        endforeach;
        ?>
      </tbody>
    </table>
    <?php
    if(!isset($_GET['tgl_awal'])){ 
    ?>
    <!-- Pagination -->
    <ul class="pagination d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center">
        <li class="page-item active<?php if($pagi[3]==1){ echo " disabled"; } ?>">
            <a class="page-link" style="background-color: #198754; border-color: #fff" href="?page=<?= $pagi[3] - 1; ?>" aria-label="Previous">
            <span aria-hidden="true">«</span>
            </a>
        </li>
        <li class="page-item active">
            <b class="page-link" style="background-color: #198754; border-color: #fff">
            <?= $pagi[3]; ?>
            </b>
        </li>
        <li class="page-item active">
            <a class="page-link" style="background-color: #198754; border-color: #fff" href="?page=<?= $pagi[3] + 1; ?>" aria-label="Next">
            <span aria-hidden="true">»</span>
            </a>
        </li>
    </ul>
    <?php } ?>
    <br>
    <!-- Export data ke Excel -->
    <a href="functions_exceload.php?export=rekam&filter=<?= $fil ?>&data=<?= $dat ?>&tgl=<?= $a ?>" class="btn btn-success mb-4"><span data-feather="download"  class="feather-15"></span> Export to xls</a>
  </div>
</main>