<?php
$wide = true;
require_once('header.php');

?>

<?php 

  if(empty($_GET['vessel'])) {
    die('No vessel specified');
  }
  $vessel = filter_input(INPUT_GET,'vessel',FILTER_SANITIZE_NUMBER_INT);
  $vessel = new vessel($vessel,TRUE,FALSE);
?>

<div class="page-header">
  <h1><?php echo $vessel->name;?>
    <small>
      a <?php echo $vessel->shipwright;?> <?php echo $vessel->shipname;?> <?php echo $vessel->class;?>
    </small>
    <?php if ($vessel->image): ?>
      <img class='pull-right' src="assets/img/ships/<?php echo $vessel->image;?>.png" />
    <?php endif; ?>
  </h1>
</div>

<div class="row">
  <div class="col-sm-3">
    <h2> 
      <a href='viewpilot.php?pilot=<?php echo $vessel->pilot;?>'>
      <?php echo $vessel->pilotname;?>
    </a><br>
    <small>Registrant</small>
    </h2>
  </div>
  <div class="col-sm-3">
    <h2>
      <code><?php echo vesselregistration($vessel->registration);?></code><br>
      <small>Registration</small>
    </h2>
  </div>
  <div class="col-sm-3">
    <h2>
      <span class='label label-<?php echo vesselstatus($vessel->status)['class'];?>'>
        <?php echo vesselstatus($vessel->status)['status'];?>
      </span><br>
    <small>Status</small></h2>
  </div>
  <div class="col-sm-3">
    <strong>Fuel tank</strong> (<?php echo "$vessel->fuel/$vessel->fueltank ".icon('square');?>)
    <div class="progress">
      <div class="progress-bar progress-bar-danger" style="width: <?php echo $vessel->fuelgraph;?>%"></div>
    </div>
    <strong>Shields</strong> <?php echo icon('magnet');?>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" style="width: <?php echo $vessel->shieldgraph;?>%"></div>
    </div>
    <strong>Armor</strong> <?php echo icon('th');?>
    <div class="progress">
      <div class="progress-bar progress-bar-warning" style="width: <?php echo $vessel->armorgraph;?>%"></div>
    </div>
  </div>
</div>

<div class="row">
<div class="col-sm-2">
<div class="page-header">
  <h2>Cargo</h2>
</div>

<table class='table table-condensed table-bordered'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($vessel->cargo as $cargo) : ?>
    <tr class="commod commod-<?php echo $cargo->type;?>">
      <td>
        <a href='commod-list.php#<?php echo $cargo->id;?>'>
          <?php echo $cargo->name;?>
        </a>
      </td>
      <td><?php echo singular($cargo->tons,'ton','tons');?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<div class="col-sm-4">
<div class="page-header">
  <h2>Outfits</h2>
</div>

<table class='table table-condensed table-bordered'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Subtype</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($vessel->outfits AS $outfit) : ?>
    <tr>
      <td><?php echo $outfit->name;?></td>
      <td><?php echo outfitType($outfit->type);?></td>
      <td><?php echo $outfit->subtype;?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>

<div class="col-md-6">
  <div class="page-header">
    <h2>Ship</h2>
  </div>

  <table class='table table-condensed table-bordered'>
    <tbody>
      <tr>
        <th>Acceleration</th>
        <td><?php echo $vessel->accel;?>m/s<sup>2</sup></td>
      </tr>
      <tr>
        <th>Turn Speed</th>
        <td><?php echo $vessel->turn;?>m/s<sup>2</sup></td>
      </tr>
      <tr>
        <th>Mass</th>
        <td><?php echo singular($vessel->mass,'ton','tons');?></td>
      </tr>
      <tr>
        <th>Shields</th>
        <td><?php echo "$vessel->shields ".icon('magnet');?></td>
      </tr>
      <tr>
        <th>Armor</th>
        <td><?php echo "$vessel->armor ".icon('th');?></td>
      </tr>
      <tr>
        <th>Evasion Chance</th>
        <td><?php echo $vessel->Evasion;?>%
        <?php if ($vessel->evasionModifier > 0) :?>
            <br><span class="label label-primary">
              <?php echo $vessel->baseEvasion;?>% base
            </span>
        <?php endif; ?></td>
      </tr>
      <tr>
        <th>Maximum Potential Firepower</th>
        <td><?php echo $vessel->firepower;?></td>
      </tr>
    </tbody>
  </table>

</div>

</div>

<?php

require_once('footer.php');
