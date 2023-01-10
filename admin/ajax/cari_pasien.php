<?php
include '../config.php';
include '../functions.php';

$cari = $_GET['cari'];
if($cari<>""){
    $query = "SELECT * FROM pasien WHERE nama LIKE '%$cari%' ORDER BY nama";
    $jum = myNumRow($query);
    ?>
    <h6 class="mb-2">Terdapat <?= $jum ?> Data Pasien</h6>
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">NRM</th>
            <th class="col-1">Registrasi</th>
            <th scope="col">Nama</th>
            <th scope="col">JK</th>
            <th scope="col">Umur</th>
            <th scope="col">Alamat</th>
            <th scope="col">Penanggung</th>
            <th scope="col">Telephone</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php 
            $no=1;
            $pasien = myquery($query);
            foreach( $pasien as $pas ) :
            $id = $pas['id'];
            ?>
            <td><?= $no; ?></td>
            <td><?= $id; ?></td>
            <td><?= $pas['tgl_reg']; ?></td>
            <td><?= $pas['nama']; ?></td>
            <td><?= $pas['jk']; ?></td>
            <td align="center"><?php
            $lahir = date_format(date_create($pas['tgl_lahir']), 'Y');
            $umur = date('Y') - $lahir;
            echo $umur;
            ?></td>
            <td><?= $pas['alamat']; ?></td>
            <td><?= $pas['nama_pj']; ?></td>
            <td><?= $pas['telepon']; ?></td>
            <td align="right"></td>
        </tr>
        <?php 
        $no++;
        endforeach; ?>
        </tbody>
    </table>

<?php
}else{
?>

<h6 class="mb-2">Cari berdasarkan Nama Pasien, Nama Penanggung, atau Alamat</h6>

<?php
}
?>