<?php

function directLoad($page) {
  $return .=  "<script>$('#game').load('".$page."');console.log('".$page."')</script>";
}

function returnMsg($content) {
  $return .=  "<script>returnMsg('".$content."');</script>";
}

/* Singular
 *
 * Based on the input, outputs the singular or plural of the specified unit
 *
 * @value (int) The value we're looking at
 * @one (string) The output if the value is one
 * @many (string) The output if the value is greater than one
 *
 * @return string
 *
 */

function singular($value, $one, $many) {
  if ($value == 1) {
    return $one;
  } else {
    return $many;
  }
}

/* spobType
 *
 * Outputs the correct title for a spob based on its type
 *
 * @type (string) The spob type
 *
 * @return (string) Planet, Moon, Station or '' (nothing, ie: The Death Star)
 *
 */

function spobType($type) {
  switch ($type) {
    case 'P':
    default:
      $type = "Planet";
      break;

    case 'M':
      $type = "Moon";
      break;

    case 'S':
      $type = "Station";//That's no moon...
      break;

    case 'N':
      $type = "";
      break;
  }
  return $type;
}

/* getSalt
 *
 * Outputs a string of random characters to salt a hash function.
 * Credit to @arplynn for pointing me in the right direction.
 *
 *
 *@return(string) A string of random characters, where the length is
 * specified by the PASSWD_SALT_LENGTH constant in inc/config.php
 *
 */

function getSalt() {
  $saltSource = fopen('/dev/urandom', 'rb');
  $saltData = bin2hex(fread($saltSource, PASSWD_SALT_LENGTH));
  fclose($saltSource);
  return $saltData;
}

/* hexPrint
 *
 * Mutilates a given string into a unique, Cool Looking(tm) hex string
 *
 * @string (string) The string we're abusing (passed through a sha function)
 * @prefix (string) A few characters we can use to denote a hex string. Default
 * is '0x'
 *
 * @return (string) A Cool Looking(tm) hex string
 *
 */

function hexPrint($string, $prefix = "0x") {
  $string = str_split(bin2hex(substr(sha1($string), 32)));
  //First, we're taking the sha1 sum of the string.
  //Next, we grab the first 32 characters of that...
  //Convert it to hex and finally split the string into an array
  $output = $prefix;
  $i      = 1;
  foreach ($string as $char) {
    $output .= $char;
    if ($i == 2) {
      $output .= ':';//Add the separator...
      $i = 0;
    }
    $i++;
  }
  return substr($output, 0, -1);//And output the string minus the trailing ':'
}

// function commodPrice() {
//   $types = array(
//     'Food',
//     'Technology',
//     'Materials'
//   );
// }

function randVessel() {
  global $adjectives;
  global $gods;

  $vessel = $adjectives[array_rand($adjectives)];
  $vessel .= " ";
  $vessel .= $gods[array_rand($gods)];
  return $vessel;
}

function landVerb($type, $tense = 'future') {
  if ($tense == 'future') {
    switch ($type) {
      case 'P':
      case 'M':
      default:
        $type = "Land on";
        break;

      case 'S':
      case 'N':
        $type = "Dock with";
        break;

    }

  } elseif ($tense == 'then') {
    switch ($type) {
      case 'P':
      case 'M':
      default:
        $type = "Lift off from";
        break;

      case 'S':
      case 'N':
        $type = "Undock with";
        break;
    }
  } elseif ($tense == 'past') {
    switch ($type) {
      case 'P':
      case 'M':
      default:
        $type = "landed on";
        break;

      case 'S':
      case 'N':
        $type = "docked at";
        break;
    }
  }

  return $type;
}

function fuelMeter($fuel, $max, $fuelMeter) {
  $meter = "<strong>Fuel</strong> $fuel " .singular($fuel, 'jump', 'jumps')." remaining";
  if ($fuelMeter < 25 ){
    $meter .= "<div class='progress fuel panic'><div class='progress-bar' style='width: ".$fuelMeter."%'></div></div>";
  } else {
  $meter .= "<div class='progress fuel'><div class='progress-bar' style='width: ".$fuelMeter."%'></div></div>";
  }
  return $meter;
}

