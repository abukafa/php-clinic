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
<style>
/*===== GOOGLE FONTS =====*/
/* @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"); */

/*===== VARIABLES CSS =====*/
:root{
  --header-height: 3rem;
  --nav-width: 68px;

  /*===== Colors =====*/
    --first-color: #198754;
    --first-color-light: #6cb894;
    --white-color: #f6fbf6;
  
  /*===== Font and typography =====*/
  --body-font: 'Nunito', sans-serif;
  --normal-font-size: 1rem;
  
  /*===== z index =====*/
  --z-fixed: 100;
}

/*===== BASE =====*/
*,::before,::after{
  box-sizing: border-box;
}

body{
  position: relative;
  margin: var(--header-height) 0 0 0;
  padding: 0 1rem;
  font-family: var(--body-font);
  font-size: var(--normal-font-size);
  transition: .5s;
}

a{
  text-decoration: none;
}

/*===== HEADER =====*/
.header{
  width: 100%;
  height: var(--header-height);
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1rem;
  background-color: var(--white-color);
  z-index: var(--z-fixed);
  transition: .5s;
}

.header__toggle{
  display: block;
  color: var(--first-color);
  font-size: 1.5rem;
  cursor: pointer;
  align-items: center;
}

.header__img{
  width: 35px;
  height: 35px;
  display: flex;
  justify-content: center;
  border-radius: 50%;
  overflow: hidden;
}

.header__img img{
  width: 40px;
}

/*===== NAV =====*/
.l-navbar{
  position: fixed;
  top: 0;
  left: -30%;
  width: var(--nav-width);
  height: 100vh;
  background-color: var(--first-color);
  padding: .5rem 1rem 0 0;
  transition: .5s;
  z-index: var(--z-fixed);
}

.nav{
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  overflow: hidden;
}

.nav__logo, .nav__link{
  display: grid;
  grid-template-columns: max-content max-content;
  align-items: center;
  column-gap: 1rem;
  padding: .5rem 0 .5rem 1.5rem;
}

.nav__logo{
  margin-bottom: 2rem;
}

.nav__logo-icon{
  font-size: 1.25rem;
  color: var(--white-color);
}

.nav__logo-name{
  color: var(--white-color);
  font-weight: 700;
}

.nav__link{
  position: relative;
  color: var(--first-color-light);
  margin-bottom: 1.5rem;
  transition: .3s;
}

.nav__link:hover{
  color: var(--white-color);
}

.nav__icon{
  font-size: 1.25rem;
}

/*Show navbar movil*/
.show{
  left: 0;
}

/*Add padding body movil*/
.body-pd{
  padding-left: calc(var(--nav-width) + 1rem);
}

/*Active links*/
.active{
  color: var(--white-color);
}

.active::before{
  content: '';
  position: absolute;
  left: 0;
  width: 2px;
  height: 32px;
  background-color: var(--white-color);
}

/* ===== MEDIA QUERIES=====*/
@media screen and (min-width: 768px){
  body{
    margin: calc(var(--header-height) + 1rem) 0 0 0;
    padding-left: calc(var(--nav-width) + 2rem);
  }

  .header{
    height: calc(var(--header-height) + 1rem);
    padding: 0 2rem 0 calc(var(--nav-width) + 2rem);
  }

  .header__img{
    width: 40px;
    height: 40px;
  }

  .header__img img{
    width: 45px;
  }

  .l-navbar{
    left: 0;
    padding: 1rem 1rem 0 0;
  }
  
  
#header-toggle{
  display: none;
}

  /*Show navbar desktop*/
  /* .show{
    width: calc(var(--nav-width) + 156px);
  } */

  /*Add padding body desktop*/
  /* .body-pd{
    padding-left: calc(var(--nav-width) + 188px);
  }  */
}
</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIK Az-Zahra Medika</title>
    <link href="../img/logo.png" rel="shortcut icon" type="image/x-icon">
    <!-- Bootstrap core CSS -->
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
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                    <a href="dashboard.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/dashboard.php'){ echo 'active'; } ?>">
                        <span data-feather="grid"></span>
                        <span class="nav__name">Dashboard</span>
                    </a>
                    <a href="pasien.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/pasien.php'){ echo 'active'; } ?>">
                        <span data-feather="user-plus"></span>
                        <span class="nav__name">Pendaftaran</span>
                    </a>
                    <a href="anamnesa.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/anamnesa.php'){ echo 'active'; } ?>">
                        <span data-feather="twitch"></span>
                        <span class="nav__name">Anamnesa</span>
                    </a>
                    <a href="dokter.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/dokter.php'){ echo 'active'; } ?>">
                        <span data-feather="pocket"></span>
                        <span class="nav__name">Pemeriksaan</span>
                    </a>
                    <a href="admin.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/admin.php'){ echo 'active'; } ?>">
                        <span data-feather="file-text"></span>
                        <span class="nav__name">Admin</span>
                    </a>
                    <a href="farmasi.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/farmasi.php'){ echo 'active'; } ?>">
                        <span data-feather="thermometer"></span>
                        <span class="nav__name">Farmasi</span>
                    </a>
                    <a href="rekam.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/rekam.php'){ echo 'active'; } ?>">
                        <span data-feather="clipboard"></span>
                        <span class="nav__name">Rekam Medis</span>
                    </a>
                    <a href="data.php" class="nav__link <?php if($_SERVER['REQUEST_URI'] == '/sik/admin/data.php'){ echo 'active'; } ?>">
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
    <script>
        $(document).ready(function(){
        feather.replace();
        });
        </script>
</body>
</html>