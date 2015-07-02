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
  <div class="col-sm-4">
    <h2> 
      <a href='viewpilot.php?pilot=<?php echo $vessel->pilot;?>'>
      <?php echo $vessel->pilotname;?>
    </a><br>
    <small>Registrant</small>
    </h2>
  </div>
  <div class="col-sm-4">
    <h2>
      <code><?php echo vesselregistration($vessel->registration);?></code><br>
      <small>Registration</small>
    </h2>
  </div>
  <div class="col-sm-4">
    <h2>
      <span class='label label-<?php echo vesselstatus($vessel->status)['class'];?>'>
        <?php echo vesselstatus($vessel->status)['status'];?>
      </span><br>
    <small>Status</small></h2>
  </div>
</div>

<div class="row">
<div class="col-sm-6">
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
      <td><?php echo $cargo->name;?></td>
      <td><?php echo singular($cargo->tons,'ton','tons');?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<div class="col-sm-6">
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
</div>
<?php 
echo tableHeader(array(
  'shields',
  'armor',
  'accel',
  'turn',
  'mass',
  'Evasion Chance',
  'Outfits'
));
  /*
  Basically, we're passing the ship array to this function that will modify
  it and...
  */
  $outfits = parseoutfits(json_decode(json_encode($vessel,JSON_NUMERIC_CHECK),true));
  /*
  Return it! 
  */
  $ship = $outfits['Ship'];

  //Calculate evasion changes based on outfits that don't modify ship values
  $evasion = evasionChance($ship['accel'],
    $ship['turn'],
    $ship['mass'],
    $outfits['Evasion']);

  /*
  Just fluff for the table here
  */

  if ($ship['shields'] != $ship['Baseshields']) {
    $shields = $ship['shields']."<br><span class='label label-primary'>";
    $shields.= "(".$ship['Baseshields']." base)</span>";
  } else {
    $shields = $ship['shields'];
  }

  if ($ship['armor'] != $ship['Basearmor']) {
    $armor = $ship['armor']."<br><span class='label label-primary'>";
    $armor.= "(".$ship['Basearmor']." base)";
  } else {
    $armor = $ship['armor'];
  }

  if ($ship['accel'] != $ship['Baseaccel']) {
    $accel = $ship['accel']."m/s<sup>2</sup><br><span class='label label-primary'>";
    $accel.= "(".$ship['Baseaccel']."m/s<sup>2</sup> base)";
  } else {
    $accel = $ship['accel']."m/s<sup>2</sup>";
  }

  if ($ship['turn'] != $ship['Baseturn']) {
    $turn = $ship['turn']."m/s<sup>2</sup><br><span class='label label-primary'>";
    $turn.= "(".$ship['Baseturn']."m/s<sup>2</sup> base)";
  } else {
    $turn = $ship['turn']."m/s<sup>2</sup>";
  }

  if ($ship['mass'] != $ship['Basemass']) {
    $mass = $ship['mass']." tons<br><span class='label label-primary'>";
    $mass.= "(".$ship['Basemass']." base)";
  } else {
    $mass = $ship['mass']." tons";
  }

  if ($evasion['Modified'] != $ship['BaseEvasion']) {
    $evasion = $evasion['Modified']."%<br><span class='label label-primary'>";
    $evasion.= "(".$ship['BaseEvasion']."% base)";
  } else {
    $evasion = $ship['BaseEvasion']."%";
  }

  echo tableCells(array(
    $shields,
    $armor,
    $accel,
    $turn,
    $mass,
    $evasion,
    $outfits['Output']
  ));
echo tableFooter();
var_dump($ship);
?>

<?php

require_once('footer.php');
