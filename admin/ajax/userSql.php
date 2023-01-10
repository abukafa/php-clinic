<?php
include '../config.php';
include '../functions.php';


if(isset($_GET['edit'])){
    $tab = $_GET['edit'];
    ?>

    <div class="mb-2">
        <label class="form-label">Kolom</label>
        <select id="kolom" class="form-select" onchange="generateQuery()">

        <?php
        $kols = myquery("SHOW COLUMNS FROM ". $tab);
        foreach($kols as $kol) :
            echo "<option>" . $kol['Field'] . "</option>";
        endforeach;
        ?>

        </select>
    </div>
    <div>
        <label class="form-label">Konsidi</label>
        <select id="kondisi" class="form-select" onchange="generateQuery()">

        <?php
        $kols = myquery("SHOW COLUMNS FROM ". $tab);
        foreach($kols as $kol) :
            echo "<option>" . $kol['Field'] . "</option>";
        endforeach;
        ?>

        </select>
    </div>
<?php
}
?>