<?php

$wide = true;

require_once('inc/config.php');

?>

<script src="https://cdnjs.com/libraries/chart.js"></script>

<?php

$commod = new commod();
$data = $commod->getcommodstatdata();

foreach($data as $json) {
  $array['data'] = json_decode($json->stats,TRUE);
  $array['timestamp'] = $json->timestamp;
  $masterarray[] = $array;
}

echo "<script> var statdata = ".json_encode($masterarray,JSON_NUMERIC_CHECK)."</script>";

?>
<canvas id="myChart" width="400" height="400"></canvas>

<script>

var chartdata = {}
var dates = [];
var datasets = [];
for(var i = statdata.length - 1; i>=0; i--) {
  dates.push(statdata[i].timestamp);
  console.log(statdata[i].timestamp);
  console.table(statdata[i].data);
  var data = [];
  for(var j = statdata[i].data.length - 1; j>=0; j--) {
    data.push(statdata[i].data[j].commodname);
    data.push(statdata[i].data[j].avgcost);
  }
  datasets.push(data);
}

chartdata.dates = dates;
chartdata.datasets = datasets;

console.log(chartdata);

//var ctx = document.getElementById("myChart").getContext("2d");
//var myLineChart = new Chart(ctx).Line(data, options);

</script>
