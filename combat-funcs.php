<?php

function evasionChance($accel, $turn, $mass, $modifier = 1) {
  $actual = floor(($accel * $turn / $mass) * 100);
  $modified = $actual * $modifier;
  $modified = $actual + $modified;
  $return['Actual'] = $actual;
  $return['Modified'] = $modified;
  return $return;
}

function outfitType($type) {
  switch($type) {
      default:
        $type = 'Undefined';
        break;

      case 'DEC':
        $type = 'Decoration';
        break;

      case 'WPN':
        $type = 'Weapon';
        break;

      case 'BCM':
        $type = 'Ballistic Countermeasures';
        break;

      case 'ECM':
        $type = 'Electronic Countermeasure';
        break;

      case 'PPE':
        $type = 'Propulsion Enhancement';
        break;

      case 'SEM':
        $type = 'Shield Enchancement';
        break;
    }
  return $type;
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
    Shields
    Armor
    Accel
    Turn
    Mass
  
  We also want to go ahead and calculate the evasion and stick it back in the 
  main ship array since all of the values we're modifying will affect that.
  */

  $ship['BaseEvasion'] = evasionChance($ship['Accel'],
    $ship['Turn'],$ship['Mass'])['Actual'];

  /* 
  Aaaaaand we'll go ahead and save the base starting points for our values so
  we can compare them later on.
  */

  $ship['BaseShields'] = $ship['Shields'];
  $ship['BaseArmor'] = $ship['Armor'];
  $ship['BaseAccel'] = $ship['Accel'];
  $ship['BaseTurn'] = $ship['Turn'];
  $ship['BaseMass'] = $ship['Mass'];

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
  foreach ($ship['Outfits'] as $outf) {

    /*
      Now that we're in the foreach loop, let's start grabbing the value
      modifiers! We could do the math here, but that would mean that the 
      modifiers compound. Someone could exploit the system by stacking their
      outfit purchases!
    */

    if (array_key_exists('Shields', $outf)) {
      $shieldMod = $shieldMod + $outf['Shields'];
    }

    if (array_key_exists('Armor', $outf)) {
      $armorMod = $armorMod + $outf['Armor'];
    }

    if (array_key_exists('Accel', $outf)) {
      $accelMod = $accelMod + $outf['Accel'];
    }

    if (array_key_exists('Turn', $outf)) {
      $turnMod = $turnMod + $outf['Turn'];
    }

    if (array_key_exists('Mass', $outf)) {
      $massMod = $massMod + $outf['Mass'];
    }

    /*
    Which means everything down here is just set dressing for the most part.
    */

    $type = outfitType($outf['Type']);

    $content.= "<li>".$outf['Name']." ($type) ";

    if($outf['Type'] == 'DEC') {
      //It's so pretty! But so useless!
    } elseif ($outf['Type'] == 'WPN') {
      if (array_key_exists('Damage', $outf)) {
        $return['Damage'] = $return['Damage']+ $outf['Damage'];
        $content.= "(Damage: ".$outf['Damage'].") ";
      }
      if (array_key_exists('Reload', $outf) && $outf['Reload'] > 1) {
        if ($outf['Projectile'] == 'E') {
          $content.="(recharge: ".$outf['Reload'].") ";
        } else {
          $content.="(reload: ".$outf['Reload'].") ";
        }
      }
    } elseif ($outf['Type'] == 'ECM') {
      if (array_key_exists('Evasion', $outf)) {
        $return['Evasion'] = $outf['Evasion'] + $return['Evasion'];
      }
      if (array_key_exists('Reload', $outf) && $outf['Reload'] > 1) {
        $content.="(recharge: ".$outf['Reload'].") ";
      }
    } elseif ($outf['Type'] == 'BCM') {
      if (array_key_exists('Evasion', $outf)) {
        $return['Evasion'] = $outf['Evasion'] + $return['Evasion'];
      }
      if (array_key_exists('Reload', $outf) && $outf['Reload'] > 1) {
        $content.="(reload: ".$outf['Reload'].") ";
      }
      if (array_key_exists('Ammo', $outf)) {
        $content.="(ammo: ".$outf['Ammo'].") ";
      }
    } elseif ($outf['Type'] == 'PPE') {

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

  $ship['Shields'] = ($shieldMod * $ship['Shields']) + $ship['Shields'];
  $ship['Armor'] = ($armorMod * $ship['Armor']) + $ship['Armor'];
  $ship['Accel'] = ($accelMod * $ship['Accel']) + $ship['Accel'];
  $ship['Turn'] = ($turnMod * $ship['Turn']) + $ship['Turn'];
  $ship['Mass'] = ($massMod * $ship['Mass']) + $ship['Mass'];

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

function combatTick($firing, $evading, $tick) {
  $return = '';
  $damage = 0;
  /*
  This isn't really necessary, but we want to know who's doing what this tick
  */
  $return['Result'] = "<ul>";
  $opener = "<li>Tick $tick:</li>";
  $opener.= "<li>".$firing['Position']." is ".$firing['Status']."</li>";
  $opener.= "<li>".$evading['Position']." is ".$evading['Status']."</li>";

  $return['Result'].= $opener;
  /*
  Generate our evasion chance (Thanks parseOutfits!)
  */

  $evadeChance = evasionChance(
    $evading['Accel'],
    $evading['Turn'],
    $evading['Mass'],
    $evading['EvasionModifier']
  )['Modified'];
  /*
  Evade percent is a function so we can go back and refine that formula later
  */
  $evadePercent = evadePercent();

  /*
  Sanity check that we might be able to remove but I'm lazy so...
  */

  if ($evading['Armor'] <= 0) {
    $return['Result'].= "<li>".$evading['Position']." is destroyed</li>";
    $evading['Status'] = "Destroyed";
  } else {
    if ($evadeChance >= $evadePercent) {
      /*
      The evading ship manages to evade the attacker this tick. 
      */
      $return['Result'].= "<li><span class='label label-success'>";
      $return['Result'].= "Evaded! Chance was $evadeChance, ";
      $return['Result'].= "percent was $evadePercent</span></li>";
      if (($evading['Armor'] / $evading['BaseArmor']) * 100 
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
          $evading['Status'] = 'Fled';
          $evading['StatusCode'] = 2;
          $firing['Status'] = 'Victorious';
          $firing['StatusCode'] = 1;
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
        if($weapon['Type'] == 'WPN') {
          if ($tick % $weapon['Reload'] === 0) {
            $damage = $damage + $weapon['Damage'];
            $return['Result'].= "<li>Took $damage damage from ";
            $return['Result'].= $weapon['Name']."</li>";
          } else {
            if ($weapon['Projectile'] == 'E') {
              $return['Result'].= "<li>".$weapon['Name'];
              $return['Result'].= " is recharging</li>";
            } else {
              $return['Result'].= "<li>".$weapon['Name'];
              $return['Result'].= " is reloading</li>";
            }
          }
            /*
            If the defender's shields are up, attack those first
            TODO: Switch this to a while loop and start dealing damage to armor
            when shields fail
            */
            if($evading['Shields'] >= 0) {
              $evading['Shields'] = $evading['Shields'] - $damage;
            } else {
              /*
              Start working on armor once shields are down
              */
              $evading['Armor'] = $evading['Armor'] - $damage;
            }
          }
        }
      }
    if ($evading['Armor'] <= 0) {
      /*
      And prepare our return data if the defending ship is destroyed
      */
      $return['Result'].= "<li>".$evading['Position']." is destroyed at $tick seconds</li>";
      $evading['Status'] = "Destroyed";
      $evading['StatusCode'] = 0;
      $firing['Status'] = "Victorious!";
      $firing['StatusCode'] = 1;
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
