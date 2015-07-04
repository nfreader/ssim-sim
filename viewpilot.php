<?php

require_once('header.php');

?>

<?php 

if(empty($_GET['pilot'])) {
  die('No pilot specified');
}
$pilot = new pilot(filter_input(INPUT_GET,'pilot',FILTER_SANITIZE_NUMBER_INT),FALSE);
?>



<div class="page-header">
  <h1>
    <?php echo $pilot->name;?>
    <small>
      <code>
        <?php echo $pilot->fingerprint;?>
      </code>
    </small>
    <?php if ($pilot->status === 'D') : ?>
      <span class='label label-danger pull-right'>DECEASED</span>
    <?php endif;?>

  </h1>
</div>

<div class="row">
  <div class="col-md-4">
    <h2>
      <?php echo govtLabel($pilot->govtname,$pilot->govtisoname,$pilot->govt);?><br>
      <small>Government</small>
    </h2>
  </div>
  <div class="col-md-4">
    <h2>
      <?php if (!$pilot->vessel) : ?>
        No Vessel
      <?php else : ?>
        <a href='viewvessel.php?vessel=<?php echo $pilot->vessel;?>'>
          <?php echo $pilot->vesselname;?>
        </a>
      <?php endif; ?>
      <br><small>Vessel</small>
    </h2>
  </div>
  <div class="col-md-4">
    <h2>
      <?php echo credits($pilot->balance);?><br>
      <small>Balance</small>
    </h2>
  </div>
</div>
  <?php if ($pilot->status == 'L') : ?>
    <h2>
      <?php echo landverb($pilot->locationtype,'past')." ".spoblink($pilot->location,$pilot->locationname);?>
      <small>at <?php echo $pilot->statuschange;?></small>
    </h2>
  <?php elseif ($pilot->status == 'O') : ?>
    <h2>In orbit at
      <?php echo $pilot->locationname; ?>
      <small>at <?php echo $pilot->statuschange;?></small>
    </h2>
  <?php else : ?>
    <h2>No location known</h2>
  <?php endif; ?>
<?php

require_once('footer.php');

