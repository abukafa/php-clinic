<!doctype html>
<html lang="en">
  <?php
  require 'admin/config.php';
  session_start();
    if(isset($_COOKIE['aku']) && isset($_COOKIE['kamu'])){
      $id = $_COOKIE['aku'];
      $uname = $_COOKIE['kamu'];
      $result = mysqli_query($conn, "select uname from user where id='$id'");
      $row = mysqli_fetch_assoc($result);
      if($uname === hash('sha256', $row['uname'])){
        $_SESSION['uname'] = $row['uname'];
      }
    }
    if(isset($_SESSION['uname'])){
      header("location:admin/dashboard.php");
      exit;
    }
  ?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>SIK Az-Zahra Medika</title>
    <link href="./img/logo.png" rel="shortcut icon" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      body {
        background-image: url('../index/watermark.png');
        background-repeat: repeat;
        height: 100vh;
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="./assets/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <main class="form-signin" style="border-radius:20px; background-color: #f58d91;">
    <?php 
    // Login action
    if(isset($_POST['login'])){
      $uname=$_POST['uname'];
      $pass=$_POST['pass'];
      $result = mysqli_query($conn, "select * from user where uname='$uname'");
      if( mysqli_num_rows($result) === 1 ){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row["pass"])){
          session_start();
          if(isset($_POST['ingat'])){
            // Cookie
            setcookie('aku', $row['id'], time()+3600);
            setcookie('kamu', hash('sha256', $row['uname']), time()+3600);
          }
          $_SESSION['uname']=$uname;
          header("location:admin/dashboard.php");
        }else{
          header("location:index.php?pesan=gagal");
          // mysql_error();
        }  
      }else{
        header("location:index.php?pesan=no");
        // mysql_error();
      }
    }
    // Pesan Gagal
    if(isset($_GET['pesan'])){
        if($_GET['pesan'] == "gagal"){
          echo "<span class='alert alert-danger'>Login gagal.. Coba Lagi ya..</span><br/><br/><br/>";
        }elseif($_GET['pesan'] == "no"){
          echo "<span class='alert alert-warning'>Silahkan Login terlebih dahulu..</span><br/><br/><br/>";
        }
    }
    ?>
      <!-- Form Login -->
      <form action="" method="post">
        <img class="mb-4" src="./img/logo.png" alt="" width="120" height="110">
        <h1 class="h3 mb-3 fw-normal">Please Login</h1>
        <div class="form-floating">
          <input type="text" class="form-control" id="floatingInput" name="uname" placeholder="Username">
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="floatingPassword" name="pass"  placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me" name="ingat"> Remember me
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-success" name="login" type="submit">Login</button>
        <p class="mt-5 mb-3 text-muted">&copy; Klinik Az-Zahra Medika</p>
      </form>
    </main>
  </body>
</html>