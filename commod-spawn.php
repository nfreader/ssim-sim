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

$db = new database();
$db->query("INSERT INTO tbl_commodspob (spob, commod, supply, lastchange) VALUES
  (:spob,:commod,:supply,NOW())");

?>

<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Tons</th>
      <th>Cost / ton</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($spobs as $spob) : ?>
    <tr>
      <td colspan=3>
        <strong>
          <?php echo "$spob->name ($spob->techlevel)";?>
        </strong>
      </td>
    </tr>
<?php foreach ($commods as $commod) : ?>
  <?php 
  if ($commod->techlevel <= $spob->techlevel && $commod->type == 'C') :
  $supplyLowerBound = $commod->basesupply-($commod->basesupply*COMMOD_DISTRIBUTION);
  $supplyUpperBound = $commod->basesupply+($commod->basesupply*COMMOD_DISTRIBUTION);
  $supply = floor(rand($supplyLowerBound,$supplyUpperBound));
  //$cost = $commod->basecost * ($commod->basecost / $supply);
  $cost = commodCost($commod->basecost,$commod->techlevel,$spob->techlevel,$supply);
  ?>
    <tr>
      <td><?php echo $commod->name;?></td>
      <td><?php echo singular($supply,'ton','tons');?></td>
      <td><?php echo credits($cost)." per ton";?></td>
    </tr>

  <?php
    $array['commod'] = $commod->id;
    $array['spob'] = $spob->id;
    $array['supply'] = $supply;
    $commodspob[]= $array;
    $db->bind(':spob',$spob->id,PDO::PARAM_INT);
    $db->bind(':commod',$commod->id,PDO::PARAM_INT);
    $db->bind(':supply',$supply,PDO::PARAM_INT);
    try {
      $db->execute();
    } catch(Exception $e) {
      echo alert('Error: '.$e->getMessage(),2);
    }
  ?>

  <?php elseif ($commod->type == 'C' && $commod->techlevel > $spob->techlevel) : ?>
    <tr class='active'>
      <td colspan='3'>This port is too low-tech for <?php echo $commod->name;?></td>
    </tr>

<?php endif; endforeach; endforeach; ?>
  </tbody>
</table>

<?php var_dump(json_encode($commodspob,JSON_NUMERIC_CHECK)); ?>

<?php


require_once('footer.php');
