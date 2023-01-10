<?php 
include 'sidebar_alt.php';
$p = date('M Y');
$n = date('Y-m-d');
$w = date('Y-m-d', strtotime('-1 week'));
$m = date('Y-m-d', strtotime('-1 month'));
$s = date('Y-m-d', strtotime('-6 month'));
$y = date('Y-m-d', strtotime('-1 year'));
?>
<main>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Obat Keluar</h1>
        <?php if($u['bagian']=="Farmasi" || $u['akses']=="Superuser"){ ?>  
        <div class="btn-toolbar mb-2 mb-md-0">
            <!-- Hanya Frm & Spu yang bisa akses tombol pasien baru -->
            <div class="input-group me-2">
                <a href="farmasi.php" type="button" class="btn btn btn-outline-secondary">
                    <span data-feather="arrow-left"  class="feather-15"></span>  
                </a>
                <a data-bs-toggle="modal" data-bs-target="#inputKeluar" type="button" class="btn btn btn-outline-secondary">
                    <span data-feather="plus"  class="feather-15"></span>  
                    Tambah
                </a>
            </div>
            <!-- Filter Data Obat -->
            <form action="" method="get">
            <select type="submit" name="tgl_awal" class="form-select bg-light" onchange="this.form.submit()">
                    <option value="">.. Filter</option>
                    <option value="<?php echo $n ?>">1 Hari</option>
                    <option value="<?php echo $w ?>">1 Pekan</option>
                    <option value="<?php echo $m ?>">1 Bulan</option>
                    <option value="<?php echo $y ?>">1 Tahun</option>
            </select>
            </form>
        </div>
        <?php } ?>
    </div>
  	<?php 
	$query = "SELECT * FROM `keluar` UNION SELECT id, tanggal, id_pasien, kode, nama, jenis, tarif, qty, jumlah, note, apoteker FROM `tindak` WHERE LEFT(kode,1)='R' ";
    if(isset($_GET['tgl_awal'])){ 
        if($_GET['tgl_awal'] <> ""){ 
            $a = $_GET['tgl_awal'];
            $query = "SELECT * FROM `keluar` WHERE tanggal BETWEEN '$a' AND '$n' UNION SELECT id, tanggal, id_pasien, kode, nama, jenis, tarif, qty, jumlah, note, apoteker FROM `tindak` WHERE LEFT(kode,1)='R' AND tanggal BETWEEN '$a' AND '$n' ORDER BY tanggal DESC";
            $date = date_create($a);
            ?>
            <h5 class="mb-5" style="display: inline-block">Data Pengeluaran Obat <?= date_format($date, 'j M Y') . " - " . date('j M Y') ?></h5>
        <?php }else{ ?>
        <h5 class="mb-5" style="display: inline-block">Data Pengeluaran Obat</h5>
        <?php 
        } 
        ?>
        <!-- Menu Laporan -->
        <div class="btn-group float-md-end">
            <a href="farmasi_keluar_lrekap.php?tgl=<?= $a ?>" target="_blank" type="button" class="btn btn-outline-secondary">
            <span data-feather="printer"  class="feather-15"></span>  
            Laporan
            </a>
        </div>
    <?php 
    }else{
        $pagi = pagination(30, $query);
        $query .= "ORDER BY tanggal DESC limit $pagi[4], $pagi[0]";
    } 
    ?>

  <br>
  <!-- Tampilkan Query Data Rawat Jalan & Tindakan -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th scope="col">No. RM</th>
            <th scope="col">Kode</th>
            <th scope="col">Merk Obat</th>
            <th scope="col">Kandungan</th>
            <th scope="col">Harga</th>
            <th scope="col">Qty</th>
            <th scope="col">Total</th>
            <th scope="col">Ket</th>
            <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <?php 
            $no=1;
            $keluarUnionTindak = myquery($query);
            foreach($keluarUnionTindak as $kut):
            ?>
            <td><?= $no ?></td>
            <td><?= $kut['tanggal'] ?></td>
            <td><?= $kut['id_pasien'] ?></td>
            <td><?= $kut['id_obat'] ?></td>
            <td><?= $kut['obat'] ?></td>
            <td><?= $kut['jenis'] ?></td>
            <td><?= number_format($kut['harga'], 0, '.', ',') ?></td>
            <td><?= $kut['qty'] ?></td>
            <td><?= number_format($kut['jumlah'], 0, '.', ',') ?></td>
            <td><?= $kut['note'] ?></td>
            <!-- Cek Stok Obat dari data Obat -->
            <?php 
            // $ido = $kut['id_obat'];
            // $obat = myquery("SELECT * FROM obat WHERE id='$ido'");
            // $o = $obat[0];
            // echo "<td>". $o['stok'] ."</td>";
            ?>
            <td align="right">    
            <a onclick="if(confirm('Hapus Data dengan No ID : <?php echo $kut['id']; ?> ??')){ location.href='functions.php?del_keluar=<?php echo $kut['id']; ?>&ido=<?= $kut['id_obat']; ?>&qty=<?= $kut['qty']; ?>' }"><button id="del_keluar" class="btn btn-sm btn-danger float-md-end" <?php if($kut['id_pasien']<>"-"){echo "disabled";} ?>><span class="feather-15" data-feather="trash-2"></span></button></a>
            </td>
        </tr>
        <?php 
        $no++;
        endforeach;
        ?>
      </tbody>
    </table>
  </div>
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
          <?= $pagi[3]; ?> : <?= $pagi[2]; ?>
          </b>
      </li>
      <li class="page-item active<?php if($pagi[3]==$pagi[2]){ echo " disabled"; } ?>">
          <a class="page-link" style="background-color: #198754; border-color: #fff" href="?page=<?= $pagi[3] + 1; ?>" aria-label="Next">
          <span aria-hidden="true">»</span>
          </a>
      </li>
  </ul>
  <?php } ?>
