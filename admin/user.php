<?php 
include 'sidebar_alt.php';
// Registrasi user baru
if(isset($_POST['registrasi'])){
  global $conn;
  $nama = $_POST['name'];
  $bag = $_POST['bagian'];
  $uname = $_POST['uname'];
  $pass = mysqli_real_escape_string($conn, $_POST['pass']);
  $repass = mysqli_real_escape_string($conn, $_POST['repass']);
  $akses = $_POST['akses'];
  $ket = $_POST['ket'];
  $poli = $_POST['poli'];
  $result = mysqli_query($conn, "select * from user where uname='$uname'");
  if( mysqli_num_rows($result) === 1 ){
    echo "<div class='alert alert-danger alert-dismissible' role='alert'>Username tersebut sudah terdaftar !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
  }else{
    if($pass!==$repass){
      echo "<div class='alert alert-warning alert-dismissible' role='alert'>Password yang dimasukan Tidak Sesuai !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }else{
      // Enkripsi Password
      $pass = password_hash($pass, PASSWORD_DEFAULT);
      mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$bag', '$uname', '$pass', '$akses', '$ket', '$poli')");
      echo "<div class='alert alert-success alert-dismissible' role='alert'>Data berhasil ditambah !!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
  }
}
?>
<!-- Menu Utama Data User -->
<main>
  <article class="pt-3 pb-2 mb-5 <?= $u['bagian'] == "Programmer" ? "d-block" : "d-none" ?>">
    <!-- Menu mysql -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3 border-bottom">
      <h2><a href="user.php" style="color:#198754">Edit Database</a></h2>
    </div>
    <div>
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <h4 class="accordion-header" id="headingOne">
            <button class="accordion-button <?= isset($_GET['userSQL']) ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <b>User SQL Query</b>
            </button>
          </h4>
          <div id="collapseOne" class="accordion-collapse collapse <?= isset($_GET['userSQL']) ? 'show' : '' ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <form action="functions.php?userSQL=edit" method="post">
                <div class="row g-3">
                  <div class="col-md-2">
                    <label class="form-label">Tabel</label>
                    <select name="tabel" id="tabel" class="form-select">
                      <option>.. pilih ..</option>
                      <?php
                      $tables = myquery("SHOW TABLES");
                      foreach($tables as $table) :
                        echo "<option>". $table['Tables_in_azm'] ."</option>";
                      endforeach
                      ?>
                    </select>
                  </div>
                  <div id="grup" class="col-md-2">
                    <div class="mb-2">
                      <label class="form-label">Kolom</label>
                      <select id="kolom" class="form-select" onchange="generateQuery()">
                        <option>.. pilih ..</option>
                      </select>
                    </div>
                    <div>
                      <label class="form-label">Konsidi</label>
                      <select id="kondisi" class="form-select" onchange="generateQuery()">
                        <option>.. pilih ..</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="mb-2">
                      <label class="form-label">Data Baru</label>
                      <input id="newValue" type="text" class="form-control" onkeyup="generateQuery()">
                    </div>
                    <div>
                      <label class="form-label">Data Lama</label>
                      <input id="oldValue" type="text" class="form-control" onkeyup="generateQuery()">
                    </div>
                  </div>
                </div>
                <div class="row g-2 mt-3">
                  <div class="col-md-2">
                    <select type="text" class="form-select" id="opsi" onchange="generateQuery()">
                      <option>Update</option>
                      <option>Delete</option>
                    </select>
                  </div>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="query" id="query"  autocomplete="off">
                  </div>
                  <div class="col-auto">
                    <button type="submit" id="io_submit" class="btn btn-success">
                      <span data-feather="save" class="feather-15"></span>
                    </button>
                  </div>
                  <div class="col-auto">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">
                      <span data-feather="refresh-cw" class="feather-15"></span>
                    </button>
                  </div>
                </div>
              </form>
              <br>
              <?php
              if(isset($_GET['userSQL'])){
                if($_GET['userSQL']=="OK"){
              ?>
              <div class="col-md-12 alert alert-success alert-dismissible fade show" role="alert">
                Data <a href="#" class="alert-link">Berhasil</a> dirubah
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php
                }else{
                ?>
                <div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert">
                  Data <a href="#" class="alert-link">Gagal</a> dirubah
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h4 class="accordion-header" id="headingOne">
            <button class="accordion-button <?= isset($_GET['userSQL']) ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <b>Overview</b>
            </button>
          </h4>
          <div id="collapseTwo" class="accordion-collapse collapse <?= isset($_GET['userSQL']) ? 'show' : '' ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <table class="table table-secondary table-striped table-bordered">
                <tr class="text-center">
                <?php
                $tables = myquery("SHOW TABLES");
                $jum = myNumRow("SHOW TABLES");
                foreach($tables as $table) :
                  echo "<th class='align-content-center'>". $table['Tables_in_azm'] ."</th>";
                endforeach;
                // var_dump($tables);
                echo "</tr><tr class='text-center'>";
                for($i=0; $i<$jum; $i++){
                  $tab = $tables[$i]['Tables_in_azm'];
                  $tabRows = myNumRow("SELECT * FROM ". $tab);
                  echo "<td>" . $tabRows . "</td>";
                }
                ?>
                </tr>
              </table>
            </div>
          </div>
        </div>
    </div>
  </article>

  <div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Data Pengguna</h1>
      <?php if ($u['akses']=="Superuser"){ ?>
      <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdropLive">
          <span data-feather="user-plus" class="feather-15"></span>
          Pengguna Baru
        </button>
      </div>
      <?php }  ?>
    </div>
    <!-- Menampilkan data User -->
    <div class="table-responsive">
      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Nama</th>
            <th scope="col">Bagian</th>
            <th scope="col">Poliklinik</th>
            <th scope="col">Akses</th>
            <th scope="col">User Info</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
          <?php 
          $admin = myquery("SELECT * FROM user");
          foreach($admin as $a) : 
            $id = str_pad($a['id'], 3, 'U0', STR_PAD_LEFT);
          ?>
            <td><?php echo $id ?></td>
            <td><?php echo $a['uname'] ?></td>
            <td><?php echo $a['nama'] ?></td>
            <td><?php echo $a['bagian'] ?></td>
            <td><?php echo $a['poli'] ?></td>
            <td><?php echo $a['akses'] ?></td>
            <td><?php echo $a['ket'] ?></td>
            <td>
              <?php if ($u['akses']=="Superuser"){ ?>
              <a onclick="if(confirm('Apakah anda yakin akan menghapus data dengan ID : <?php echo $a['id']; ?> ??')){ location.href='functions.php?del_user=<?php echo $a['id']; ?>' }"><button id="del_user" class="btn btn-sm btn-danger float-md-end" <?php if($a['bagian']=="Programmer"){echo "disabled";} ?>><span class="feather-15" data-feather="trash-2"></span></button></a>
              <?php } ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Modal Entri Data-->
    <div class="modal fade" id="staticBackdropLive" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLiveLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLiveLabel">Tambah Pengguna Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form role="form" action="" method="post">
              <div class="mb-2">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" class="form-control form-control-sm" name="name" required>
              </div>
              <div class="mb-2">
                <label class="form-label" for="name">Bagian</label>
                <select type="text" class="form-select form-select-sm" name="bagian" id="bagian" onchange="myFunction()">
                  <option value="-">.. pilih ..</option>
                  <option>RM</option>
                  <option>Admin</option>
                  <option>Pendaftaran</option>
                  <option>Farmasi</option>
                  <option>Pemeriksa</option>
                  <option>Pengawas</option>
                </select>
              </div>
              <div class="mb-2" id="myDIV" style="display:none">
                <label class="form-label" for="poli">Poliklinik</label>
                <select type="text" class="form-select form-select-sm" name="poli" required>
                  <option value="-">.. pilih ..</option>
                  <option>Umum</option>
                  <option>KIA</option>
                  <option>Hypnotherapy</option>
                </select>
              </div>
              <script>
                function myFunction() {
                  var bag = document.getElementById("bagian");
                  var x = document.getElementById("myDIV");
                  if(bag.value == "Pemeriksa") {
                    x.style.display = "block";
                  }else{
                    x.style.display = "none";
                  }
                }
              </script>
              <div class="mb-2">
                <label class="form-label" for="uname">Username</label>
                <input type="text" class="form-control form-control-sm" name="uname" id="uname" required>
                <div class="invalid-feedback">Username Sudah Terdaftar ..</div>
              </div>
              <div class="mb-2">
                <label class="form-label" for="pass">Password</label> 
                <input type="password" class="form-control form-control-sm" name="pass" id="pass" placeholder="Ketik Password .." required>
              </div>
              <div class="mb-2">
                <input type="password" class="form-control form-control-sm" name="repass" id="repass" placeholder="Ulangi password .." onkeyup="changeFunction()">
                <div class="invalid-feedback">Password tidak sama ..</div>
                <div class="valid-feedback">Password sama ..</div>
              </div>
              <div class="mb-2">
                <label class="form-label" for="akses">Akses</label>   
                <select class="form-select form-select-sm" name="akses" required>
                  <option value="-">.. pilih ..</option>
                  <option value="User">USER</option>
                  <option value="Superuser">SUPERUSER</option>
                </select>
              </div>
              <div class="mb-2">
                <label class="form-label" for="ket">User Info</label>
                <input type="text" class="form-control form-control-sm" name="ket" id="ket" required>
              </div>
              <div class="modal-footer">  
                <button type="submit" id="submit" name="registrasi" id="registrasi" class="btn btn-success" disabled>Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
              <script>    
                var btn = document.getElementById('submit');
                var dis = document.createAttribute('disabled');
                var pas = document.getElementById('pass');
                var rpas = document.getElementById('repass');
                // fungsi cek password
                function changeFunction(){  
                  if (rpas.value !== pas.value){
                    rpas.className = "form-control form-control-sm is-invalid";
                    btn.setAttributeNode(dis);
                  }else if (rpas.value == pas.value){
                    rpas.className = "form-control form-control-sm is-valid";
                    if (rpas.value == pas.value && uname.classList.contains('is-valid')){
                      btn.removeAttribute('disabled');
                    }
                  }
                };  
                // ajax cek username
                var uname = document.getElementById('uname');
                uname.addEventListener('keyup', function(){
                  var xhr = new XMLHttpRequest();
                  xhr.onreadystatechange = function(){
                      if( xhr.readyState == 4 && xhr.status == 200 ){
                          uname.className = xhr.responseText;
                          console.log(uname.className);
                      }
                  }
                  xhr.open('GET', 'ajax/validasi.php?user=' + uname.value, true);
                  xhr.send();
                  if(uname.classList.contains('is-invalid')){
                    btn.setAttributeNode(dis);
                  }else if(rpas.value == pas.value && uname.classList.contains('is-valid')){
                    btn.removeAttribute('disabled');
                  }
                });
              </script>
            </form>
          </div>
        </div>
      </div>
    </div>    
  </div>
  <br>
</main>
<!-- <script src="../assets/js/Chart.min.js"></script>
<script src="chart-data.js"></script> -->
<script>
    // AJAX KOLOM USER-SQL EDIT
    var tab = document.getElementById('tabel');
    var grup = document.getElementById('grup');
    // var kon = document.getElementById('kondisi');
    tab.addEventListener('change', function(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if( xhr.readyState == 4 && xhr.status == 200 ){
                grup.innerHTML = xhr.responseText;
            }
        }
        xhr.open('GET', 'ajax/userSql.php?edit=' + tab.value, true);
        xhr.send();
    });
    function generateQuery(){
      var kol = document.getElementById('kolom');
      var kon = document.getElementById('kondisi').value;
      var baru = document.getElementById('newValue');
      var lama = document.getElementById('oldValue').value;
      var opsi = document.getElementById('opsi').value;
      var dis = document.createAttribute('disabled');
      if(opsi=="Update"){
        document.getElementById('query').value = "UPDATE " + tab.value + " SET " + kol.value + "='" + baru.value + "' WHERE " + kon + "='" + lama + "'";
        kol.removeAttribute('disabled');
        baru.removeAttribute('disabled');
      }else if(opsi=="Delete"){
        document.getElementById('query').value = "DELETE FROM " + tab.value + " WHERE " + kon + "='" + lama + "'";
        kol.setAttributeNode(dis);
        baru.setAttributeNode(document.createAttribute('disabled'));
      }
    }
  </script>