function shieldMeter($shields) {
  $meter = "<strong>Shields</strong>";
  if ($shields < 25) {
  $meter .= "<div class='progress shields panic'><div class='progress-bar progress-bar-info' style='width: ".$shields."%'></div></div>";
  } else {
    $meter .= "<div class='progress shields'><div class='progress-bar progress-bar-info' style='width: ".$shields."%'></div></div>";
  }
  return $meter;
}

function armorMeter($armor) {
  $meter = "<strong>Hull Integrity</strong>";
  if ($armor < 25) {
    $meter .= "<div class='progress armor panic'><div class='progress-bar progress-bar-warning' style='width: ".$armor."%'></div></div>";
  } else {
    $meter .= "<div class='progress armor'><div class='progress-bar progress-bar-warning' style='width: ".$armor."%'></div></div>";
  }
  return $meter;
}

function cargoMeter($cargometer, $cargo, $cargohold) {
  $meter = "<strong>Cargo Hold</strong> ($cargo of $cargohold tons used)";
  $meter .= "<div class='progress cargo'><div class='progress-bar progress-bar-success' style='width: ".$cargometer."%'></div></div>";
  return $meter;
}

/* Function icon
 *
 * Renders the HTML for a Font Awesome icon!
 *
 * @icon (string) Icon to display
 * @class (string) (optional) Additional class to add to the icon. Technically could be a part of @icon, but where's the fun in that?
 *
 * @return string
 *
 */

function icon($icon, $class = '') {
  return "<span class='fa fa-".$icon." ".$class."'></span> ";
}

function gameLogActionTypes($action) {
  switch ($action) {
    default: 
    case 'O':
    $action = 'logged';
    break;

    case 'R':
    $action = 'Refueled';
    break;

    case 'MH':
    $action = 'Made homeworld';
    break;

    case 'J':
    $action = 'Jumped';
    break;

    case 'A':
    $action = 'Arrived';
    break;

    case 'D':
    $action = 'Departed';
    break;

    case 'RV':
    $action = 'Renamed Vessel';
    break;

    case 'CS':
    $action = 'Sold Commod';
    break;

    case 'CB':
    $action = 'Bought Commod';
    break;
  }
  return $action;
}

function documentType($type) {
  switch ($type) {
    case 'CS':
    $type = array();
    $type['text'] = 'Commodity Sale';
    $type['class'] = 'commodity commod-sale';
    return $type;
    break;

    case 'CB':
    $type = array();
    $type['text'] = 'Commodity Purchase';
    $type['class'] = 'commodity commod-buy';
    return $type;
    break;
  }
}

// function table($cols, $rows, $class, $rowclass){
//  $header = "<table class='table ".$class."'><thead><tr>";
//     foreach ($columns as $column) {
//         $header.= "<th>".$column."</th>";
//     }
//     $header.= "</thead><tbody>";
//     $row = '';
//     foreach ($rows as $row) {
//      $row.="<tr>"
//     } 
// }

function tableHeader($columns, $class='table table-bordered table-condensed') {
  if (!is_array($columns)) {
    $columns = explode(',',$columns);
  }
  $header = "<table class='table ".$class."'><thead><tr>";
  foreach ($columns as $column) {
      $header.= "<th>".$column."</th>";
  }
  $header.= "</thead><tbody>";
  
  return $header;
}

function tableCell($cell) {
  return "<td>".$cell."</td>";
}

function tableCells($cells) {
  $return = '<tr>';
  foreach ($cells as $cell) {
    $return.= "<td>".$cell."</td>";
  }
  $return.="</tr>";
  return $return;
}

function tableFooter() {
  return "</tbody></table>";
}

function optionlist($options) {
  $list = "<ul class='dot-leader'>";
  foreach($options as $key => $value) {
    $list.= "<li id='".strtolower($key)."'>";
    $list.= "<span class='left'>$key</span>";
    $list.= "<span class='right'>$value</span></li>";
  }
  $list.= "</ul>";
  return $list;
}

