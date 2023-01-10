<?php 
include 'sidebar.php';
?>
<!-- Menu Utama -->
<main>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Database</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            </div>
        </div>
    </div>
    <?php
    if(isset($_GET['importObatOk'])){
      $qty = $_GET['importObatOk'];
      echo "<div class='alert alert-success alert-dismissible' role='alert'>". $qty ." Data OBAT di-Upload.. Silahkan cek kembali !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } 
    if(isset($_GET['importBiayaOk'])){
      $qty = $_GET['importBiayaOk'];
      echo "<div class='alert alert-success alert-dismissible' role='alert'>". $qty ." Data BIAYA di-Upload.. Silahkan cek kembali !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } 
    if(isset($_GET['importIcdOk'])){
      $qty = $_GET['importIcdOk'];
      echo "<div class='alert alert-success alert-dismissible' role='alert'>". $qty ." Data ICD-10 di-Upload.. Silahkan cek kembali !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } 
    ?>
    <div class="row row-cols-1 row-md-2 g-4">
        <!-- data card ICD-10 -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <h6 class="card-header" style="background-color: #6c757d"><div style="color: #ffffff">Data ICD-10</div></h6>
                <div class="card-body" style="background-color: #95DAC1">
                    <?php $totalIcd = count(myquery("select * from icd10")); ?>
                    <h1 class="card-title display-1 float-md-end" style="color: #6c757d"><?= $totalIcd; ?></h1>
                    <br><br><br>
                    <a href="?table=diagnosa" class="btn btn-sm btn-secondary"><span data-feather="eye"  class="feather-15"></span></a>
                    <?php if(isset($_GET['table'])){ if($_GET['table'] == "diagnosa"){ ?>
                    <a class="btn btn-sm btn-secondary"><span data-feather="plus"  class="feather-15" data-bs-toggle="modal" data-bs-target="#inputDiag"></span></a>
                    <?php } } ?>
                </div>
                <em class="card-footer figure-caption" style="background-color: #6c757d"><div style="color: #ffffff">Database Diagnosa</div></em>
            </div>
        </div>
        <!-- data card Jasa Pemeriksaan & Tindakan -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <h6 class="card-header" style="background-color: #6c757d"><div style="color: #ffffff">Data Biaya</h6>
                <div class="card-body" style="background-color: #FFEBA1">
                    <?php $totalBiaya = count(myquery("select * from biaya")); ?>
                    <h1 class="card-title display-1 float-md-end" style="color: #6c757d"><?= $totalBiaya; ?></h1>
                    <br><br><br>
                    <a href="?table=tindakan" class="btn btn-sm btn-secondary"><span data-feather="eye"  class="feather-15"></span></a>
                    <?php if(isset($_GET['table'])){ if($_GET['table'] == "tindakan"){ ?>
                    <a class="btn btn-sm btn-secondary"><span data-feather="plus"  class="feather-15" data-bs-toggle="modal" data-bs-target="#inputJasa"></span></a>
                    <?php } } ?>
                </div>
                <em class="card-footer figure-caption" style="background-color: #6c757d"><div style="color: #ffffff">Database Pemeriksaan & Tindakan</div></em>
            </div>
        </div>
        <!-- data card Farmasi -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <h6 class="card-header" style="background-color: #6c757d"><div style="color: #ffffff">Data Obat</h6>
                <div class="card-body" style="background-color: #FD6F96">
                    <?php $totalObat = count(myquery("select * from obat")); ?>
                    <h1 class="card-title display-1 float-md-end" style="color: #6c757d"><?= $totalObat; ?></h1>
                    <br><br><br>
                    <a href="?table=obat" class="btn btn-sm btn-secondary"><span data-feather="eye"  class="feather-15"></span></a>
                    <?php if(isset($_GET['table'])){ if($_GET['table'] == "obat" || $_GET['table'] == "obatmasuk"){ ?>
                    <a class="btn btn-sm btn-secondary"><span data-feather="plus"  class="feather-15" data-bs-toggle="modal" data-bs-target="#inputObat"></span></a>
                    <?php } } ?>
                </div>
                <em class="card-footer figure-caption" style="background-color: #6c757d"><div style="color: #ffffff">Database Farmasi</div></em>
            </div>
        </div>
    </div>
    <br>
    <?php 
    // <!-- QUERY berdasarkan pilihan view Data Card -->
    if(isset($_GET['table'])){
        if($_GET['table'] == "diagnosa"){
            echo "<h1 class='display-6 mb-3'>Database ICD-10</h1>";
            $table = "diagnosa";
            $label = ["Code", "Description", "Category", "Chapter", "Group"];
            $pagi = pagination(30, "select * from icd10");
            $rows = myquery("select * from icd10 limit $pagi[4], $pagi[0]");
            if(isset($_POST['cari'])){
                $cari = $_POST['cari'];
                $queCari = "SELECT * FROM icd10 WHERE code LIKE '%$cari%' OR description LIKE '%$cari%'";
                $rows = cari($queCari, $_POST['cari']);
            }
        }elseif($_GET['table'] == "tindakan"){
            echo "<h1 class='display-6 mb-3'>Jasa Pemeriksaan dan Tindakan</h1>";
            $table = "tindakan";
            $label = ["Kode", "Nama Tindakan", "Jenis", "Keterangan", "Tarif"];
            $pagi = pagination(30, "select * from biaya");
            $rows = myquery("select * from biaya order by jenis limit $pagi[4], $pagi[0]");
            if(isset($_POST['cari'])){
                $cari = $_POST['cari'];
                $queCari = "SELECT * FROM biaya WHERE biaya LIKE '%$cari%' OR jenis LIKE '%$cari%'";
                $rows = cari($queCari, $_POST['cari']);
            }
        }elseif($_GET['table'] == "obat"){
            echo "<h1 class='display-6 mb-3'>Database Obat</h1>";
            $table = "obat";
            $label = ["Kode", "Merek Obat", "Kandungan", "Stok", "Harga"];
            $pagi = pagination(30, "select * from obat");
            $rows = myquery("select * from obat order by jenis limit $pagi[4], $pagi[0]");
            if(isset($_POST['cari'])){
                $cari = $_POST['cari'];
                $queCari = "SELECT * FROM obat WHERE obat LIKE '%$cari%' OR jenis LIKE '%$cari%'";
                $rows = cari($queCari, $_POST['cari']);
            }
        }
    }
    ?>
    <?php if(isset($_GET['table'])) { ?>
    <!-- FORM filter Pencarian -->
    <form action="" method="post">
        <div class="input-group col-12 col-lg-4 mb-3">
                <span class="input-group-text"><span data-feather="search"></span></span>
                <input type="text" class="form-control" name="cari" id="cari" autofocus placeholder="Pencarian" autocomplete="off" onchange>
        </div>
    </form>
    <!-- Tampilkan QUERY Data berdasarkan pilihan view Data Card & Filter Pencarian -->
    <div class="table-responsive" id="container">
        <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th class="col-1"><?= $label[0]; ?></th>
                <th class="col"><?= $label[1]; ?></th>
                <th class="col"><?= $label[2]; ?></th>
                <th class="col"><?= $label[3]; ?></th>
                <th class="col-1"><?= $label[4]; ?></th>
                <th class="col-1"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php 
                $no=1;
                foreach( $rows as $row ) : ?>
                <td><?= $no; ?></td>
                <td><?php if($_GET['table']=="diagnosa"){ echo $row['code']; }elseif($_GET['table']=="tindakan"){ echo $row['id']; }elseif($_GET['table']=="obat"){ echo $row['id']; } ?></td>
                <td><?php if($_GET['table']=="diagnosa"){ echo $row['description']; }elseif($_GET['table']=="tindakan"){ echo $row['biaya']; }elseif($_GET['table']=="obat"){ echo $row['obat']; } ?></td>
                <td><?php if($_GET['table']=="diagnosa"){ echo $row['category']; }elseif($_GET['table']=="tindakan"){ echo $row['jenis']; }elseif($_GET['table']=="obat"){ echo $row['jenis']; } ?></td>
                <td><?php if($_GET['table']=="diagnosa"){ echo $row['chapter']; }elseif($_GET['table']=="tindakan"){ echo $row['ket']; }elseif($_GET['table']=="obat"){ echo $row['stok']; } ?></td>
                <td><?php if($_GET['table']=="diagnosa"){ echo substr($row['group'],0,3); }elseif($_GET['table']=="tindakan"){ echo number_format($row['tarif'], 0, '.', ',') . " /" . $row['satuan']; }elseif($_GET['table']=="obat"){ echo number_format($row['harga'], 0, '.', ',') . " /" . $row['satuan']; } ?></td>
                <td align="right">    
                    <?php if($u['akses']=="Superuser"){ ?>
                    <a class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#edit<?= $table . $row['id']; ?>"><span data-feather="edit"  class="feather-15"></span></a>
                    <a onclick="if(confirm('Apakah anda yakin akan menghapus data dengan ID : <?= $row['id'] ?> ??')){ location.href='functions.php?del_data<?= $table ?>=<?= $row['id'] ?>' }" class="btn btn-sm btn-danger"><span data-feather="trash-2"  class="feather-15"></span></a>
                    <?php } ?>
                </td>
                <!-- Modal Edit Data DIAGNOSA -->
                <div class="modal fade" id="editdiagnosa<?= $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLiveLabel">EDIT DATA ICD-10</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="functions.php?edt_diag=<?= $row['id']; ?>" method="post">
                                    <?php 
                                    $id = $row['id'];
                                    $icd10 = myquery("SELECT * FROM icd10 WHERE id='$id'");
                                    $edit = $icd10[0];
                                    ?>
                                    <div class="mb-2">
                                        <label class="form-label" for="i_chapter">Chapter</label>
                                        <input type="hidden" class="form-control form-control-sm" name="i_id" value="<?= $edit['id']; ?>">
                                        <input type="text" class="form-control form-control-sm" name="i_chapter" value="<?= $edit['chapter']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="i_group">Group</label>
                                        <input type="text" class="form-control form-control-sm" name="i_group" value="<?= $edit['group']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="i_code">Code</label>
                                        <input type="text" class="form-control form-control-sm" name="i_code" value="<?= $edit['code']; ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="i_description">Description</label>
                                        <input type="text" class="form-control form-control-sm" name="i_description" value="<?= $edit['description']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="i_category">Category</label>
                                        <input type="text" class="form-control form-control-sm" name="i_category" value="<?= $edit['category']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="i_user">User</label>
                                        <input type="text" class="form-control form-control-sm" name="i_user" value="<?= $edit['user'] ?>" readonly>
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
                <!-- Modal Edit Data TINDAKAN -->
                <div class="modal fade" id="edittindakan<?= $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLiveLabel">EDIT DATA TINDAKAN</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="functions.php?edt_biaya=<?= $row['id']; ?>" method="post">
                                    <?php 
                                    $id = $row['id'];
                                    $biaya = myquery("SELECT * FROM biaya WHERE id='$id'");
                                    foreach ($biaya as $edit) :
                                    ?>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_nama">Kode</label>
                                        <input type="text" class="form-control form-control-sm" name="b_id" value="<?= $edit['id'] ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_nama">Tindakan/ Pemeriksaan</label>
                                        <input type="text" class="form-control form-control-sm" name="b_nama" value="<?= $edit['biaya'] ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_jenis">Jenis Tindakan</label>
                                        <input list="jenisBiaya" type="text" class="form-select form-select-sm" name="b_jenis" value="<?= $edit['jenis'] ?>">
                                        <datalist id="jenisBiaya">
                                            <option>RANAP</option>
                                            <option>PARTUS</option>
                                            <option>OBSERVASI</option>
                                            <option>RAWAT JALAN</option>
                                            <option>RAWAT JALAN GV</option>
                                            <?php 
                                            $jenisBiaya = myquery("SELECT DISTINCT jenis FROM biaya");
                                            if($jenisBiaya){
                                                foreach($jenisBiaya as $byJenis) :
                                                    echo "<option>" . $byJenis['jenis'] . "</option>";
                                                endforeach;
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_satuan">Satuan</label>
                                        <input list="satuanBiaya" type="text" class="form-control form-control-sm" name="b_satuan" value="<?= $edit['satuan'] ?>">
                                        <datalist id="satuanBiaya">
                                            <?php
                                            $satuanBiaya = myquery("SELECT DISTINCT satuan FROM biaya");
                                            if($satuanBiaya){
                                                foreach($satuanBiaya as $satBy) :
                                                    echo "<option>". $satBy['satuan'] ."</option>";
                                                endforeach;
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_tarif">Tarif</label>
                                        <input type="text" class="form-control form-control-sm" name="b_tarif" value="<?= $edit['tarif'] ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_ket">Keterangan</label>
                                        <input type="text" class="form-control form-control-sm" name="b_ket" value="<?= $edit['ket'] ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_note">Catatan</label>
                                        <input type="text" class="form-control form-control-sm" name="b_note" value="<?= $edit['note'] ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="b_user">User</label>
                                        <input type="text" class="form-control form-control-sm" name="b_user" value="<?= $edit['user'] ?>" readonly>
                                    </div>
                                    <?php endforeach; ?>
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
                <!-- Modal Edit Data OBAT -->
                <div class="modal fade" id="editobat<?= $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLiveLabel">EDIT DATA OBAT</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form role="form" action="functions.php?edt_obat=<?= $row['id']; ?>" method="post">
                                    <?php 
                                    $id = $row['id'];
                                    $obat = myquery("SELECT * FROM obat WHERE id='$id'");
                                    foreach ($obat as $edit) :
                                    ?>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_id">Merek Obat</label>
                                        <input type="text" class="form-control form-control-sm" name="o_id" value="<?= $edit['id']; ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_nama">Merek Obat</label>
                                        <input type="hidden" class="form-control form-control-sm" name="o_id">
                                        <input type="text" class="form-control form-control-sm" name="o_nama" value="<?= $edit['obat']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_jenis">Kandungan</label>
                                        <input type="text" class="form-control form-control-sm" name="o_jenis" value="<?= $edit['jenis']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_satuan">Satuan</label>
                                        <input list="satuan" type="text" class="form-control form-control-sm" name="o_satuan" value="<?= $edit['satuan']; ?>">
                                        <datalist id="satuan">
                                            <?php
                                            $satuanObat = myquery("SELECT DISTINCT satuan FROM obat ORDER BY satuan");
                                            foreach ($satuanObat as $satOb) :
                                                echo "<option>". $satOb['satuan'] ."</option>";
                                            endforeach;
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_harga">Harga Jual</label>
                                        <input type="text" class="form-control form-control-sm" name="o_harga" value="<?= $edit['harga']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_note">Keterangan</label>
                                        <input type="text" class="form-control form-control-sm" name="o_note" value="<?= $edit['note']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_stok">Stok</label>
                                        <input type="text" class="form-control form-control-sm" name="o_stok" value="<?= $edit['stok']; ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_minim">Stok Minimum</label>
                                        <input type="text" class="form-control form-control-sm" name="o_minim" value="<?= $edit['minim']; ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label" for="o_user">User</label>
                                        <input type="text" class="form-control form-control-sm" name="o_user" value="<?= $edit['user'] ?>" readonly>
                                    </div>
                                    <?php endforeach; ?>
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
            </tr>
            <?php 
            $no++;
            endforeach; ?>
        </tbody>
        </table>
        <?php if(!isset($_POST['cari'])){ ?>
        <!-- Pagination -->
        <ul class="pagination d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center">
            <li class="page-item active<?php if($pagi[3]==1){ echo " disabled"; } ?>">
                <a class="page-link" style="background-color: #198754; border-color: #fff" href="?table=<?= $_GET['table']; ?>&page=<?= $pagi[3] - 1; ?>" aria-label="Previous">
                <span aria-hidden="true">«</span>
                </a>
            </li>
            <li class="page-item active">
                <b class="page-link" style="background-color: #198754; border-color: #fff">
                <?= $pagi[3]; ?> : <?= $pagi[2]; ?>
                </b>
            </li>
            <li class="page-item active<?php if($pagi[3]==$pagi[2]){ echo " disabled"; } ?>">
                <a class="page-link" style="background-color: #198754; border-color: #fff" href="?table=<?= $_GET['table']; ?>&page=<?= $pagi[3] + 1; ?>" aria-label="Next">
                <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
        <!-- <br> -->
        <?php if($u['akses']=="Superuser"){ ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <!-- Export data ke Excel -->
            <a class="btn btn-success" href="functions_exceload.php?export=<?php if($_GET['table']=="diagnosa"){ echo "icd10"; }elseif($_GET['table']=="tindakan"){ echo "biaya"; }elseif($_GET['table']=="obat"){ echo "obat"; } ?>">
            <span data-feather="download"  class="feather-15"></span> Export to xls</a>
            <div class="btn-toolbar mb-2 mb-md-0">
            <!-- Import from Excel -->
            <form method="post" enctype="multipart/form-data" action="functions_exceload.php?import=<?php if($_GET['table']=="diagnosa"){ echo "icd10"; }elseif($_GET['table']=="tindakan"){ echo "biaya"; }elseif($_GET['table']=="obat"){ echo "obat"; } ?>">
                <div class="input-group">
                <div class="input-group-text p-0">
                <input type="file" name="import_<?php if($_GET['table']=="diagnosa"){ echo "icd10"; }elseif($_GET['table']=="tindakan"){ echo "biaya"; }elseif($_GET['table']=="obat"){ echo "obat"; } ?>" class="form-control col-md-1 d-flex" required> 
                </div>
                <input name="import" type="submit" class="btn btn-success" value="Import">
                </div>
            </form>
            </div>
        </div>
        <?php } } ?>
    </div>
    <?php 
    }else{
        echo "<h5 class='display-6 md-2'>Silahkan Memilih Database...</h5>";
    } ?>
</main>

<!-- Modal Input Data DIAGNOSA -->
<div class="modal fade" id="inputDiag" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLiveLabel">Input Data ICD-10</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" action="functions.php?add_diag" method="post">
                    <div class="mb-2">
                        <label class="form-label" for="ii_chapter">Chapter</label>
                        <input list="chapter" type="text" class="form-control form-control-sm" name="ii_chapter"  id="ii_chapter">
                        <!-- <select type="text" class="selectpicker" data-live-search="true" data-style="btn-secondary" data-width="100%" style="width: 100%" name="icd" id="icd" onchange="diagnos(this.value)"> -->
                        <datalist id="chapter">
                            <?php 
                            $icd10 = myquery("SELECT DISTINCT chapter FROM icd10 ORDER BY code ASC");
                            foreach($icd10 as $i) :
                                echo "<option>" . $i['chapter'] ."</option>";
                            endforeach;
                            ?>
                        </datalist>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ii_group">Group</label>
                        <input list="group" type="text" class="form-control form-control-sm" name="ii_group" id="ii_group">
                        <datalist id="group">
                            <option>pilih</option>
                        </datalist>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ii_code">Code</label>
                        <input type="text" class="form-control form-control-sm" name="ii_code" id="ii_code">
                        <div class="invalid-feedback">Kode sudah terdaftar ..</div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ii_description">Description</label>
                        <input type="text" class="form-control form-control-sm" name="ii_description" id="ii_description" onkeyup="enableInputICD()">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ii_category">Category</label>
                        <input list="categ" type="text" class="form-control form-control-sm" name="ii_category" id="ii_category">
                        <datalist id="categ">
                            <?php 
                            $icdCtg = myquery("SELECT DISTINCT category FROM icd10");
                            foreach($icdCtg as $ctg) :
                                echo "<option>" . $ctg['category'] ."</option>";
                            endforeach;
                            ?>
                        </datalist>
                    </div>
                    <br>
                    <div class="modal-footer">  
                        <button type="submit" id="ii_submit" class="btn btn-success" disabled>Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                    <script> 
                        // ajax tampilkan icd GROUP & CATEGORY
                        var iiChap = document.getElementById('ii_chapter');
                        var grup = document.getElementById('group');
                        iiChap.addEventListener('change', function(){
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(){
                            if( xhr.readyState == 4 && xhr.status == 200 ){
                                grup.innerHTML = xhr.responseText;
                            }
                        }
                        xhr.open('GET', 'ajax/validasi.php?icdChap=' + iiChap.value, true);
                        xhr.send();
                        });
                        // ajax tampilkan icd GROUP & CATEGORY
                        // var iiGrup = document.getElementById('ii_group');
                        // var iiCate = document.getElementById('ii_category');
                        // iiGrup.addEventListener('change', function(){
                        // var xhr = new XMLHttpRequest();
                        // xhr.onreadystatechange = function(){
                        //     if( xhr.readyState == 4 && xhr.status == 200 ){
                        //         iiCate.value = xhr.responseText;
                        //     }
                        // }
                        // xhr.open('GET', 'ajax/validasi.php?icdGrup=' + iiGrup.value, true);
                        // xhr.send();
                        // });

                        // ajax cek kode ICD
                        var btICD = document.getElementById('ii_submit');
                        var dis = document.createAttribute('disabled');
                        var kdICD = document.getElementById('ii_code');
                        var nmICD = document.getElementById('ii_description');
                        kdICD.addEventListener('keyup', function(){
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(){
                            if( xhr.readyState == 4 && xhr.status == 200 ){
                                kdICD.className = xhr.responseText;
                                // console.log(kdICD.className);
                            }
                        }
                        xhr.open('GET', 'ajax/validasi.php?kodeICD=' + kdICD.value, true);
                        xhr.send();
                        });
                        function enableInputICD(){
                            if(nmICD.value !== "" && kdICD.classList.contains('is-valid')){
                                btICD.removeAttribute('disabled');
                            }else{
                                btICD.setAttributeNode(dis);
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</div> 
<!-- Modal Input Data TINDAKAN -->
<div class="modal fade" id="inputJasa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLiveLabel">Input Data Biaya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" action="functions.php?add_biaya" method="post">
                    <div class="mb-2">
                        <label class="form-label" for="ib_id">Kode</label>
                        <input type="text" class="form-control form-control-sm is-valid" name="ib_id" id="ib_id" value="<?= autoCode('biaya', 'id', ''); ?>" required>
                        <div class="invalid-feedback">Kode sudah terdaftar ..</div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ib_nama">Tindakan/ Pemeriksaan</label>
                        <input type="text" class="form-control form-control-sm" name="ib_nama" id="ib_nama" onkeyup="enable()" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ib_jenis">Jenis Tindakan</label>
                        <input list="jenisBiaya" type="text" class="form-control form-control-sm" name="ib_jenis" required>
                        <datalist id="jenisBiaya">
                            <?php 
                            $jenisBiaya = myquery("SELECT DISTINCT jenis FROM biaya");
                            if($jenisBiaya){
                                foreach($jenisBiaya as $byJenis) :
                                    echo "<option>" . $byJenis['jenis'] . "</option>";
                                endforeach;
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ib_satuan">Satuan</label>
                        <input list="satuanBiaya" type="text" class="form-control form-control-sm" name="ib_satuan" required>
                        <datalist id="satuanBiaya">
                            <?php
                            $satuanBiaya = myquery("SELECT DISTINCT satuan FROM biaya");
                            if($satuanBiaya){
                                foreach($satuanBiaya as $satBy) :
                                    echo "<option>". $satBy['satuan'] ."</option>";
                                endforeach;
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ib_tarif">Tarif</label>
                        <input type="text" class="form-control form-control-sm" name="ib_tarif" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ib_ket">Keterangan</label>
                        <input type="text" class="form-control form-control-sm" name="ib_ket" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="ib_note">Catatan</label>
                        <input type="text" class="form-control form-control-sm" name="ib_note" value="-" required>
                    </div>
                    <br>
                    <div class="modal-footer">  
                        <button type="submit" id="ib_submit" class="btn btn-success" disabled>Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                    <script>
                        // ajax cek kode biaya
                        var btn = document.getElementById('ib_submit');
                        var dis = document.createAttribute('disabled');
                        var kdBy = document.getElementById('ib_id');
                        var nmBy = document.getElementById('ib_nama');
                        kdBy.addEventListener('keyup', function(){
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(){
                            if( xhr.readyState == 4 && xhr.status == 200 ){
                                kdBy.className = xhr.responseText;
                                console.log(kdBy.className);
                            }
                        }
                        xhr.open('GET', 'ajax/validasi.php?kodeBiaya=' + kdBy.value, true);
                        xhr.send();
                        // if(kdBy.value == ""){
                        //     btn.setAttributeNode(dis);
                        // }else if(kdBy.classList.contains('is-invalid')){
                        //     btn.setAttributeNode(dis);
                        // }else if(nmBy.value !== "" && kdBy.classList.contains('is-valid')){
                        //     btn.removeAttribute('disabled');
                        // }
                        });
                        function enable(){
                            if(nmBy.value !== "" && kdBy.classList.contains('is-valid')){
                                btn.removeAttribute('disabled');
                            }else{
                                btn.setAttributeNode(dis);
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</div> 
<!-- Modal Input Data OBAT -->
<div class="modal fade" id="inputObat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLiveLabel">Input Data Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form role="form" action="functions.php?add_obat" method="post">
                    <div class="mb-2">
                        <label class="form-label" for="io_id">Kode Obat</label>
                        <input type="text" class="form-control form-control-sm is-valid" name="io_id" id="io_id" value="<?= autoCode('obat', 'id', 'R') ?>" required>
                        <div class="invalid-feedback">Kode sudah terdaftar ..</div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_nama">Merek Obat</label>
                        <input type="text" class="form-control form-control-sm" name="io_nama" id="io_nama" onkeyup="enableInputObat()" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_jenis">Kandungan</label>
                        <input type="text" class="form-control form-control-sm" name="io_jenis" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_satuan">Satuan</label>
                        <input list="satuan" type="text" class="form-control form-control-sm" name="io_satuan" required>
                        <datalist id="satuan">
                            <?php
                            $satuanObat = myquery("SELECT DISTINCT satuan FROM obat ORDER BY satuan");
                            foreach ($satuanObat as $satOb) :
                                echo "<option>". $satOb['satuan'] ."</option>";
                            endforeach;
                            ?>
                        </datalist>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_harga">Harga Jual</label>
                        <input type="text" class="form-control form-control-sm" name="io_harga" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_note">Keterangan</label>
                        <input type="text" class="form-control form-control-sm" name="io_note" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_stok">Stok Awal</label>
                        <input type="text" class="form-control form-control-sm" name="io_stok" value="0" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="io_minim">Stok Minimum</label>
                        <input type="text" class="form-control form-control-sm" name="io_minim" value="0">
                    </div>
                    <br>
                    <div class="modal-footer">  
                        <button type="submit" id="io_submit" class="btn btn-success" disabled>Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                    <script>
                        // ajax cek kode biaya
                        var btnOb = document.getElementById('io_submit');
                        var dis = document.createAttribute('disabled');
                        var kdOb = document.getElementById('io_id');
                        var nmOb = document.getElementById('io_nama');
                        kdOb.addEventListener('keyup', function(){
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function(){
                            if( xhr.readyState == 4 && xhr.status == 200 ){
                                kdOb.className = xhr.responseText;
                                console.log(kdOb.className);
                            }
                        }
                        xhr.open('GET', 'ajax/validasi.php?kodeObat=' + kdOb.value, true);
                        xhr.send();
                        // if(kdOb.value == ""){
                        //     btnOb.setAttributeNode(dis);
                        // }else if(kdOb.classList.contains('is-invalid')){
                        //     btnOb.setAttributeNode(dis);
                        // }else if(nmOb.value !== "" && kdOb.classList.contains('is-valid')){
                        //     btnOb.removeAttribute('disabled');
                        // }
                        });
                        function enableInputObat(){
                            if(kdOb.classList.contains('is-valid') && nmOb.value !== ""){
                                btnOb.removeAttribute('disabled');
                            }else{
                                btnOb.setAttributeNode(dis);
                            }
                        }
                    </script>
                </form>
            </div>
        </div>
    </div>
</div> 


<!-- Selektor Tanggal -->
<script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
    $(function() {
        $('#im_tgl').datepicker({ 
        autoclose: true,
        todayHighlight: true,
        format : 'yyyy-mm-dd' 
        });
    });
    $(function() {
        $('#m_tgl').datepicker({ 
        autoclose: true,
        todayHighlight: true,
        format : 'yyyy-mm-dd' 
        });
    });
    // $('#ido').editableSelect();
    // ajax cek kasus lama atau baru
    var cari = document.getElementById('cari');
    var tabel = document.getElementById('container');
    var data = "<?= $table; ?>";
    cari.addEventListener('keyup', function(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if( xhr.readyState == 4 && xhr.status == 200 ){
                tabel.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', 'ajax/cari_data.php?table='+ data +'&cari='+ cari.value, true);
        xhr.send();
    });
    </script>