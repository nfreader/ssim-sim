<?php

function evasionChance($accel, $turn, $mass, $modifier = 1) {
  $actual = floor(($accel * $turn / $mass) * 5);
  $modified = $actual + $actual * ($modifier/100);
  $return['Actual'] = $actual;
  $return['Modified'] = $modified;
  return $return;
}



function parseOutfits($ship) {

  //So! 
  //Each ship is an array! That's pretty straightforward right? 
  //Ok! Outfits is an array of arrays! 
  //Those arrays are in the same scope as ship! 
  //Which means we can modify the main ship array values on an outfit by outfit
  //basis!

  $i = 0;
  $damage = 0;

  /*
  Unfortunately for us, there is no such thing as array_keys_exist, just
  array_key_exists. But that's not a problem because there are only a few
  possible ship values to modify. And the math is all the same.

  For reference, that math is:
  
    (start_val * modifier) + start_val
  
  and the only ship values we can modify are:
    shields
    armor
    accel
    turn
    mass
  
  We also want to go ahead and calculate the evasion and stick it back in the 
  main ship array since all of the values we're modifying will affect that.
  */

  $ship['BaseEvasion'] = evasionChance($ship['accel'],
    $ship['turn'],$ship['mass'])['Actual'];

  /* 
  Aaaaaand we'll go ahead and save the base starting points for our values so
  we can compare them later on.
  */

  $ship['Baseshields'] = $ship['shields'];
  $ship['Basearmor'] = $ship['armor'];
  $ship['Baseaccel'] = $ship['accel'];
  $ship['Baseturn'] = $ship['turn'];
  $ship['Basemass'] = $ship['mass'];

  /*
  Set some starting points...
  */

  $shieldMod = 0;
  $armorMod = 0;
  $accelMod = 0;
  $turnMod = 0;
  $massMod = 0;

  /*
  Since some outfits can modify evasion directly, we'll need a starting point 
  for that as well.
  */

  $return['Evasion'] = 0;

  $return['Damage'] = 0;

  $content = "<ul class='list-unstyled'>";
  foreach ($ship['outfits'] as $outf) {

    /*
      Now that we're in the foreach loop, let's start grabbing the value
      modifiers! We could do the math here, but that would mean that the 
      modifiers compound. Someone could exploit the system by stacking their
      outfit purchases!
    */

    if (array_key_exists('shields', $outf)) {
      $shieldMod = $shieldMod + $outf['shields'];
    }

    if (array_key_exists('armor', $outf)) {
      $armorMod = $armorMod + $outf['armor'];
    }

    if (array_key_exists('accel', $outf)) {
      $accelMod = $accelMod + $outf['accel'];
    }

    if (array_key_exists('turn', $outf)) {
      $turnMod = $turnMod + $outf['turn'];
    }

    if (array_key_exists('mass', $outf)) {
      $massMod = $massMod + $outf['mass'];
    }

    /*
    Which means everything down here is just set dressing for the most part.
    */

    $type = outfittype($outf['type']);

    $content.= "<li>".$outf['name']." ($type) ";

    if($outf['type'] == 'DEC') {
      //It's so pretty! But so useless!
    } elseif ($outf['type'] == 'WPN') {
      if (array_key_exists('data1', $outf)) {
        $return['Damage'] = $return['Damage']+ $outf['data1'];
        $content.= "(Damage: ".$outf['data1'].") ";
      }
      if (array_key_exists('data2', $outf) && $outf['data2'] > 1) {
        if ($outf['data2'] == 'ENG') {
          $content.="(recharge: ".$outf['data2'].") ";
        } else {
          $content.="(reload: ".$outf['data2'].") ";
        }
      }
    } elseif ($outf['type'] == 'ECM') {
      if (array_key_exists('data1', $outf)) {
        $return['Evasion'] = $outf['data1'] + $return['Evasion'];
      }
      if (array_key_exists('data2', $outf) && $outf['data2'] > 1) {
        $content.="(recharge: ".$outf['data2'].") ";
      }
    } elseif ($outf['type'] == 'BCM') {
      if (array_key_exists('data1', $outf)) {
        $return['Evasion'] = $outf['data1'] + $return['Evasion'];
      }
      if (array_key_exists('data2', $outf) && $outf['data2'] > 1) {
        $content.="(reload: ".$outf['data2'].") ";
      }
      if (array_key_exists('Ammo', $outf)) {
        $content.="(ammo: ".$outf['Ammo'].") ";
      }
    } elseif ($outf['type'] == 'PPE') {

    }
    $content.= "</li>";
  }

  $content.= "</ul>";

  $content.= "<span class='label label-danger'>Total potential firepower: ";
  $content.= $return['Damage']."</span><br>";
  $content.= "<span class='label label-success'>Evasion modifier: ";
  $content.= $return['Evasion']."%</span>";

  /*
  Now that we're out of the foreach loop, we can start modifying ship values
  */

  $ship['shields'] = ($shieldMod * $ship['shields']) + $ship['shields'];
  $ship['armor'] = ($armorMod * $ship['armor']) + $ship['armor'];
  $ship['accel'] = ($accelMod * $ship['accel']) + $ship['accel'];
  $ship['turn'] = ($turnMod * $ship['turn']) + $ship['turn'];
  $ship['mass'] = ($massMod * $ship['mass']) + $ship['mass'];

  /*
  And let's add the evasion modifier to the ship array
  */

  $ship['EvasionModifier'] = $return['Evasion'];

  /*
  Save the potential damage score so we can handle unarmed ships
  */

  $ship['Damage'] = $return['Damage'];

  /*
  Put that thing back where it came from or so help me! We need to pass our
  newly modified ship array back to the main program level.
  */

  $return['Ship'] = $ship;

  /*
  The fluff for the table
  */

  $return['Output'] = $content;
  return $return;
}

