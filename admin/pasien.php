<?php 
include 'sidebar.php';
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Rawat Jalan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <!-- Hanya RM & Spu yang bisa akses tombol pasien baru -->
      <?php if($u['bagian']=="RM" || $u['bagian']=="Pendaftaran" || $u['akses']=="Superuser"){ ?>
      <div class="btn-group me-2">
        <a href="pasien_old.php" type="button" class="btn btn btn-outline-secondary">
          <span data-feather="user-check"  class="feather-17"></span>  
          Pasien Lama
        </a>
        <a href="pasien_new.php" type="button" class="btn btn btn-outline-secondary">
          <span data-feather="user-plus"  class="feather-17"></span>  
          Pasien Baru
        </a>
      </div>
      <!-- <div class="btn-group me-2">
        <a href="pasien_view.php"><button type="button" class="btn btn-sm btn-outline-secondary">
          <span data-feather="folder"  class="feather-15"></span>  
          Data Pasien
        </button></a>
      </div> -->
      <?php } ?>
    </div>
  </div>
  <!-- Tampilkam Data Rawat Jalan HARI INI sort per Jam desc -->
  <h5> <?= indo_date(date('Y-m-d'), ('l, j F Y'), '') ?> </h5>
  <br>
  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Tanggal</th>
          <th scope="col">NRM</th>
          <th scope="col">Nama</th>
          <th scope="col">JK</th>
          <th scope="col">Umur</th>
          <th scope="col">Alamat</th>
          <th scope="col">Kunjungan</th>
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
          <td><?= $pas['tanggal']; ?></td>
          <td><?= $pas['id_pasien']; ?></td>
          <td><?= $pas['pasien']; ?></td>
          <td><?= $pas['jk']; ?></td>
          <td align="center"><?php
          $lahir = date_format(date_create($pas['tgl_lahir']), 'Y');
          $umur = date('Y') - $lahir;
          echo $umur . "</td>";
          ?>
          <td><?= $pas['alamat']; ?></td>
          <td><?= $pas['jenis']; ?></td>
          <td align="right">    
          <?php if($u['bagian']=="RM" || $u['bagian']=="Pendaftaran" || $u['akses']=="Superuser"){ ?>
            <a class="btn btn-sm btn-secondary"><span data-feather="edit"  class="feather-15" data-bs-toggle="modal" data-bs-target="#edit<?= $id; ?>"></span></a>
            <a class="btn btn-sm btn-success" href="rekam_lrinci.php?id=<?= $id ?>" target="_blank"><span data-feather="printer"  class="feather-15"></span></a>
            <a onclick="if(confirm('Hapus Data dengan No. RM : <?= $pas['id_pasien']; ?> ??')){ location.href='functions.php?del_daftar=<?= $id; ?>' }" class="btn btn-sm btn-danger"><span data-feather="trash-2"  class="feather-15"></span></a>
            <?php } ?>  
          </td>
          <!-- Modal Edit Data Rawat Jalan -->
          <div class="modal fade" id="edit<?= $id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLiveLabel">Edit Data Rawat Jalan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form role="form" action="functions.php?edt_daftar=<?= $id; ?>" method="post">
                    <?php 
                    $daftar = myquery("SELECT * FROM daftar WHERE id='$id'");
                    foreach( $daftar as $daf ) :
                    ?>
                    <div class="mb-2">
                      <label class="form-label" for="nrm">No. RM</label>
                      <input type="hidden" class="form-control form-control-sm" name="id" value="<?= $daf['id']; ?>" readonly>
                      <input type="text" class="form-control form-control-sm" name="nrm" value="<?= $daf['id_pasien']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="tgl">Tanggal</label>
                      <input type="text" class="form-control form-control-sm" name="tgl" id="tgl" value="<?= $daf['tanggal']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="nama">Nama Pasien</label>
                      <input type="text" class="form-control form-control-sm" name="nama" value="<?= $daf['pasien']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="lahir">Tanggal Lahir</label>
                      <input type="text" class="form-control form-control-sm" name="lahir" id="lahir" value="<?= $daf['tgl_lahir']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="jk">Jenis Kelamin</label>
                      <input type="text" class="form-control form-control-sm" name="jk" value="<?= $daf['jk']; ?>" readonly>
                      <!-- <select type="text" class="form-select form-select-sm" name="jk">
                        <option></option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                      </select> -->
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="alamat">Alamat</label>
                      <input type="text" class="form-control form-control-sm" name="alamat" value="<?= $daf['alamat']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="kel">Kelurahan</label>
                      <input type="text" class="form-control form-control-sm" name="kel" value="<?= $daf['kel']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="kec">Kecamatan</label>
                      <input type="text" class="form-control form-control-sm" name="kec" value="<?= $daf['kec']; ?>" readonly>
                    </div>
                    <div class="mb-2">
                      <label class="form-label" for="kota">Kota</label>
                      <input type="text" class="form-control form-control-sm" name="kota" value="<?= $daf['kota']; ?>" readonly>
                    </div>
                    <!-- Disembunykan tidak dipakai -->
                    <div class="mb-2" hidden>
                      <label class="form-label" for="keluh">Keluhan</label>
                      <input type="text" class="form-control form-control-sm" name="keluh" value="<?= $daf['keluhan']; ?>">
                    </div>
                    <div class="mb-2" hidden>
                      <label class="form-label" for="poli">Poli yang dituju</label>
                      <select type="text" class="form-control form-control-sm" name="poli">
                          <option value="<?= $daf['poli']; ?>"><?= $daf['poli']; ?></option>
                          <option>Umum</option>
                          <option>KIA</option>
                          <option>Hypnotherapy</option>
                      </select>
                    </div>
                    <!-- -------------------------- -->
                    <div class="mb-2">
                        <label for="jenis" class="form-label">Jenis Kunjungan</label>
                        <select type="text" class="form-control form-control-sm" name="jenis">
                            <option value="<?= $daf['jenis']; ?>"><?= $daf['jenis']; ?></option>
                            <option>Baru</option>
                            <option>Lama</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="kasus" class="form-label">Jenis Kasus</label>
                        <select type="text" class="form-control form-control-sm" name="kasus">
                            <option value="<?= $daf['kasus']; ?>"><?= $daf['kasus']; ?></option>
                            <option>Baru</option>
                            <option>Lama</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="cara" class="form-label">Cara Kunjungan</label>
                        <select type="text" class="form-control form-control-sm" name="cara">
                            <option value="<?= $daf['cara']; ?>"><?= $daf['cara']; ?></option>
                            <option>Datang Sendiri</option>
                            <option>Rujukan Dokter lain</option>
                            <option>Rujukan Bidan lain</option>
                            <option>lainnya</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="lanjut" class="form-label">Tindak Lanjut Pelayanan</label>
                        <select type="text" class="form-control form-control-sm" name="lanjut">
                            <option value="<?= $daf['lanjut']; ?>"><?= $daf['lanjut']; ?></option>
                            <option>Dirawat</option>
                            <option>Dirujuk</option>
                            <option>Pulang</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="bayar" class="form-label">Jenis Pembayaran</label>
                        <select type="text" class="form-control form-control-sm" name="bayar">
                            <option value="<?= $daf['bayar']; ?>"><?= $daf['bayar']; ?></option>
                            <option>Umum</option>
                            <option>Gratis</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="note" class="form-label">Catatan</label>
                        <input type="text" class="form-control form-control-sm" name="note" value="<?= $daf['note']; ?>">
                    </div>
                    <div class="mb-2">
                        <label for="user" class="form-label">User</label>
                        <input type="text" class="form-control form-control-sm" name="user" value="<?= $daf['user']; ?>" readonly>
                    </div>
                    <br>
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
</main>

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
</script>
