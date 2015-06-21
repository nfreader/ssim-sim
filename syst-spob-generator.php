<?php

require_once('header.php');
?>

<div class="page-header">
  <h1>Generating 100 systems and ports</h1>
</div>
<div class="row">

<div class="col-md-3">

<h3>System and Port list</h3>

<?php 

define('NUMBER_OF_SYSTS_TO_GENERATE',50);
define('GALAXY_MAX_X',512);
define('GALAXY_MAX_Y',512);
define('GOVT_DISTRIBUTION',25);
define('INDIE_GOVT_ID',1);
define('MAX_PORTS_PER_SYSTEM',5);
define('PORT_DISTRIBUTION',65);
define('PLANET_DISTRIBUTION',65);
define('MOON_DISTRIBUTION',17.5);
define('STATION_DISTRIBUTION',17.5);

$techlevels = array(
  array(10,10,7,5,5),
  array(9,8,7,6,5),
  array(7,6,5,5,4),
  array(5,4,3,3,2),
  array(4,3,2,2,1)
);

$i = 1;
$unpopulatedsystems = 0;
$totalports = 0;
$totalplanets = 0;
$totalmoons = 0;
$totalstations = 0;
while ($i <= NUMBER_OF_SYSTS_TO_GENERATE) {
  $x = floor(rand(0,GALAXY_MAX_X));
  $y = floor(rand(0,GALAXY_MAX_Y));
  
  require_once('inc/arrays.php');
  
  if(floor(rand(0,100)) > PORT_DISTRIBUTION) {
    //System is uninhabited
    switch(floor(rand(0,1))) {
      case 0:
        $prefix = pick($systPrefixes)." ";
        break;
  
      case 1:
        $prefix = '';
        break;
    }
    $sysname = pick($systNames);
    echo "<strong>$prefix$sysname</strong> ($x,$y) (Unpopulated)<br>";
    $system = array(
      'name'=>"$prefix$sysname",
      'coord_x'=>intval($x),
      'coord_y'=>intval($y)
    );
    $systems[] = $system;
    $unpopulatedsystems++;
  } else {
    //System is inhabited!
    $sysname = pick($systNames);
    echo "<strong>$sysname</strong> ($x,$y)<br>";
    $system = array(
      'name'=>"$sysname",
      'coord_x'=>intval($x),
      'coord_y'=>intval($y)
    );
    $systems[] = $system;
    $numports = floor(rand(1,MAX_PORTS_PER_SYSTEM));
    while ($numports >= 1) {
      $techlevel = pick($techlevels[$numports-1]);
      $porttypechance = floor(rand(0,100));
      switch(true) {
        case ($porttypechance <= PLANET_DISTRIBUTION): //Port is a planet
          $portname = pick($systNames)." (Planet)";
          $totalplanets++;
          break;

        case ($porttypechance <= PLANET_DISTRIBUTION + MOON_DISTRIBUTION): //Port is a moon
          $portname = pick($systNames)." (Moon)";
          $totalmoons++;
          break;

        case ($porttypechance > STATION_DISTRIBUTION - 100): //Port is a station
          $prefix = pick($stationAdjectives);
          $stationname = pick($stationNames);
          switch(floor(rand(0,3))) {
            case 0:
              $suffix = pick($phoneticAlphabet);
              break;

            case 1:
              $suffix = pick($greekAlphabet);
              break;

            case 2:
              $suffix = pick($romanNumerals);
              break;

            case 3:
              $suffix = '';
              break;
          }
        $portname = "$prefix $stationname $suffix (Station)";
        $totalstations++;
      }
      echo "<em>$portname</em> ($techlevel)<br>";
      $totalports++;
      $numports--;
    }
  }
  $i++;
}

?>

</div>
<div class="col-md-8">
<h3>Statistics</h3>
<?php 
echo "$unpopulatedsystems out of ".NUMBER_OF_SYSTS_TO_GENERATE." systems are unpopulated<br>"; 
echo "$totalports ports in total (averaging ".round($totalports/(NUMBER_OF_SYSTS_TO_GENERATE-$unpopulatedsystems),2)." ports per system)";

$populatedwidth = ((NUMBER_OF_SYSTS_TO_GENERATE - $unpopulatedsystems)/NUMBER_OF_SYSTS_TO_GENERATE) * 100;
$unpopulatedwidth = ($unpopulatedsystems/NUMBER_OF_SYSTS_TO_GENERATE) * 100;

$planetwidth = ($totalplanets/$totalports) * 100;
$moonwidth = ($totalmoons/$totalports) * 100;
$stationwidth = ($totalstations/$totalports) * 100;
?>

<h3>Populated vs. Unpopulated systems</h3>
<div class="progress">
  <div class="progress-bar progress-bar-success" style="width:<?php echo $populatedwidth;?>%">
    <span><?php echo NUMBER_OF_SYSTS_TO_GENERATE - $unpopulatedsystems;?> populated systems</span>
  </div>
  <div class="progress-bar progress-bar-warning" style="width:<?php echo $unpopulatedwidth;?>%">
    <span><?php echo $unpopulatedsystems;?> unpopulated systems</span>
  </div>
</div>

<h3>Port distribution</h3>
<div class="progress">
  <div class="progress-bar progress-bar-success" style="width: <?php echo $planetwidth;?>%">
    <span><?php echo $totalplanets;?> Planets</span>
  </div>
  <div class="progress-bar progress-bar-primary" style="width: <?php echo $moonwidth;?>%">
    <span><?php echo $totalmoons;?> Moons</span>
  </div>
  <div class="progress-bar progress-bar-info" style="width: <?php echo $stationwidth;?>%">
    <span><?php echo $totalstations;?> Stations</span>
  </div>
</div>

<h3>Map</h3>
<script> var systems = <?php echo json_encode($systems);?>;</script>
<script src="assets/js/map.js"></script>
<canvas id="temp-syst-map" width="641" height="641" style="background: white; margin: 0px auto;"></canvas>


</div>
</div>

<?php

require_once('footer.php');