</main>

<!-- Modal Input Data OBAT MASUK -->
<div class="modal fade" id="inputKeluar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLiveLabel">Pengeluaran Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" action="functions.php?add_keluar" method="post">
                    <div class="mb-2">
                        <label class="form-label" for="k_tgl">Tanggal</label>
                        <input type="hidden" class="form-control form-control-sm" name="k_no">
                        <input type="text" class="form-control form-control-sm" name="k_tgl" id="k_tgl" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="k_ido">Kode Obat</label>
                        <select type="text" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-width="100%" style="width: 100%" name="k_ido" id="k_ido" onchange="changeValue(this.value)">
                            <option value="">.. pilih ..</option>
                            <?php 
                            $idos = myquery("SELECT * FROM obat ORDER BY obat");
                            $jsArray = "var obat = new Array();\n";
                            foreach( $idos as $ido ) :
                                echo "<option style='white-space: normal' value='". $ido['id'] ."'>". $ido['id'] ." - ". $ido['obat'] ." - ". $ido['harga'] ." - ". $ido['stok'] ."</option>";
                                $jsArray .= "obat['". $ido['id'] ."'] = {obat:'". addslashes($ido['obat']) ."', jenis:'". addslashes($ido['jenis']) ."', harga:'". addslashes($ido['harga']) ."'};\n";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="k_obat">Merek Obat</label>
                        <input type="text" class="form-control form-control-sm" name="k_obat" id="k_obat" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="k_jenis">Kandungan</label>
                        <input type="text" class="form-control form-control-sm" name="k_jenis" id="k_jenis" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="k_harga">Harga Jual</label>
                        <input type="text" class="form-control form-control-sm" name="k_harga" id="k_harga" onkeyup="hitung()" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="k_qty">Qty</label>
                        <input type="text" class="form-control form-control-sm" name="k_qty" id="k_qty" onkeyup="hitung()">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="k_total">Total</label>
                        <input type="text" class="form-control form-control-sm" name="k_total" id="k_total" readonly>
                    </div>
                    <script type="text/javascript">
                        <?= $jsArray; ?>
                        function changeValue(k_ido){
                            document.getElementById('k_obat').value = obat[k_ido].obat;
                            document.getElementById('k_jenis').value = obat[k_ido].jenis;
                            document.getElementById('k_harga').value = obat[k_ido].harga;
                        }
                        function hitung(){
                            harga = document.getElementById('k_harga').value;
                            qty = document.getElementById('k_qty').value;
                            tot = harga*qty;
                            document.getElementById('k_total').value = tot;
                        }
                    </script>
                    <div class="mb-2">
                        <label class="form-label" for="k_note">Catatan</label>
                        <input type="text" class="form-control form-control-sm" name="k_note">
                    </div>
                    <br>
                    <div class="modal-footer">  
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

<!-- Selektor Tanggal -->
<script src="../assets/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">
<script src="../assets/js/jquery-3.3.1.slim.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/bootstrap-select.min.js"></script>
<script>
    $('.selectpicker').selectpicker();
    $(function() {
        $('#k_tgl').datepicker({ 
        autoclose: true,
        todayHighlight: true,
        format : 'yyyy-mm-dd' 
        });
    });
</script>