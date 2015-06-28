<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Ship Parser</h1>
</div>

<?php

//$origships = $ships;

echo tableHeader(array(
  'Name',
  'shields',
  'armor',
  'accel',
  'turn',
  'mass',
  'Evasion Chance',
  'Outfits'
));
foreach($ships as $ship) {
  var_dump($ship);
  /*
  Basically, we're passing the ship array to this function that will modify
  it and...
  */
  $outfits = parseOutfits($ship);
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
    $ship['Name'],
    $shields,
    $armor,
    $accel,
    $turn,
    $mass,
    $evasion,
    $outfits['Output']
  ));
}
echo tableFooter();

require_once('footer.php');