<?php
include('inc/nav.php');

$sql = "SELECT COUNT(id) FROM carnet";
$query = $pdo->prepare($sql);
$query->execute();
$count_carnet = $query->fetchColumn();

$sql = "SELECT COUNT(id) FROM carnet_vaccin";
$query = $pdo->prepare($sql);
$query->execute();
$count_carnet_vaccin = $query->fetchColumn();

$sql = "SELECT COUNT(id) FROM users";
$query = $pdo->prepare($sql);
$query->execute();
$count_user = $query->fetchColumn();

$sql = "SELECT COUNT(id) FROM vaccin";
$query = $pdo->prepare($sql);
$query->execute();
$count_vaccin = $query->fetchColumn();


$sql = "SELECT MONTH(created_at) as month, COUNT(id) as count FROM users GROUP BY MONTH(created_at)";
$query = $pdo->prepare($sql);
$query->execute();
$data_graph_result = $query->fetchAll(PDO::FETCH_ASSOC);

$data_graph = [];

foreach ($data_graph_result as $row) {
  $data_graph[$row['month']] = $row['count'];
}

$sql = "SELECT nom, nb_utilisation FROM vaccin";
$query = $pdo->prepare($sql);
$query->execute();
$util_vaccin = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">book</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Nombre de carnet</p>
            <h4 class="mb-0  mt-1"><?php echo $count_carnet ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">check</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize"> vaccin fait</p>
            <h4 class="mb-0  mt-1"><?php echo $count_carnet_vaccin ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">person</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Nombre de compte</p>
            <h4 class="mb-0  mt-1"><?php echo $count_user ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">

        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 ">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">vaccines</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Nombre de vaccin</p>
            <h4 class="mb-0 mt-1"><?php echo $count_vaccin ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">

        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid py-4">
  <!-- Your existing HTML code here -->

  <div class="col-lg-4 mt-4 mb-3">
    <div class="card z-index-2">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
          <div class="chart">
            <canvas id="registrationChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h5 class="mb-0 ">Nombre d'inscrit par mois</h5>
        <!-- <p class="text-sm ">Last Campaign Performance</p> -->
        <hr class="dark horizontal">
      </div>
    </div>
  </div>
</div>
<div class="col-lg-4 col-md-6 mt-4 mb-4  ">
  <div class="card z-index-2 ">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent ">
      <div class="bg-gradient-dark shadow-dark  border-radius-lg py-3 pe-1">
        <div style="width: 80%; margin: auto;">
          <canvas id="vaccineUsageChart" width="auto" height="auto"></canvas>
        </div>
      </div>
      <div class="card-body">
        <h6 class="mb-0 ">Nombre d'utilisation par vaccin</h6>
        <!-- <p class="text-sm ">Last Campaign Performance</p> -->
        <hr class="dark horizontal">
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      // Use the data obtained from PHP
      var data_graph = <?php echo json_encode($data_graph); ?>;

      // Convert PHP data to JavaScript arrays
      var months = Object.keys(data_graph).map(function(month) {
        // Convert the numeric month to a month name
        var monthNames = [
          "January", "February", "March", "April", "May", "June", "July",
          "August", "September", "October", "November", "December"
        ];
        return monthNames[parseInt(month) - 1];
      });

      var counts = Object.values(data_graph);

      // Create a bar chart using Chart.js
      var ctx = document.getElementById('registrationChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: months,
          datasets: [{
            label: 'Registrations per Month',
            data: counts,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(255, 255, 255, 1)',
            hoverBackgroundColor:'rgba(190, 190, 190, 1)',
            Color: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>

    <script>
      // Use the data obtained from PHP
      var util_vaccin = <?php echo json_encode($util_vaccin); ?>;

      // Convert PHP data to JavaScript arrays
      var labels = util_vaccin.map(item => item.nom);
      var counts = util_vaccin.map(item => item.nb_utilisation);

      // Create a bar chart using Chart.js
      var ctx = document.getElementById('vaccineUsageChart').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Vaccine Usage',
            data: counts,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>


    <?php
    include('inc/reglage.php');
    ?>