function evadePercent() {
  return floor(rand(1,100));
}

function combatStatusCodes($code,$html=FALSE) {
  if ($html === true) {
    switch($code) {
      default:
      case 0:
        return "<span class='label label-danger'>Destroyed</span>";
        break;
    
      case 1: 
        return "<span class='label label-success'>Victorious</span>";
        break;
    
      case 2:
        return "<span class='label label-info'>Fled</span>";
        break;
    
      case 3: 
        return "<span class='label label-warning'>Fled</span>";
        break;
    }
  } else {
    switch($code) {
      default:
      case 0:
        return "Destroyed";
        break;
  
      case 1: 
        return "Victorious";
        break;
  
      case 2:
        return "Fled";
        break;
  
      case 3: 
        return "Draw";
        break;
    }
  }
}

function combatTick($firing, $evading, $tick) {
  $return = '';
  $damage = 0;
  /*
  This isn't really necessary, but we want to know who's doing what this tick
  */

  $return['Result'] = "";
  $opener = "<h3>Tick $tick</h3><ul class='list-unstyled'>";
  $opener.= "<li>".$firing['Position']." is ".$firing['Status']."</li>";
  $opener.= "<li>".$evading['Position']." is ".$evading['Status']."</li>";

  $return['Result'].= $opener;
  /*
  Generate our evasion chance (Thanks parseOutfits!)
  */

  $evadeChance = evasionChance(
    $evading['accel'],
    $evading['turn'],
    $evading['mass'],
    $evading['EvasionModifier']
  )['Modified'];
  /*
  Evade percent is a function so we can go back and refine that formula later
  */
  $evadePercent = evadePercent();

  /*
  Sanity check that we might be able to remove but I'm lazy so...
  */

  if (($evading['Damage'] == 0 && $firing['Damage'] == 0) && $tick === 100) {
    $return['Result'].= "<li>Battle ends in a draw!</li>";
    $evading['Status'] = 3;
    $firing['Status'] = 3;
  } else {
    if ($evadeChance >= $evadePercent) {
      /*
      The evading ship manages to evade the attacker this tick. 
      */
      $return['Result'].= "<li><span class='label label-success'>";
      $return['Result'].= "Evaded! Chance was $evadeChance, ";
      $return['Result'].= "percent was $evadePercent</span></li>";
      if (($evading['armor'] / $evading['Basearmor']) * 100 
        <= $evading['Flee']){
        /*
        If they evaded with their armor below the player-defined flee 
        threshold, reroll evasion and see if we can flee
        */
        $return['Result'].= "<li><span class='label label-primary'>Defender attempts to flee</span></li>";
        $evadePercent = evadePercent();
        if($evadePercent <= $evadeChance) {
          /* 
          Success! Set the results...
          */
          $return['Result'].= "<li><span class='label label-success'>Defender flees!</span></li>";
          $evading['Status'] = 2;
          $firing['Status'] = 1;
        } else {
          /*
          And they failed to flee.
          */
          $return['Result'].= "<li><span class='label label-danger'>Defender failed to flee!</span></li>";
        }
      }
    } else {
      /*
      The evader was unable to evade and will take the full brunt of whatever
      the attacker can dish out.
      */
      $return['Result'].= "<li><span class='label label-danger'>Failed to evade.";
      $return['Result'].= "</span></li>";
      
      foreach ($firing['Outfits'] AS $weapon) {
        /*
        Loop through the attackers outfits and calculate the damage from 
        anything that's a weapon
        */
        if($weapon['type'] == 'WPN') {
          if ($tick % $weapon['Reload'] === 0) {
            $damage = $damage + $weapon['Damage'];
            $return['Result'].= "<li>Took $damage damage from ";
            $return['Result'].= $weapon['name']."</li>";
          } else {
            if ($weapon['Projectile'] == 'E') {
              $return['Result'].= "<li>".$weapon['name'];
              $return['Result'].= " is recharging</li>";
            } else {
              $return['Result'].= "<li>".$weapon['name'];
              $return['Result'].= " is reloading</li>";
            }
          }
        }
      } 
      
      $return['Result'].= "<li>Attacking with $damage damage</li>";

      if ($evading['shields'] > 0) {
        if ($damage > $evading['shields']) {
          $diff = $damage - $evading['shields'];
          $evading['armor'] = $evading['armor'] - $diff;
          $evading['shields'] = 0;
        } else {
          $evading['shields'] = $evading['shields'] - $damage;
        }
      } else {
        $evading['armor'] = $evading['armor'] - $damage;
      }

      if ($evading['armor'] <= 0) {
        /*
        And prepare our return data if the defending ship is destroyed
        */
        $return['Result'].= "<li>".$evading['Position']." is destroyed at $tick seconds</li>";
        $evading['Status'] = 0;
        $firing['Status'] = 1;
      }
    }
  }
  $return['Result'].= "</ul>";
  /*
  Like parseOutfits(), combatTick() will add the ship arrays to the return
  result since we're modifying values (shields, armor etc). The function call 
  will be responsible for passing the ships back in.
  */
  $return['Atk'] = $firing;
  $return['Def'] = $evading;
  return $return;
}

function combatResultsTable($ship) {
  $name = $ship['name'];
  $evasion = evasionChance($ship['accel'],
    $ship['turn'],
    $ship['mass'],
    $ship['EvasionModifier'])['Modified'];
  $shields = $ship['shields'];
  $armor = $ship['armor'];
  $status = combatStatusCodes($ship['Status'],true);
  return tableCells(array(
    $name,
    $shields,
    $armor,
    $evasion,
    $status
    ));
}






