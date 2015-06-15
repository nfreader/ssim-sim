<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

  <style>
    .label.label-primary {
      color: #337ab7;
      background: white;
      border: 1px solid #337ab7;
    }
    .label.label-success {
      color: #5cb85c;
      background: white;
      border: 1px solid #5cb85c;
    }
    .label.label-danger {
      color: #d9534f;
      background: white;
      border: 1px solid #d9534f;
    }
    .col-md-4.hover:hover {
      background: rgb(251,255,145);
    }
    .row {
      margin: 0 0 20px 0;
    }
  </style>

</head>
<body>

<div class="container">
<?php
$time = explode(' ', microtime());
$start = $time[1] + $time[0];
require_once("functions.php");
require_once('ships.php');
require_once('combat-funcs.php');
