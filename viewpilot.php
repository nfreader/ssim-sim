<?php

require_once('header.php');

?>

<?php 

  if(empty($_GET['pilot'])) {
    die('No pilot specified');
  }
  $pilot = filter_input(INPUT_GET,'pilot',FILTER_SANITIZE_NUMBER_INT);
  $pilot = new vessel($pilot,FALSE);
  
?>

<div class="page-header">
  <h1><?php echo $vessel->name;?>
    <small>
      a <?php echo $vessel->shipwright;?> <?php echo $vessel->shipname;?> <?php echo $vessel->class;?>
    </small>
  </h1>
</div>

<div class="row">
  <div class="col-md-4">
    <h2> 
      <a href='viewpilot.php?pilot=<?php echo $vessel->pilot;?>'>
      <?php echo $vessel->pilotname;?>
    </a><br>
    <small>Registrant</small></h2>
  </div>
  <div class="col-md-4">
    <h2>
      <code><?php echo vesselregistration($vessel->registration);?></code><br>
      <small>Registration</small>
    </h2>
  </div>
  <div class="col-md-4">
    <h2>
      <span class='label label-<?php echo vesselstatus($vessel->status)['class'];?>'>
        <?php echo vesselstatus($vessel->status)['status'];?>
      </span><br>
    <small>Status</small></h2>
  </div>
</div>

<?php

require_once('footer.php');
