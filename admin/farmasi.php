<?php 
include 'sidebar.php';
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Farmasi</h1>
    <?php if($u['bagian']=="Farmasi" || $u['akses']=="Superuser"){ ?>  
    <div class="btn-toolbar mb-2 mb-md-0">
      <!-- Hanya RM & Spu yang bisa akses tombol pasien baru -->
      <div class="btn-group me-2">
        <a href="farmasi_masuk.php" type="button" class="btn btn btn-outline-secondary">
          <span data-feather="folder-plus"  class="feather-17"></span>  
          Masuk
        </a>
        <a href="farmasi_keluar.php" type="button" class="btn btn btn-outline-secondary">
          <span data-feather="folder-minus"  class="feather-17"></span>  
          Keluar
        </a>
      </div>
      <div class="btn-group me-2">
        <a href="farmasi_stok.php"><button type="button" class="btn btn btn-outline-secondary">
          <span data-feather="archive"  class="feather-17"></span>  
          Stok Opname
          </button></a>
      </div>
    </div>
    <?php } ?>
  </div>

  <h5>Pengambilan Obat</h5>
  <br>
  <!-- Tampilkan Query Data Rawat Jalan & Tindakan -->
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">NRM</th>
          <th scope="col">Nama</th>
          <th scope="col">JK</th>
          <th scope="col">Umur</th>
          <th scope="col">Diagnosa</th>
          <th scope="col">Obat</th>
          <th scope="col">Status</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          $no=1;
          $now=date('Y-m-d');
          $periksa = myquery("SELECT id, tanggal, daftar.id_pasien, daftar.pasien, daftar.jk, daftar.tgl_lahir, diagnosa FROM daftar INNER JOIN periksa ON daftar.id=periksa.id_daftar WHERE tanggal='$now' ORDER BY daftar.id");
          foreach($periksa as $per) :
          $id = $per['id'];
          ?>
          <td><?= $no; ?></td>
          <td><?= $per['id_pasien']; ?></td>
          <td><?= $per['pasien']; ?></td>
          <td><?= $per['jk']; ?></td>
          <td align="center"><?php
          $lahir = date_format(date_create($per['tgl_lahir']), 'Y');
          $umur = date('Y') - $lahir;
          echo $umur . "</td>";
          ?>
          <td><?= $per['diagnosa'] ?></td>
          <!-- Jumlah Obat Resep -->
          <?php 
          $num = myNumRow("SELECT * FROM tindak WHERE id_daftar='$id' AND LEFT(kode,1)='R'");
          ?>
          <td><?= $num ?></td>
          <!-- Ceklis Pengambilan Obat -->
          <?php 
          $cek = myquery("SELECT * FROM tindak WHERE id_daftar='$id' AND LEFT(kode,1)='R' AND apoteker=''");
          // var_dump($cek);
          if(!$num || $cek){ 
            echo "<td><span data-feather='square' color='red'></span</td>";
          }else{ 
            echo "<td><span data-feather='check-square' color='#198754'></span</td>";
          }
          ?>
          <td align="right">    
            <?php if($u['bagian']=="Farmasi" || $u['akses']=="Superuser"){ ?>  
            <a class="btn btn-sm btn-secondary" href="farmasi_edit.php?id=<?= $id ?>"><span data-feather="edit"  class="feather-15"></span></a>
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