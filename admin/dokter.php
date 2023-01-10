<?php 
include 'sidebar.php';
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Pemeriksaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
      <h1 class="h2"><?= ($u['bagian'] == "Pemeriksa") ? $u['poli'] : '' ?></h1>
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
    <h1 class="h5">Diagnosa, Terapi, Tindakan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
      <h1 class="h5"><?= ($u['bagian'] == "Pemeriksa") ? 'Poliklinik' : '' ?></h1>
      </div>
    </div>
  </div>
  <!-- Tampilkan Data Rawat Jalan HARI INI sort per Jam desc -->
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">NRM</th>
          <th scope="col">Nama</th>
          <th scope="col">JK</th>
          <th scope="col">Umur</th>
          <th scope="col">Poli yang dituju</th>
          <th scope="col">Keluhan Utama</th>
          <!-- <th scope="col">Diagnosa</th> -->
          <th scope="col">Status</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          // Data Antrian pemeriksaan - dari Tabel Daftar
          $now=date('Y-m-d');
          if($u['bagian'] == "Pemeriksa"){
            $poliDok = $u['poli'];
            $query = "SELECT * FROM daftar WHERE poli='$poliDok' AND tanggal='$now' ORDER BY id";
          }else{
            $query = "SELECT * FROM daftar WHERE tanggal='$now' ORDER BY id";
          }
          $no=1;
          $daftar = myquery($query);
          foreach($daftar as $daf) : ?>
          <td><?= $no; ?></td>
          <td><?= $daf['id_pasien']; ?></td>  
          <td><?= $daf['pasien']; ?></td>
          <td><?= $daf['jk']; ?></td>
          <td><?= umur($daf['tgl_lahir'], "th ", "b ", "h"); ?></td>
          <td><?= $daf['poli']; ?></td>
          <?php
          $id = $daf['id'];
          // Data Keluhan utama - diambil dari Tabel Anamnesa
          $cek = $anamnesa = myquery("SELECT * FROM anamnesa WHERE id_daftar='$id'");
          if($cek){ 
            $ana = $anamnesa[0];
            echo "<td>" . $ana['keluhan'] . "</td>";
          }else{ 
            echo "<td></td>";
          }
          // Data diagnosa & Cheklis Pemeriksaan - dari Tabel Periksa
          $cek = myquery("SELECT * FROM periksa WHERE id_daftar='$id'");
          if($cek){ 
            $per = $cek[0];
            // echo "<td>" . $per['diagnosa'] . "</td>";
            echo "<td><span data-feather='check-square' color='#198754'></span</td>";
          }else{ 
            // echo "<td></td>";
            echo "<td><span data-feather='square' color='red'></span</td>";
          }
          ?>
          <td align="right">    
            <?php if($u['bagian']=="Pemeriksa" || $u['akses']=="Superuser"){ ?>  
            <a class="btn btn-sm btn-secondary" href="dokter_edit.php<?php if(!$cek){ echo "?input=".$id; }else{ echo "?edit=".$id; } ?>"><span data-feather="edit"  class="feather-15"></span></a>
            <a class="btn btn-sm btn-success" href="rekam_lrinci.php?id=<?= $daf['id'] ?>" target="_blank"><span data-feather="printer"  class="feather-15"></span></a>
            <?php } ?>
          </td>
        </tr>
        <?php 
        $no++;
        endforeach; ?>
      </tbody>
    </table>
  </div>
</main>