<?php

require_once('header.php');

//$origships = $ships;

echo tableHeader(array(
  'Name',
  'Shields',
  'Armor',
  'Accel',
  'Turn',
  'Mass',
  'Evasion Chance',
  'Outfits'
));
foreach($ships as $ship) {
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
  $evasion = evasionChance($ship['Accel'],
    $ship['Turn'],
    $ship['Mass'],
    $outfits['Evasion']);

  /*
  Just fluff for the table here
  */

  if ($ship['Shields'] != $ship['BaseShields']) {
    $shields = $ship['Shields']."<br><span class='label label-primary'>";
    $shields.= "(".$ship['BaseShields']." base)</span>";
  } else {
    $shields = $ship['Shields'];
  }

  if ($ship['Armor'] != $ship['BaseArmor']) {
    $armor = $ship['Armor']."<br><span class='label label-primary'>";
    $armor.= "(".$ship['BaseArmor']." base)";
  } else {
    $armor = $ship['Armor'];
  }

  if ($ship['Accel'] != $ship['BaseAccel']) {
    $accel = $ship['Accel']."m/s<sup>2</sup><br><span class='label label-primary'>";
    $accel.= "(".$ship['BaseAccel']."m/s<sup>2</sup> base)";
  } else {
    $accel = $ship['Accel']."m/s<sup>2</sup>";
  }

  if ($ship['Turn'] != $ship['BaseTurn']) {
    $turn = $ship['Turn']."m/s<sup>2</sup><br><span class='label label-primary'>";
    $turn.= "(".$ship['BaseTurn']."m/s<sup>2</sup> base)";
  } else {
    $turn = $ship['Turn']."m/s<sup>2</sup>";
  }

  if ($ship['Mass'] != $ship['BaseMass']) {
    $mass = $ship['Mass']." tons<br><span class='label label-primary'>";
    $mass.= "(".$ship['BaseMass']." base)";
  } else {
    $mass = $ship['Mass']." tons";
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