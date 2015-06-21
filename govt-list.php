<?php
require_once('header.php');
?>

<div class="page-header">
  <h1>Government Listing</h1>
</div>

<?php 

$govt = new govt();
$govt = $govt->getGovtStats();
?>

<?php foreach ($govt as $gov) : ?>

<div class='panel panel-default' id='gov-<?php echo $gov->id;?>'>
  <div class='panel-heading' style='color: #<?php echo $gov->color;?>; background: #<?php echo $gov->color2;?>'>
    <strong>
      <?php echo $gov->name;?>
    </strong>
  </div>

  <?php echo tableheader(array(
    'Type',
    'ISO-3166-1 alpha-2 code',
    'Home System',
    'Members',
    'Approximate wealth',
    'Controlled Systems (Controlled Ports)'
  ));

  echo tablecells(array(
    governmentType($gov->type),
    "<code>$gov->isoname</code",
    $gov->homesyst,
    $gov->totalpilots,
    credits($gov->totalmemberbalance),
    "$gov->systems($gov->spobs)"
  ));

  echo tablefooter();

  ?>

  <div class='panel-body'>
    <p>
      <strong>Government color CSS</strong>
      <pre>
.gov.<?php echo $gov->isoname;?> {
  color: #<?php echo $gov->color;?>;
  background: #<?php echo $gov->color2;?>;
}
.gov.<?php echo $gov->isoname;?>.inverse {
  color: #<?php echo $gov->color2;?>;
  background: #<?php echo $gov->color;?>;
}
      </pre>
    </p>
  </div>

</div>


<?php endforeach; ?>


<?php
require_once('footer.php');