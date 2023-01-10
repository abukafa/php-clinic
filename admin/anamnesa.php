<?php 
include 'sidebar.php';
// Cek Pengguna
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Anamnesa</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
      </div>
      <!-- Filter Data Rawat Jalan -->
      <!-- <form action="" method="get">
      <select type="submit" name="tgl_awl" class="btn btn-sm btn-outline-secondary" onchange="this.form.submit()">
        <option value="">.. Filter ..</option>
        <option value="<?php echo $n ?>">Hari ini</option>
        <option value="<?php echo $w ?>">Pekan ini</option>
        <option value="<?php echo $m ?>">Bulan ini</option>
        <option value="<?php echo $y ?>">Tahun ini</option>
      </select> -->
    </div>
  </div>
  <h5>Pemeriksaan Anamnesa dan TTV</h5>
  <br>
  <!-- Tampilkam Data Rawat Jalan HARI INI sort per Jam desc -->
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">NRM</th>
          <th scope="col">Nama</th>
          <th scope="col">JK</th>
          <th scope="col">Umur</th>
          <th scope="col">Alamat</th>
          <th scope="col">Poli yang dituju</th>
          <th scope="col">Status</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php 
          $no=1;
          $now=date('Y-m-d');
          $pasien = myquery("SELECT * FROM daftar WHERE tanggal='$now' ORDER BY id");
          foreach( $pasien as $pas ) :
          $id = $pas['id'];
          ?>
          <td><?= $no; ?></td>
          <td><?= $pas['id_pasien']; ?></td>
          <td><?= $pas['pasien']; ?></td>
          <td><?= $pas['jk']; ?></td>
          <td><?= umur($pas['tgl_lahir'], "th ", "b ", "h"); ?></td>
          <td><?= $pas['alamat']; ?></td>
          <td><?= $pas['poli']; ?></td>
          <!-- Status Check jika Anamnesa sudah diisi cek id Rawat Jalan dengan ID Anamnesa -->
          <td>
          <?php 
          $cek = myNumRow("SELECT * FROM anamnesa WHERE id_daftar='$id'");
          if(!$cek){
            echo '<span data-feather="square" color="red"></span>';
          }else{
            echo '<span data-feather="check-square" color="#198754"></span>';
          }
          ?>
          </td>
          <td align="right">
            <?php if($u['bagian']=="Admin" || $u['bagian']=="Pemeriksa" || $u['akses']=="Superuser"){ ?>    
            <a class="btn btn-sm btn-secondary" href="anamnesa_edt.php<?php if(!$cek){ echo "?input=".$pas['id']; }else{ echo "?edit=".$pas['id']; } ?>"><span data-feather="edit"  class="feather-15"></span></a>
            <a class="btn btn-sm btn-success" href="rekam_lrinci.php?id=<?= $id ?>" target="_blank"><span data-feather="printer"  class="feather-15"></span></a>
            <?php } ?>
          </td>
        </tr>
        <?php 
        $no++;
        endforeach; ?>
      </tbody>
    </table>
    <!-- Selektor Tanggal -->
    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
      $(function() {
          $('#tgl').datepicker({ 
          autoclose: true,
          todayHighlight: true,
          format : 'yyyy-mm-dd' 
          });
      });
      $(function() {
          $('#lhr').datepicker({ 
          autoclose: true,
          todayHighlight: true,
          format : 'yyyy-mm-dd' 
          });
      });
    </script>
  </div>
</main>