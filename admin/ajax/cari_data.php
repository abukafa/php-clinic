<?php
include '../config.php';
include '../functions.php';

$cari = $_GET['cari'];
if($cari<>""){
    if($_GET['table'] == "diagnosa"){
        $queCari = "SELECT * FROM icd10 WHERE code LIKE '%$cari%' OR description LIKE '%$cari%'";
        $rows = cari($queCari, $cari);
        $label = ["Code", "Description", "Category", "Chapter", "Group"];
    }elseif($_GET['table'] == "tindakan"){
        $queCari = "SELECT * FROM biaya WHERE biaya LIKE '%$cari%' OR jenis LIKE '%$cari%'";
        $rows = cari($queCari, $cari);
        $label = ["Kode", "Nama Tindakan", "Jenis", "Keterangan", "Tarif"];
    }elseif($_GET['table'] == "obat"){
        $queCari = "SELECT * FROM obat WHERE obat LIKE '%$cari%' OR jenis LIKE '%$cari%'";
        $rows = cari($queCari, $cari);
        $label = ["Kode", "Merek Obat", "Kandungan", "Stok", "Harga"];
    }
    ?>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
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
            </tr>
            <?php 
            $no++;
            endforeach; ?>
        </tbody>
        </table>
    </div>
<?php
}
?>