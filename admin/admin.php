<?php 
include 'sidebar.php';
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Admin - Kasir</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
      </div>
    </div>
  </div>
  <h5>Pelayanan & Pembayaran</h5>
  <br>
  <!-- Menampilkan Query RM, Pemeriksaan & Tindakan -->
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
          <th scope="col">Tagihan</th>
          <th scope="col">Status</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <!-- Menampilkan data Diagnosa -->
          <?php 
          $no=1;
          $now=date('Y-m-d');
          $periksa = myquery("SELECT id, tanggal, daftar.id_pasien, daftar.pasien, daftar.jk, daftar.tgl_lahir, diagnosa FROM daftar INNER JOIN periksa ON daftar.id=periksa.id_daftar WHERE tanggal='$now' ORDER BY daftar.id");
          foreach($periksa as $per):
          $id = $per['id'];
          ?>
          <td><?= $no ?></td>
          <td><?= $per['id_pasien']; ?></td>
          <td><?= $per['pasien']; ?></td>
          <td><?= $per['jk']; ?></td>
          <td align="center"><?php
          $lahir = date_format(date_create($per['tgl_lahir']), 'Y');
          $umur = date('Y') - $lahir;
          echo $umur . "</td>";
          ?>
          <td><?= $per['diagnosa']; ?></td>
          <!-- Menampilkan Total Tagihan -->
          <?php 
          $tagihan = myquery("SELECT SUM(jumlah) as tag FROM tindak WHERE id_daftar='$id' AND kasir=''");
          $tag = $tagihan[0];
          $total = myquery("SELECT SUM(jumlah) as ttl FROM tindak WHERE id_daftar='$id' AND kasir<>''");
          $ttl = $total[0];
          ?>
          <td><?= number_format($tag['tag'], 0, '.', ',') ?></td>
          <!-- Status Pembayaran Check dari Query -->
          <?php 
          $cek = myNumRow("SELECT * FROM tindak WHERE id_daftar='$id' AND kasir=''");
          // var_dump($cek);
          // echo "<br>";
          // var_dump($total);
          if($cek || $ttl['ttl']==0){ 
            echo "<td><span data-feather='square' color='red'></span</td>";
          }else{ 
            echo "<td><span data-feather='check-square' color='#198754'></span</td>";
          }
          ?>
          <td align="right">    
            <?php if($u['bagian']=="Admin" || $u['akses']=="Superuser"){ ?>  
            <a class="btn btn-sm btn-secondary" href="admin_pay.php?id=<?= $id ?>"><span data-feather="edit"  class="feather-15"></span></a>
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