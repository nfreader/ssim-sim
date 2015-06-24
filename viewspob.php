<?php

require_once('header.php');

?>

<?php 

  if(empty($_GET['spob'])) {
    die('No port specified');
  }
  $spob = filter_input(INPUT_GET,'spob',FILTER_SANITIZE_NUMBER_INT);
  $spob = new spob($spob,TRUE);
  //var_dump($spob);
?>

<div class="page-header">
  <h1><?php echo $spob->name;?>
    <small>In the <?php echo $spob->parentname;?> system</small>
  </h1>
</div>

<div class="row">
  <div class="col-md-4">
    <h2><?php echo $spob->techlevel;?><br><small>Techlevel</small></h2>
  </div>
  <div class="col-md-4">
    <h2><?php echo $spob->fulltype;?><br><small>Port type</small></h2>
  </div>
  <?php if ($spob->govtseat == true) : ?>
  <div class="col-md-4">
    <h2><?php echo $spob->govtname;?><br><small>Government Seat</small></h2>
  </div>
  <?php else : ?>
  <div class="col-md-4">
    <h2><?php echo $spob->govtname;?><br><small>Government Seat</small></h2>
  </div>
  <?php endif; ?>
</div>

<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Tons Available</th>
      <th>Cost / ton</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($spob->commods as $commod) : ?>
    <tr class='commod commod-<?php echo $commod->type;?>'>
      <td><?php echo $commod->name;?></td>
      <td><?php echo $commod->supply;?></td>
      <td><?php echo credits($commod->cost);?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php

require_once('footer.php');
