<?php
$time = explode(' ', microtime());
$start = $time[1] + $time[0];
require_once('inc/config.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <style>

  </style>

</head>
<body>

<?php 
$menu = array(
  'Combat'=>array(
    'Ship Parser'=>'ship-parse',
    'Combat Simulator'=>'combat',
  ),
  'Cartography'=>array(
    'Galaxy Map'=>'galaxy-map',
    'Galaxy Generator'=>'syst-spob-generator',
    'Galaxy List'=>'galaxy-list',
  ),
  'Government'=>array(
    'Government List'=>'govt-list',
    'Government Relations'=>'govt-relations',
  ),
  'Economy'=>array(
    'Commodity List'=>'commod-list',
    'Spawn Commodities'=>'commod-spawn',
    'Price Calculator'=>'commod-calc',
    ),
  'Meta'=>array(
    'Fingerprint Tester'=>'fingerprint',
  ),
);

echo bootstrapMenu($menu);

?>

<div class="container">
<ul>

</ul>

