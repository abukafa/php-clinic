<?php 
include '../../admin/config.php';
include '../../admin/functions.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap-select.min.css">

    <title>Hello, world!</title>
</head>
<body>

    <h1>Hello, world!</h1>
<div class="container">
    <div class="col-sm-7">
        <div class="form-group">
            <select type="text" class="selectpicker" data-style="btn-success" data-live-search="true" id="icd" onchange="diagnos(this.value)" data-width="100%" style="width: 100%;">
                <?php 
                $icd10 = myquery("SELECT * FROM icd10 ORDER BY code");
                $jsArray2 = "var diag = new Array();\n";
                foreach($icd10 as $i) :
                    echo "<option value='". $i['code']. "'>". $i['code'] ." - ". $i['description'] ."</option>";
                    $jsArray2 .= "diag['". $i['code'] ."'] = {desc:'". addslashes($i['description']) ."'};\n";
                endforeach;
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-10">
        <label for="diag" class="form-label">Diagnosa</label>
        <input type="text" class="form-control" name="diagnosa" id="diagnosa" value="<?= isset($_GET['edit']) ? $row['diagnosa'] : '' ?>" readonly>
    </div>
</div>
    <script type="text/javascript">
        <?= $jsArray2; ?>
        function diagnos(icd){
            document.getElementById('diagnosa').value = diag[icd].desc;
        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery-3.3.1.slim.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="bootstrap-select.min.js"></script>
    <script>
        $('.selectpicker').selectpicker();
    </script>  
  </body>
</html>