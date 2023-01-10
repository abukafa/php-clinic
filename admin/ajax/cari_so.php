<?php
include '../config.php';
include '../functions.php';

$cari = $_GET['cari'];
if($cari<>""){
$query = "SELECT * FROM opname WHERE obat LIKE '%$cari%' OR jenis LIKE '%$cari%' OR id LIKE '%$cari%' ORDER BY jenis, obat";
$jum = myNumRow($query);
?>
<h6 class="mb-2">Terdapat <?= $jum ?> Data Obat</h6>
<table id="data_table" class="table table-striped table-sm">
    <thead>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Merek Obat</th>
        <th class="col-md-1">SO</th>
        <th class="col-md-1">TM</th>
        <th class="col-md-1">TK</th>
        <th class="col-md-1">R.Dr</th>
        <th class="col-md-1">Sisa</th>
        <th class="col-md-1">Data</th>
        <th class="col-md-1">Selisih</th>
    </tr>
    </thead>
    <tbody>
    <tr id="<?= $id; ?>">
        <?php 
        $no=1;
        $cari = $_GET['cari'];
        $stokOpname = myquery($query);
        foreach ($stokOpname as $so) :
        $id = $so['id'];
        ?>
        <td><?= $no; ?></td>
        <td><?= $id; ?></td>
        <td><?= $so['obat']; ?></td>
        <td><?= $so['so']; ?></td>
        <?php 
        $masuk = myquery("SELECT SUM(IF(id_obat='$id', qty, 0)) as msk FROM masuk");
        $m = $masuk[0];
        $keluar = myquery("SELECT SUM(IF(id_obat='$id', qty, 0)) as klr FROM keluar");
        $k = $keluar[0];
        $tindak = myquery("SELECT SUM(IF(kode='$id', qty, 0)) as tdk FROM tindak");
        $t = $tindak[0];
        $sisa = $m['msk'] - $k['klr'] - $t['tdk'];
        ?>
        <td><?= $m['msk']; ?></td>
        <td><?= $k['klr']; ?></td>
        <td><?= $t['tdk']; ?></td>
        <th><?= $sisa; ?></th>
        <?php
        $obat = myquery("SELECT SUM(IF(id='$id', stok, 0)) as stok FROM obat");
        $o = $obat[0];
        $selisih = $so['so'] - (($sisa + $o['stok'])/2);
        ?>
        <td><?= $o['stok']; ?></td>
        <th <?= $selisih <> 0 ? "style='color:red'" : "" ?>><?= $selisih; ?></th>
    </tr>
    <?php 
    $no++;
    endforeach; 
    ?>
</table>

<script src="../../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../../assets/js/jquery.tabledit.js"></script>
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
			url: 'live_edit.php'		
		});
	});
</script>

<?php
}else{
?>

<h6 class="mb-2">Cari berdasarkan Merek , Kandungan, atau Kode Obat</h6>

<?php
}
?>