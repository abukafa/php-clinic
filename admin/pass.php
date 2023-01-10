<?php 
include 'sidebar.php';
// Registrasi user baru
if(isset($_POST['newPass'])){
  $user=$_POST['user'];
  $lama=$_POST['lama'];
  $baru=$_POST['baru'];
  $ulang=$_POST['ulang'];
  $result = mysqli_query($conn, "select * from user where uname='$user'");
  if( mysqli_num_rows($result) === 1 ){
    $row = mysqli_fetch_assoc($result);
    if($baru==$ulang && $lama!==$baru){
      if(password_verify($lama, $row["pass"])){
        $baru = password_hash($baru, PASSWORD_DEFAULT);
        mysqli_query($conn, "update user set pass='$baru' where uname='$user'");
        echo "<div class='alert alert-success alert-dismissible' role='alert'>Password berhasil dirubah !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
      }else{
        echo "<div class='alert alert-danger alert-dismissible' role='alert'>Password yang dimasukan Salah !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
      }
    }else{
      echo "<div class='alert alert-warning alert-dismissible' role='alert'>Password yang dimasukan Tidak Sesuai !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
  }
}
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ganti Password Pengguna</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
    </div>
  </div>
  <!-- Pesan Notifikasi -->
  <body>  
    <div> 
    </div>
    <br/>
    <!-- Form Ganti Password -->
    <div>
      <form action="" method="post">
        <div class="col-md-4 col-md-offset-4">
          <div class="mb-2">
            <label class="form-label">Username</label>
            <input name="user" type="text" class="form-control" value="<?php echo $_SESSION['uname']; ?>" readonly>
          </div>
          <div class="mb-2">
            <label class="form-label">Password Lama</label>
            <input name="lama" type="password" class="form-control" placeholder="Password Lama .." required>
          </div>
          <div class="mb-2">
            <label class="form-label">Password Baru</label>
            <input name="baru" id="baru" type="password" class="form-control" placeholder="Password Baru .."required>
          </div>
          <div class="mb-2">
            <label class="form-label">Ulangi Password</label>
            <input name="ulang" id="ulang" type="password" class="form-control" placeholder="Ulangi Password .." onkeyup="sameCheck()">
            <div class="valid-feedback">Password sesuai..</div>
            <div class="invalid-feedback">Password tidak sama !!</div>
          </div>
          <script>    
            function sameCheck(){  
            var pas = document.getElementById('baru');
            var rpas = document.getElementById('ulang');
              if (rpas.value !== pas.value){
                rpas.className = "form-control is-invalid";
              }else if (rpas.value == pas.value){
                rpas.className = "form-control is-valid";
              }
            };  
          </script>  
          <br>
          <div class="mb-2">
            <input type="submit" name="newPass" class="btn btn-success" value="Simpan">
            <input type="reset" class="btn btn-secondary" value="Reset">
          </div>                    
        </div>    
      </form>
    </div>
  </body>
</main>