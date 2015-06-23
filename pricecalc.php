<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Spawn Commodities</h1>
</div>

<?php 

$commod = new commod();
$commods = $commod->listCommods();

$spob = new spob();
$spobs = $spob->listSpobs();

foreach ($spobs as $spob) {
  foreach ($commods as $commod) {
    if ($commod->type == 'C' && $spob->techlevel >= $commod->techlevel) {
      echo "Giving $spob->name some $commod->name<br>";
    }
  }
}
?>

<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Tons</th>
      <th>Number of ports</th>
      <th>Base Cost</th>
      <th>Base Supply</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($spobs as $spob) : ?>
    <tr><td colspan=5><?php echo $spob->name;?></td></tr>
<?php foreach ($commods as $commod) : ?>
  <?php 
  if ($commod->techlevel <= $spob->techlevel && $commod->type == 'C') :
  $supplyLowerBound = $commod->basesupply-($commod->basesupply*.3);
  $supplyUpperBound = $commod->basesupply+($commod->basesupply*.3);
  $supply = floor(rand($supplyLowerBound,$supplyUpperBound));
  $cost = $commod->basecost * ($commod->basecost / $supply);
  ?>
    <tr>
      <td><?php echo $commod->name;?></td>
      <td><?php echo singular($supply,'ton','tons');?></td>
      <td><?php echo credits($cost)." per ton";?></td>
    </tr>
<?php endif; endforeach; endforeach; ?>
  </tbody>
</table>


<?php


require_once('footer.php');
