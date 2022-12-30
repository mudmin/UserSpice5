<div class="card dash-card" data-id="<?=$widgetName?>" id="<?=$widgetName?>-card">
  <div class="card-header" id="<?=$widgetName?>-card-header">
    <span class="collapseCard" data-card="<?=$widgetName?>" id="<?=$widgetName?>-caret"><i class="fa fa-caret-down"></i></span>
    <span class="card-title-text">Most Active Users</span>
    <span class="float-end">
      <i class="fa-solid fa-grip ps-2 grippy"></i>
    </span>
  </div>
  <div class="card-body" id="<?=$widgetName?>-card-body">
  <canvas id="myChart"></canvas>
</div>
</div>
<?php
global $chartsLoaded;
if($chartsLoaded !="true"){ ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php }
$top = $db->query("SELECT id, fname, lname, logins FROM users ORDER BY logins DESC LIMIT 6")->results(true);
shuffle($top);
$labels = "";
$data = "";
foreach($top as $t){
  $labels .= "'".substr($t['fname'],0,1).". ".$t['lname']."',";
  $data .= "'".$t['logins']."',";
}

?>

<script>
  const ctx = document.getElementById('myChart');
  ctx.height = 100;
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?=rtrim($labels)?>],
      datasets: [{
        label: '# of Logins',
        data: [<?=rtrim($data)?>],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
