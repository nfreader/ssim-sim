<?php

require_once('header.php');

?>

<?php 

  if(empty($_GET['spob'])) {
    die('No port specified');
  }
  if (!empty($_GET['spawncommod'])) {
    $commod = new commod();
    echo $commod->spawncommods(filter_input(INPUT_GET,'spob',FILTER_SANITIZE_NUMBER_INT));
  }
  $spob = filter_input(INPUT_GET,'spob',FILTER_SANITIZE_NUMBER_INT);
  $spob = new spob($spob,TRUE);

?>

<div class="page-header">
  <h1><?php echo $spob->name;?>
    <small>In the <?php echo $spob->parentname;?> system</small>
  </h1>
</div>

<div class="row">
  <div class="col-md-3">
    <h2><?php echo $spob->techlevel;?><br><small>Techlevel</small></h2>
  </div>
  <div class="col-md-3">
    <h2><?php echo $spob->fulltype;?><br><small>Port type</small></h2>
  </div>
  <div class="col-md-3">
    <h2>
      <?php echo govtLabel($spob->govtname,$spob->govtiso,$spob->govtid);?>
    <?php if($spob->govtseat == true) : ?>
      <br><small>Government Seat</small>
    <?php else : ?>
      <br><small>Government</small>
    <?php endif; ?>
    </h2>
  </div>
  <div class="col-md-3">
    <h2>
      <?php echo credits(fuelcost($spob->techlevel, $spob->type));?><br>
      <small>Fuel Cost (per unit)</small>
    </h2>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <h2>
      <code><?php echo hexprint($spob->name.$spob->parentname);?></code><br>
      <small>Bluespace Node</small>
    </h2>
  </div>
</div>

<div class="page-header">
  <h2>Available Commodities</h2>
</div>
<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Tons Available</th>
      <th>Cost / ton</th>
    </tr>
  </thead>
  <tbody>
  <?php if (!$spob->commods) : ?>
    <tr>
      <td colspan="3">No commodities. <a href="?spob=<?php echo $spob->id;?>&spawncommod=true">Spawn?</a></td>
    </tr>
  <?php else : ?>
  <?php foreach ($spob->commods as $commod) : ?>
    <tr class='commod commod-<?php echo $commod->type;?>'>
      <td>
        <a href='commod-list.php#<?php echo $commod->id;?>'>
          <?php echo $commod->name;?>
        </a>
      </td>
      <td><?php echo $commod->supply;?></td>
      <td><?php echo credits($commod->cost);?></td>
    </tr>
  <?php endforeach; endif;?>
  </tbody>
</table>

<?php

require_once('footer.php');
