<?php 
  include 'sidebar.php';
?>
<main>
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3">
      <h1 class="h2">Dashboard</h1>
  </div>
  <br>
  <div class="row">
    <!-- Memanggil Grafik Poli Umum -->
    <div class="col-12 col-lg-4">
      <div class="card">
        <div class="card-header">
          <div class="h-100 justify-content-between no-gutters row">
            <div class="col-xxl pr-2 col-5 col-sm-6">
              <h5>Poli Umum</h5>
              <div class="mt-3">
                <?php 
                $now=date('Y-m-d');
                $chekU = myNumRow("SELECT * FROM daftar WHERE tanggal='$now' AND poli='Umum'");  
                $doneU = myNumRow("SELECT * FROM periksa INNER JOIN daftar ON periksa.id_daftar=daftar.id WHERE tanggal='$now' AND daftar.poli='Umum'");
                $waitU = $chekU-$doneU;
                ?>  
                <div class="d-flex justify-content-between">
                  <span><?= $doneU; ?> Pasien Selesai</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span><?= $waitU; ?> Menunggu</span>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <div class="position-relative">
                <canvas id="umum" width="120%" height="100"></canvas>
              </div>
            </div>
            <center><h1><?= $chekU; ?></h1></center>
          </div>
        </div>
      </div>
    </div>
    <!-- Memanggil Grafik Poli KIA -->
    <div class="col-12 col-lg-4">
      <div class="card">
        <div class="card-header">
          <div class="h-100 justify-content-between no-gutters row">
            <div class="col-xxl pr-2 col-5 col-sm-6">
              <h5>Poli KIA</h5>
              <div class="mt-3">
                <?php 
                $chekK = myNumRow("SELECT * FROM daftar WHERE tanggal='$now' AND poli='KIA'");  
                $doneK = myNumRow("SELECT * FROM periksa INNER JOIN daftar ON periksa.id_daftar=daftar.id WHERE tanggal='$now' AND daftar.poli='KIA'");
                $waitK = $chekK-$doneK;
                ?> 
                <div class="d-flex justify-content-between">
                  <span><?= $doneK; ?> Pasien Selesai</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span><?= $waitK; ?> Menunggu</span>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <div class="position-relative">
                <canvas id="kia" width="120%" height="100"></canvas>
              </div>
            </div>
            <center><h1><?= $chekK; ?></h1></center>
          </div>
        </div>
      </div>
    </div>
    <!-- Memanggil Grafik Poli Hipno -->
    <div class="col-12 col-lg-4">
      <div class="card">
        <div class="card-header">
          <div class="h-100 justify-content-between no-gutters row">
            <div class="col-xxl pr-2 col-5 col-sm-6">
              <h5>Hypnotherapy</h5>
              <div class="mt-3">
                <?php 
                $chekH = myNumRow("SELECT * FROM daftar WHERE tanggal='$now' AND poli='Hypnotherapy'");  
                $doneH = myNumRow("SELECT * FROM periksa INNER JOIN daftar ON periksa.id_daftar=daftar.id WHERE tanggal='$now' AND daftar.poli='Hypnotherapy'");
                $waitH = $chekH-$doneH;
                ?>  
                <div class="d-flex justify-content-between">
                  <span><?= $doneH; ?> Pasien Selesai</span>
                </div>
                <div class="d-flex justify-content-between">
                  <span><?= $waitH; ?> Menunggu</span>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <div class="position-relative">
                <canvas id="hipno" width="120%" height="100"></canvas>
              </div>
            </div>
            <center><h1><?= $chekH; ?></h1></center>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <!-- Memanggil Grafik Bar Pasien -->
    <div class="col-12 col-lg-7">
      <div class="card">
        <div class="card-header">
          <h5>Jumlah Pasien</h5>
          <canvas class="my-4 w-100" id="jumChart" width="100%" height="50px"></canvas>
        </div>
      </div>
    </div>
    <!-- Memanggil Grafik Pie Pasien -->
    <div class="col-12 col-lg-5">
      <div class="card">
        <div class="card-header">
          <h5>Jenis Kelamin</h5>
          <canvas class="my-4 w-100" id="jkChart" width="100%" height="73px"></canvas>
        </div>
      </div>
    </div>
  </div>