function beaconTypes($type) {
  $data = array();
  switch ($type) {
    default:
    case 'R':
    $data['class']='regular';
    $data['text']='Regular';
    $data['icon']='';
    break;

    case 'D':
    $data['class']='distress';
    $data['text']='Distress';
    $data['icon']='exclamation-triangle';
    $data['header']='<h1>'.icon($data['icon']).'Distress Beacon</h1>';
    break;
  }
  return $data;
}

function shipClass($class) {
  //Future proof. I bet we'll add more things like ship images and icons in 
  //the future.
  $data = array();
  switch($class) {
    default:
    case 'S':
    $data['class']='Shuttle';
    break;

    case 'F':
    $data['class']='Fighter';
    break;

    case 'H':
    $data['class']='Freighter';
    break;
  }
  return $data;
}

function shipValue($id, $date, $cost) {
  $diff = (time() - strtotime($date)) * .25;
  $price = $cost/$diff;
  return $cost*.85; 
  //TODO: Make the trade-in value relative to the date the ship was purchased.
  //OH MY GOD MAKE IT RELATIVE TO THE SPOB TECHLEVEL!
}

function relativeTime($date, $postfix = ' ago', $fallback = 'F Y') 
{
    $diff = time() - strtotime($date);
    if($diff < 60) 
        return $diff . ' second'. ($diff != 1 ? 's' : '') . $postfix;
    $diff = round($diff/60);
    if($diff < 60) 
        return $diff . ' minute'. ($diff != 1 ? 's' : '') . $postfix;
    $diff = round($diff/60);
    if($diff < 24) 
        return $diff . ' hour'. ($diff != 1 ? 's' : '') . $postfix;
    $diff = round($diff/24);
    if($diff < 7) 
        return $diff . ' day'. ($diff != 1 ? 's' : '') . $postfix;
    $diff = round($diff/7);
    if($diff < 4) 
        return $diff . ' week'. ($diff != 1 ? 's' : '') . $postfix;
    $diff = round($diff/4);
    if($diff < 12) 
        return $diff . ' month'. ($diff != 1 ? 's' : '') . $postfix;

    return date($fallback, strtotime($date));
}

function isEmpty($string) {
  if (empty($string) || trim($string) == '') {
    return true;
  }
  return false;
}

function credits($credits) {
  return number_format($credits + 0)." ".icon('certificate','credits');
}

/* pick
 *
 * Return a single value from an array. Useful for one-off situations (fluff
 * text)
 *
 * @list (mixed) An array or comma separated list to pull an entry from
 *
 * @return string
 *
 */

function pick($list) {
  if (!is_array($list)) {
    $list = explode(',',$list);
  }
  return $list[floor(rand(0,count($list)-1))];
}

function bootstrapMenu($menu) {
$return ='<nav class="navbar navbar-default navbar-static-top">';
$return.='  <div class="container">';
$return.='    <a class="navbar-brand" href="index.php">Space Sim Simulator</a>';
$return.='    <ul class="nav navbar-nav">';
      foreach ($menu as $submenu=>$items) {
        if (is_array($items)) {
          $return .=  "<li class='dropdown'>";
          $return .=  "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>$submenu <span class='caret'></span></a>";
          $return .=  "<ul class='dropdown-menu'>";
          foreach ($items as $name=>$link) {
            $return .=  "<li><a href='$link.php'>$name</a></li>";
          }
          $return .=  "</ul></li>";
        } 
      }
$return.='    </ul>';
$return.='  </div>';
$return.='</nav>';
return $return;
}

function governmentType($gov) {
  switch ($gov) {
    case 'R':
    default:
      return 'Regular';
      break;
    case 'I':
      return 'Independent';
      break;
    case 'P':
      return 'Pirate';
      break;
  }
}

function relationType($relation) {
  switch($relation) {
    case 'N':
    default:
      $return['Full'] = 'Neutral';
      $return['CSS'] = 'info';
      return $return;
      break;

    case 'A':
      $return['Full'] = 'Allied';
      $return['CSS'] = 'success';
      return $return;
      break;

    case 'W':
      $return['Full'] = 'At War';
      $return['CSS'] = 'danger';
      return $return;
      break;

  }
}