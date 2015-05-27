<?php

require_once('header.php');

/*
Welcome to the Space Sim combat simulator.

First off, let's get our attacking and defending ships

We'll allow users to input a ship in JSON format as a $_GET paramater. Don't 
worry about XSS just yet, we can deal with that at another time. I know, shut 
up. If no user input is present, we'll just 

TODO:
- Prevent malformed requests from screwing things up
- Verify integrity of JSON input

*/

if(isset($_GET['ATK'])) {
  $atk = json_decode($_GET['ATK']);
} else {
  $atk = $ships[0];
}

if(isset($_GET['DEF'])) {
  $def = json_decode($_GET['DEF']);
} else {
  $def = $ships[1];
}

/*
If no ships are provided by the user, we'll use a ship from the ships array
*/

/*
Ok, we're ready to start our battle loop! As always, we'll have to set some 
variables outside the loop.
*/

$tick = 0;
$results = array();
$results['attackerFires'] = 0;
$results['defenderFires'] = 0;

$atk['Position'] = 'Attacker';
$def['Position'] = 'Defender';

/*
And run our ships through parseOutfits() to get evasion chances
*/

$atk = parseOutfits($atk)['Ship'];
$def = parseOutfits($def)['Ship'];

$atk['Status'] = '';
$def['Status'] = '';

while(
  ($atk['Status'] != 'Destroyed' && $def['Status'] != 'Destroyed')
  && ($atk['Status'] != 'Fled' && $def['Status'] != 'Fled')
  ) {
  echo "<hr>";
  $tick++;
  if ($tick == 1) {
    $chanceFire = 1; //Attacker always gets the first shot
  } else {
    $chanceFire = floor(rand(1,4));
  }
  if ($atk['Damage'] == 0) { 
    /*
    Attacker has no weapons and therefore will always be on the defensive
    */
    $atk['Status'] = 'Evading';
    $def['Status'] = 'Attacking';
    $results = combatTick($def, $atk, $tick);
    $atk = $results['Def'];
    $def = $results['Atk']; 
  } elseif ($def['Damage'] == 0) {
    /*
    And vice versa...
    */
    $atk['Status'] = 'Attacking';
    $def['Status'] = 'Evading';
    $results = combatTick($atk, $def, $tick);
    $def = $results['Def'];
    $atk = $results['Atk'];
  } elseif ($atk['Damage'] == 0 && $def['Damage'] == 0) {
    /*
    Well this is dull. I don't even know what to do here.
    */
    return;
  } else {
    /*
    Both ships are armed so it's a cointoss
    */
    if ($chanceFire <= 2) {
      $atk['Status'] = 'Attacking';
      $def['Status'] = 'Evading';
      $results = combatTick($atk, $def, $tick);
      $def = $results['Def'];
      $atk = $results['Atk'];
      //echo $results['Output'];
    } else {
      $atk['Status'] = 'Evading';
      $def['Status'] = 'Attacking';
      $results = combatTick($def, $atk, $tick);
      $atk = $results['Def'];
      $def = $results['Atk'];
      //echo $results['Output'];
    }
  }
  echo $results['Result'];
  echo "<span class='label label-primary'>Attacker shields: ".$atk['Shields']."</span> <span class='label label-primary'>Attacker armor: ".$atk['Armor']."</span><br>";
  echo "<span class='label label-primary'>Defender shields: ".$def['Shields']."</span> <span class='label label-primary'>Defender armor: ".$def['Armor']."</span><br>";
}

echo "<hr>";
echo "<h3>Results</h3>";

var_dump($atk);
var_dump($def);


require_once('footer.php');
