<?php
require_once('inc/config.php');
?>

<?php 

  if(empty($_GET['commod'])) {
    die('No Commodity specified');
  }
  $commod = new commod();
  $commod = $commod->viewcommod(filter_input(INPUT_GET,'commod',FILTER_SANITIZE_NUMBER_INT));

  ?>

<div class='page-header'>
  <h1><?php echo $commod->name;?></h1>
</div>

<div class="row">
  <div class="col-md-3">
    <h1><?php echo $commod->techlevel;?><br>
    <small>Techlevel</small>
    </h1>
  </div>
  <div class="col-md-3">
    <h1><?php echo credits($commod->avgcost);?><br>
    <small>Average Cost</small>
    </h1>
  </div>
  <div class="col-md-3">
    <h1><?php echo singular($commod->avgsupply,'ton','tons');?><br>
    <small>Average Supply</small>
    </h1>
  </div>
  <div class="col-md-3">
    <h1><?php echo singular(count($commod->spobs),'port','ports');?><br>
    <small>Ports Selling</small>
    </h1>
  </div>
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

    <?php if (!$commod->spobs) : ?>
      <tr>
        <td colspan="3">No ports.</td>
      </tr>
    <?php else : ?>
    <?php foreach ($commod->spobs as $spob) : ?>
      <tr class='commod commod-<?php echo $commod->type;?>'>
        <td><?php echo spoblink($spob->id, $spob->name);?></td>
        <td><?php echo singular($spob->supply,'ton','tons');?></td>
        <td><?php echo credits($spob->cost);?></td>
      </tr>
    <?php endforeach; endif;?>
    </tbody>
  </table>
