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
        <h1 class="h2"><a href="farmasi_stok.php" style="color:#198754">Stok Opname</a></h1>
        <?php if($u['bagian']=="Farmasi" || $u['akses']=="Superuser"){ ?>  
        <div class="btn-toolbar mb-2 mb-md-0">
            <!-- Hanya Frm & Spu yang bisa akses tombol pasien baru -->
            <div class="btn-group me-2">
            <a href="farmasi.php"><button type="button" class="btn btn btn-outline-secondary">
                <span data-feather="arrow-left"  class="feather-15"></span>  
            </button></a>
            </div>
            <div class="btn-group me-2">
            <a onclick="if(confirm('KOSONGKAN data STOK OPNAME ??')){ location.href='functions.php?empty_so' }"><button type="button" class="btn btn btn-outline-secondary">
                <span data-feather="trash-2"  class="feather-15"></span>  
            </button></a>
            </div>
            <div class="btn-group me-2">
            <a onclick="if(confirm('RESET data STOK OPNAME menjadi 0 ??')){ location.href='functions.php?reset_so' }"><button type="button" class="btn btn btn-outline-secondary">
                <span data-feather="refresh-cw"  class="feather-15"></span>  
                Reset
            </button></a>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php
    if(isset($_GET['importOk'])){
      $qty = $_GET['importOk'];
      echo "<div class='alert alert-success alert-dismissible' role='alert'>". $qty ." Data di-Upload.. Silahkan cek kembali !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } ?>
    <!-- FORM filter Pencarian -->
    <form action="" method="post">
        <div class="input-group col-12 col-lg-4 mb-3">
                <span class="input-group-text"><span data-feather="search"></span></span>
                <input type="text" class="form-control" name="cari" id="cari" placeholder="Pencarian" autocomplete="off" onchange>
        </div>
    </form>
  <br>
  <!-- Tampilkan Query Data STOK OPNAME -->
  <div class="table-responsive" id="response">
    <table id="data_table" class="table table-striped table-sm">
      <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Merek Obat</th>
            <th class="text-end col-1">SO</th>
            <th class="text-end col-1">TM</th>
            <th class="text-end col-1">TK</th>
            <th class="text-end col-1">R.Dr</th>
            <th class="text-end col-1">Sisa</th>
            <th class="text-end col-1">Data</th>
            <th class="text-end col-1">Selisih</th>
        </tr>
      </thead>
      <tbody>
        <tr id="<?= $id; ?>">
            <?php 
            $no=1;
            $pagi = pagination(50, "select * from opname");
            if(isset($_POST['cari'])){
              $cari=$_POST['cari'];
              $stokOpname = myquery("SELECT * FROM opname WHERE obat LIKE '%$cari%' OR jenis LIKE '%$cari%' OR id LIKE '%$cari%' ORDER BY jenis, obat");
            }else{
              $stokOpname = myquery("SELECT * FROM opname ORDER BY jenis, obat limit $pagi[4], $pagi[0]");
            }
            foreach ($stokOpname as $so) :
            $id = $so['id'];
            ?>
            <td><?= $no; ?></td>
            <td><?= $id; ?></td>
            <td><?= $so['obat']; ?></td>
            <td class="text-end"><?= $so['so']; ?></td>
            <?php 
            $masuk = myquery("SELECT SUM(IF(id_obat='$id', qty, 0)) as msk FROM masuk");
            $m = $masuk[0];
            $keluar = myquery("SELECT SUM(IF(id_obat='$id', qty, 0)) as klr FROM keluar");
            $k = $keluar[0];
            $tindak = myquery("SELECT SUM(IF(kode='$id', qty, 0)) as tdk FROM tindak");
            $t = $tindak[0];
            $sisa = $m['msk'] - $k['klr'] - $t['tdk'];
            ?>
            <td class="text-end"><?= $m['msk']; ?></td>
            <td class="text-end"><?= $k['klr']; ?></td>
            <td class="text-end"><?= $t['tdk']; ?></td>
            <th class="text-end"><?= $sisa; ?></th>
            <?php
            $obat = myquery("SELECT SUM(IF(id='$id', stok, 0)) as stok FROM obat");
            $o = $obat[0];
            $selisih = $so['so'] - (($sisa + $o['stok'])/2);
            ?>
            <td class="text-end"><?= $o['stok']; ?></td>
            <th class="text-end" <?= $selisih <> 0 ? "style='color:red'" : "" ?>><?= $selisih; ?></th>
        </tr>
        <?php 
        $no++;
        endforeach; 
        ?>
    </table>
  </div>
  <!-- Pagination -->
  <ul class="pagination d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center">
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
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <!-- Export data ke Excel -->
    <a href="functions_exceload.php?export=so" class="btn btn-success"><span data-feather="download"  class="feather-15"></span> Export to xls</a>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!-- Import from Excel -->
      <form method="post" enctype="multipart/form-data" action="functions_exceload.php?import=so">
        <div class="input-group">
          <div class="input-group-text p-0">
          <input type="file" name="import_so" class="form-control col-md-3 d-flex" required> 
          </div>
          <input name="import" type="submit" class="btn btn-success" value="Import">
        </div>
      </form>
    </div>
  </div>
</main>

<script src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery.tabledit.js"></script>
<script>
	$(document).ready(function(){
		$('#data_table').Tabledit({
			deleteButton: false,
			editButton: false,   		
			columns: {
			identifier: [1, 'id'],                    
			editable: [[3, 'so']]
			},
			hideIdentifier: false,
			url: 'ajax/live_edit.php'		
		});
	});
  // var td = document.getElementById('opname');
  // var val = td.text();
  //   td.addEventListener('blur', function(){
  //   window.open("functions.php?stok_opname="+val, "_self");
  // })
  // ajax cek kasus lama atau baru
  var cari = document.getElementById('cari');
  var tabel = document.getElementById('response');
  cari.addEventListener('keyup', function(){
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function(){
          if( xhr.readyState == 4 && xhr.status == 200 ){
              tabel.innerHTML = xhr.responseText;
          }
      }
      xhr.open('GET', 'ajax/cari_so.php?cari=' + cari.value, true);
      xhr.send();
  });
</script>