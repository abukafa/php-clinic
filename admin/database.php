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
    <div class="row row-cols-1 row-md-2 g-4">
        <!-- data card ICD-10 -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <h6 class="card-header" style="background-color: #6c757d"><div style="color: #ffffff">Diagnosa</div></h6>
                <div class="card-body" style="background-color: #95DAC1">
                    <?php $totalIcd = count(myquery("select * from icd10")); ?>
                    <h1 class="card-title display-1 float-md-end" style="color: #6c757d"><?= $totalIcd; ?></h1>
                    <br><br><br>
                    <a href="data_diagnosa.php" class="btn btn-sm btn-secondary"><span data-feather="eye"  class="feather-15"></span></a>
                    <?php if(isset($_GET['table'])){ if($_GET['table'] == "diagnosa"){ ?>
                    <a class="btn btn-sm btn-secondary"><span data-feather="plus"  class="feather-15" data-bs-toggle="modal" data-bs-target="#inputDiag"></span></a>
                    <?php } } ?>
                </div>
                <em class="card-footer figure-caption" style="background-color: #6c757d"><div style="color: #ffffff">Database ICD-10</div></em>
            </div>
        </div>
        <!-- data card Jasa Pemeriksaan & Tindakan -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <h6 class="card-header" style="background-color: #6c757d"><div style="color: #ffffff">Tindakan</h6>
                <div class="card-body" style="background-color: #FFEBA1">
                    <?php $totalBiaya = count(myquery("select * from biaya")); ?>
                    <h1 class="card-title display-1 float-md-end" style="color: #6c757d"><?= $totalBiaya; ?></h1>
                    <br><br><br>
                    <a href="?table=tindakan" class="btn btn-sm btn-secondary"><span data-feather="eye"  class="feather-15"></span></a>
                    <?php if(isset($_GET['table'])){ if($_GET['table'] == "tindakan"){ ?>
                    <a class="btn btn-sm btn-secondary"><span data-feather="plus"  class="feather-15" data-bs-toggle="modal" data-bs-target="#inputJasa"></span></a>
                    <?php } } ?>
                </div>
                <em class="card-footer figure-caption" style="background-color: #6c757d"><div style="color: #ffffff">Database Jasa Tindakan</div></em>
            </div>
        </div>
        <!-- data card Farmasi -->
        <div class="col-12 col-lg-4">
            <div class="card">
                <h6 class="card-header" style="background-color: #6c757d"><div style="color: #ffffff">Farmasi</h6>
                <div class="card-body" style="background-color: #FD6F96">
                    <?php $totalObat = count(myquery("select * from obat")); ?>
                    <h1 class="card-title display-1 float-md-end" style="color: #6c757d"><?= $totalObat; ?></h1>
                    <br><br><br>
                    <a href="?table=obat" class="btn btn-sm btn-secondary"><span data-feather="eye"  class="feather-15"></span></a>
                    <?php if(isset($_GET['table'])){ if($_GET['table'] == "obat" || $_GET['table'] == "obatmasuk"){ ?>
                    <a class="btn btn-sm btn-secondary"><span data-feather="plus"  class="feather-15" data-bs-toggle="modal" data-bs-target="#inputObat"></span></a>
                    <a href="?table=masuk" class="btn btn-sm btn-secondary"><span data-feather="shopping-bag"  class="feather-15"></span></a>
                    <?php } } ?>
                </div>
                <em class="card-footer figure-caption" style="background-color: #6c757d"><div style="color: #ffffff">Database Obat</div></em>
            </div>
        </div>
    </div>
    <br>
    <h5 class='display-6 md-2'>Silahkan Memilih Database...</h5>
</main>