</main>
<br>

<?php
$d1 = date("Y-m-d");
$d2 = date("Y-m-d", strtotime("-1 days"));
$d3 = date("Y-m-d", strtotime("-2 days"));
$d4 = date("Y-m-d", strtotime("-3 days"));
$d5 = date("Y-m-d", strtotime("-4 days"));
$d6 = date("Y-m-d", strtotime("-5 days"));
$d7 = date("Y-m-d", strtotime("-6 days"));
$h1 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d1'");
$h2 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d2'");
$h3 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d3'");
$h4 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d4'");
$h5 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d5'");
$h6 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d6'");
$h7 = myNumRow("SELECT * FROM daftar WHERE tanggal='$d7'");
?>
<script src="../assets/js/chart.min.js"></script>
<script type="text/javascript">
  // Data Grafik Bar Pasien
  var ctx = document.getElementById('jumChart')
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        '<?= date("l", strtotime("-6 days")); ?>',
        '<?= date("l", strtotime("-5 days")); ?>',
        '<?= date("l", strtotime("-4 days")); ?>',
        '<?= date("l", strtotime("-3 days")); ?>',
        '<?= date("l", strtotime("-2 days")); ?>',
        '<?= date("l", strtotime("-1 days")); ?>',
        '<?= date("l"); ?>'
      ],
      datasets: [{
        label: 'Pasien',
        data: [
          <?= $h7; ?>,
          <?= $h6; ?>,
          <?= $h5; ?>,
          <?= $h4; ?>,
          <?= $h3; ?>,
          <?= $h2; ?>,
          <?= $h1; ?>
        ],
        backgroundColor: '#95DAC1',
        borderColor: 'transparent',
        borderWidth: 1,
        pointBackgroundColor: '#95DAC1'
      }]
    },
    options: {
      scales: {
        yAxes: [{
          id: 'A',
          type: 'linear',
          position: 'left',
          ticks: {
            beginAtZero: false
          }
        }]
      },
    }
  });
  // Data Grafik Pie Pasien
  <?php 
  $men = myNumRow("SELECT * FROM daftar WHERE tanggal='$now' AND jk='Laki-laki'");
  $wom = myNumRow("SELECT * FROM daftar WHERE tanggal='$now' AND jk='Perempuan'");
  ?>
  var ctz = document.getElementById('jkChart')
  var myChart = new Chart(ctz, {
    type: 'pie',
    data: {
      labels: [ 'Laki-laki', 'Perempuan' ],
      datasets: [{
        data: [ <?= $men; ?> , <?= $wom; ?> ],
        backgroundColor: [ '#6F69AC', '#FD6F96' ]
      }]
    },
    plugins: {
      legend: false,
    }
  });
  // Data Grafik Donat Poli Umum
  var cta = document.getElementById('umum')
  var yourChart = new Chart(cta, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [ <?= $doneU; ?> , <?= $waitU; ?> ],
        backgroundColor: [ '#95DAC1', '#fff' ]
      }]
    }
  });
  // Data Grafik Donat Poli KIA
  var cta = document.getElementById('kia')
  var yourChart = new Chart(cta, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [ <?= $doneK; ?> , <?= $waitK; ?> ],
        backgroundColor: [ '#FFEBA1', '#fff' ]
      }]
    }
  });
  // Data Grafik Donat Poli Hypnotherapy
  var cta = document.getElementById('hipno')
  var yourChart = new Chart(cta, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [ <?= $doneH; ?> , <?= $waitH; ?> ],
        backgroundColor: [ '#FD6F96', '#fff' ]
      }]
    }
  });
</script>