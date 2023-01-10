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
    <h1 class="h2"><a href="pasien_view.php" style="color:#198754">Data Pasien</a></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <a href="pasien_old.php"><button type="button" class="btn btn-outline-secondary">
          <span data-feather="arrow-left"  class="feather-15"></span>  
        </button></a>
      </div>
      <!-- Filter Data Rawat Jalan -->
      <div class="btn-group me-2">
        <form action="" method="get">
          <select type="submit" name="tgl_awal" class="btn btn-outline-secondary" onchange="this.form.submit()">
            <option value="">.. Filter ..</option>
            <option value="<?php echo $n ?>">1 Hari</option>
            <option value="<?php echo $w ?>">1 Pekan</option>
            <option value="<?php echo $m ?>">1 Bulan</option>
            <option value="<?php echo $y ?>">1 Tahun</option>
          </select>
        </form>
      </div>
      <!-- Cek filter Data -->
      <?php  
      $query = "SELECT * FROM pasien ";
      $jumPas = "Total Seluruh Data : " . myNumRow($query);
      if(isset($_GET['tgl_awal'])){
        $a = $_GET['tgl_awal'];
        if($a <> ""){
          $query .= "WHERE tgl_reg BETWEEN '$a' AND '$n' ORDER BY tgl_reg DESC";
          $date = date_create($a);
          $link = "pasien_lrekap.php?tgl_awal=". $a ."&tgl_ahir=". $n;
          $tanggal = date_format($date, 'j M Y') . " - " . date('j M Y');
          $jumPas = "Terdapat " . myNumRow($query);
    }else{
          $link = "pasien_lrekap.php";
          $tanggal = date('j M Y');
        }
      }else{
        $link = "pasien_lrekap.php";
        $tanggal = date('j M Y');
        $pagi = pagination(30, $query);
        $query .= "ORDER BY tgl_reg DESC limit $pagi[4], $pagi[0]";
      }
      ?>
      <!-- Tabel Rekap Pasien -->
      <div class="btn-group me-2">
        <a href="<?= $link ?>" target="_blank"><button type="button" class="btn btn-outline-secondary">
          <span data-feather="printer"  class="feather-13"></span>  
          Cetak
        </button></a>
      </div>
    </div>
  </div>
  <h5><?= $jumPas; ?> Pasien</h5>
  <br>
  <!-- FORM filter Pencarian -->
  <form action="" method="post">
      <div class="input-group col-12 col-lg-4 mb-3">
        <span class="input-group-text"><span data-feather="search"></span></span>
        <input type="text" class="form-control" name="cari" id="cari" placeholder="Pencarian" autocomplete="off" onchange>
      </div>
  </form>
  <?php
  if(isset($_POST['cari'])){
    $cari = $_POST['cari'];
    $query = "SELECT * FROM pasien WHERE 
                id LIKE '%$cari%' 
                OR nama LIKE '%$cari%' 
                ORDER BY nama";
  }      
  ?>
  <!-- Tampilkam Data Rawat Jalan HARI INI sort per Jam desc -->
  <div class="table-responsive" id="data_table">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">NRM</th>
          <th class="col-1">Registrasi</th>
          <th scope="col">Nama</th>
          <th scope="col">JK</th>
          <th scope="col">Umur</th>
          <th scope="col">Alamat</th>
          <th scope="col">Penanggung</th>
          <th scope="col">Telephone</th>
          <th class="col-1"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          $no=1;
          $pasien = myquery($query);
          foreach( $pasien as $pas ) :
          $id = $pas['id'];
          ?>
          <td><?= $no; ?></td>
          <td><?= $id; ?></td>
          <td><?= $pas['tgl_reg']; ?></td>
          <td><?= $pas['nama']; ?></td>
          <td><?= $pas['jk']; ?></td>
          <td align="center"><?php
          $lahir = date_format(date_create($pas['tgl_lahir']), 'Y');
          $umur = date('Y') - $lahir;
          echo $umur;
          ?></td>
          <td><?= $pas['alamat']; ?></td>
          <td><?= $pas['nama_pj']; ?></td>
          <td><?= $pas['telepon']; ?></td>
          <td align="right">    
            <?php if($u['bagian']=="RM" || $u['akses']=="Superuser"){ ?>  
            <a class="btn btn-sm btn-secondary"><span data-feather="edit"  class="feather-15" data-bs-toggle="modal" data-bs-target="#edit<?= $id; ?>"></span></a>
            <a onclick="if(confirm('Hapus Data dengan No. RM : <?= $id; ?> ??')){ location.href='functions.php?del_pasien=<?= $id; ?>' }" class="btn btn-sm btn-danger"><span data-feather="trash-2"  class="feather-15"></span></a>
            <?php } ?>  
          </td>
          <!-- Modal Edit Data Rawat Jalan -->
          <div class="modal fade" id="edit<?= $id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLiveLabel">Edit Data Pasien</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form role="form" action="functions.php?edt_pasien=<?= $id; ?>" method="post">
                    <?php 
                    $pasien = myquery("SELECT * FROM pasien WHERE id='$id'");
                    foreach( $pasien as $pa ) :
                    ?>
                    <div class="mb-2">
                      <label class="form-label" for="id">No. RM</label>
                      <input type="text" class="form-control form-control-sm" name="id" id="id" value="<?= $pa['id']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="tgl_reg">Tanggal Registrasi</label>
                      <input type="text" class="form-control form-control-sm" name="tgl_reg" id="tgl_reg" value="<?= $pa['tgl_reg']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="noid">No. Identitas</label>
                      <input type="text" class="form-control form-control-sm" name="noid" value="<?= $pa['noid']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="nama">Nama Pasien</label>
                      <input type="text" class="form-control form-control-sm" name="nama" value="<?= $pa['nama']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                      <input type="text" class="form-control form-control-sm" name="tgl_lahir" id="tgl_lahir" value="<?= $pa['tgl_lahir']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="jk">Jenis Kelamin</label>
                      <select type="text" class="form-select form-select-sm" name="jk">
                        <option value="<?= $pa['jk']; ?>"><?= $pa['jk']; ?></option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                      </select>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="alamat">Alamat</label>
                      <input type="text" class="form-control form-control-sm" name="alamat" value="<?= $pa['alamat']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="kel">Desa/ Kelurahan</label>
                      <input type="text" class="form-control form-control-sm" name="kel" value="<?= $pa['kel']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="kec">Kecamatan</label>
                      <input type="text" class="form-control form-control-sm" name="kec" value="<?= $pa['kec']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="kota">Kota/ Kabupaten</label>
                      <input type="text" class="form-control form-control-sm" name="kota" value="<?= $pa['kota']; ?>">
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="status">Status</label>
                      <select type="text" class="form-select form-select-sm" name="status">
                        <option value="<?= $pa['status']; ?>"><?= $pa['status']; ?></option>
                        <option>Menikah</option>
                        <option>Lajang</option>
                        <option>Janda</option>
                        <option>Duda</option>
                      </select>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="pj">Penanggung jawab</label>
                      <select type="text" class="form-select form-select-sm" name="pj">
                          <option value="<?= $pa['pj']; ?>"><?= $pa['pj']; ?></option>
                          <option>Ayah</option>
                          <option>Ibu</option>
                          <option>Suami</option>
                          <option>Istri</option>
                          <option>Lainnya</option>
                      </select>
                    </div>
                    <div class="mb-2">
                        <label for="nama_pj" class="form-label">Nama Penanggung jawab</label>
                        <input type="text" class="form-control form-control-sm" name="nama_pj" value="<?= $pa['nama_pj']; ?>">
                    </div>
                    <div class="mb-2">
                        <label for="telepon" class="form-label">Telephone</label>
                        <input type="text" class="form-control form-control-sm" name="telepon" value="<?= $pa['telepon']; ?>">
                    </div>
                    <div class="mb-2">
                        <label for="note" class="form-label">Catatan</label>
                        <input type="text" class="form-control form-control-sm" name="note" value="<?= $pa['note']; ?>">
                    </div>
                    <div class="mb-2">
                        <label for="user" class="form-label">User</label>
                        <input type="text" class="form-control form-control-sm" name="user" value="<?= $pa['user']; ?>" readonly>
                    </div>
                    <br>
                    <!-- Selektor Tanggal -->
                    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
                    <script>
                    $(function() {
                          $('#tgl_reg').datepicker({ 
                          autoclose: true,
                          todayHighlight: true,
                          format : 'yyyy-mm-dd' 
                          });
                    });
                    $(function() {
                          $('#tgl_lahir').datepicker({ 
                          autoclose: true,
                          todayHighlight: true,
                          format : 'yyyy-mm-dd' 
                          });
                    });
                    </script>
                    <div class="modal-footer">  
                      <button type="submit" class="btn btn-success">Rubah</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                    <?php endforeach; ?>
                  </form>
                </div>
              </div>
            </div>
          </div> 
        </tr>
        <?php 
        $no++;
        endforeach; ?>
      </tbody>
    </table>
  </div>
  <!-- Pagination -->
  <?php
  if(!isset($_POST['cari']) && !isset($_GET['tgl_awal'])){
  ?>
  <ul id="pagination" class="pagination d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center">
      <li class="page-item active<?php if($pagi[3]==1){ echo " disabled"; } ?>">
          <a class="page-link" style="background-color: #198754; border-color: #fff" href="?page=<?= $pagi[3] - 1; ?>" aria-label="Previous">
          <span aria-hidden="true">«</span>
          </a>
      </li>
      <li class="page-item active">
          <b class="page-link" style="background-color: #198754; border-color: #fff">
          <?= $pagi[3]; ?> : <?= $pagi[2]; ?>
          </b>
      </li>
      <li class="page-item active<?php if($pagi[3]==$pagi[2]){ echo " disabled"; } ?>">
          <a class="page-link" style="background-color: #198754; border-color: #fff" href="?page=<?= $pagi[3] + 1; ?>" aria-label="Next">
          <span aria-hidden="true">»</span>
          </a>
      </li>
  </ul>
  <!-- <br> -->
  <div id="exceload" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <!-- Export data ke Excel -->
    <a href="functions_exceload.php?export=pasien" class="btn btn-success"><span data-feather="download"  class="feather-15"></span> Export to xls</a>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!-- Import from Excel -->
      <form method="post" enctype="multipart/form-data" action="functions_exceload.php?import=pasien">
        <div class="input-group">
          <div class="input-group-text p-0">
          <input type="file" name="import_pasien" class="form-control col-md-3 d-flex" required> 
          </div>
          <input name="import" type="submit" class="btn btn-success" value="Import">
        </div>
      </form>
    </div>
  </div>
  <?php
  }
  ?>
</main>

<script type="text/javascript">
  // ajax cari pasien
  // var cari = document.getElementById('cari');
  // var tabel = document.getElementById('data_table');
  // cari.addEventListener('keyup', function(){
  //     var xhr = new XMLHttpRequest();
  //     xhr.onreadystatechange = function(){
  //         if( xhr.readyState == 4 && xhr.status == 200 ){
  //             tabel.innerHTML = xhr.responseText;
  //         }
  //     }
  //     xhr.open('GET', 'ajax/cari_pasien.php?cari=' + cari.value, true);
  //     xhr.send();
  // });
</script>