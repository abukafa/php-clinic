<!DOCTYPE html>
<html lang="en">
<?php
include 'config.php';
include 'functions.php';
if(!isset($_SESSION['uname'])){
    header("location:../index.php?pesan=no");
    exit;
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIK Az-Zahra Medika</title>
    <link href="../img/logo.png" rel="shortcut icon" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <!-- <link href="../assets/css/jquery-editable-select.css" rel="stylesheet"> -->
</head>
    <style>
        a:link {
        text-decoration: none;
        }
        #navbarDropdown {
        color: #198754;
        text-decoration: none;
        }
        .feather-17{
            width: 17px;
            height: 17px;
        }
        .feather-15{
            width: 15px;
            height: 15px;
        }
        .feather-13{
            width: 13px;
            height: 13px;
        }
    </style>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header__toggle">
            <i id="header-toggle"><span data-feather="menu"></span></i>
        </div>
        <div>
            <!-- notification menu -->
            <?php 
            $queryNotiObat = "SELECT * FROM obat WHERE stok < minim";
            $queryNoti = "SELECT * FROM notifikasi";
            $countNoti = myNumRow($queryNoti);
            $countNotiObat = myNumRow($queryNotiObat);
            $sumNoti = $countNoti + $countNotiObat;
            if($countNoti !== 0 || $countNotiObat !== 0){
            ?>
            <a class="dropdown me-2" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="color:red">
            <span style="font-size:13px; vertical-align:top;"><?= $sumNoti ?></span><span data-feather="bell"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2" data-popper-placement="left-end" style="width:700px">
                <li><h6 class="dropdown-header"><?= $sumNoti ?> Notifikasi</h6></li>
                <?php if($countNotiObat !== 0){    
                $rowNotiObat = myquery($queryNotiObat);
                foreach($rowNotiObat as $notiObat) : ?>
                <li class="dropdown-item" style="color:red; white-space:normal;"><span data-feather="alert-triangle" class="feather-15 me-3"></span>Cek Stok Obat : <?= $notiObat['obat'] .' - '. $notiObat['stok'] .' '. $notiObat['satuan'] ?> !!</li>
                <?php endforeach; } ?>
                <?php if($countNoti !== 0){    
                $rowNoti = myquery($queryNoti);
                foreach($rowNoti as $noti) : ?>
                <li class="dropdown-item" style="color:red; white-space:normal;"><span data-feather="alert-triangle" class="feather-15 me-3"></span><?= $noti['pesan']; ?></li>
                <?php endforeach; } ?>
            </ul>         
            <?php
            }
            ?>
            <!-- user account menu -->
            <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                <b><?= $u['nama']; ?></b>
            </a>
            <img src="../img/logo.png" width="45px" height="40px" alt="">
            <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="navbarDropdown">
                <li><h6 class="dropdown-header">Informasi Pengguna</h6></li>
                <li><a class="dropdown-item" href="user.php">Pengguna</a></li>
                <li><a class="dropdown-item" href="pass.php">Ganti Password</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="dashboard.php"><?= $u['bagian'] ." - ". $u['akses']; ?></a></li>
            </ul> 
        </div>
    </header>
    <br/><br/><br/>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav__logo">
                <img src="../img/logo_white.png" alt="" height="23" width="23">
                    <span class="nav__logo-name">Az-Zahra Medika</span>
                </a>
                <div class="nav__list">
                    <a href="dashboard.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/dashboard.php'){ echo 'active'; } ?>">
                        <span data-feather="grid"></span>
                        <span class="nav__name">Dashboard</span>
                    </a>
                    <a href="pasien.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/pasien.php'){ echo 'active'; } ?>">
                        <span data-feather="user-plus"></span>
                        <span class="nav__name">Pendaftaran</span>
                    </a>
                    <a href="anamnesa.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/anamnesa.php'){ echo 'active'; } ?>">
                        <span data-feather="twitch"></span>
                        <span class="nav__name">Anamnesa</span>
                    </a>
                    <a href="dokter.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/dokter.php'){ echo 'active'; } ?>">
                        <span data-feather="pocket"></span>
                        <span class="nav__name">Pemeriksaan</span>
                    </a>
                    <a href="admin.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/admin.php'){ echo 'active'; } ?>">
                        <span data-feather="file-text"></span>
                        <span class="nav__name">Admin</span>
                    </a>
                    <a href="farmasi.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/farmasi.php'){ echo 'active'; } ?>">
                        <span data-feather="thermometer"></span>
                        <span class="nav__name">Farmasi</span>
                    </a>
                    <a href="rekam.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/rekam.php'){ echo 'active'; } ?>">
                        <span data-feather="clipboard"></span>
                        <span class="nav__name">Rekam Medis</span>
                    </a>
                    <a href="data.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/azm/admin/data.php'){ echo 'active'; } ?>">
                        <span data-feather="database"></span>
                        <span class="nav__name">Database</span>
                    </a>
                </div>
            </div>
            <a href="logout.php" class="nav__link">
                <span data-feather="log-out"></span>
                <span class="nav__name">Log Out</span>
            </a>
        </nav>
    </div>
    <!-- JS Library -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/feather.min.js"></script>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap-datepicker.min.js"></script>
    <!-- <script src="../assets/js/jquery-editable-select.js"></script> -->
    <script>
        $(document).ready(function(){
            feather.replace();
        });
        // $('button').click(function(){
        //     $('.alert').html('<i data-feather="activity"></i>');
        //     feather.replace();
        // });
        </script>
</body>
</html>