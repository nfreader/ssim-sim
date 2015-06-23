<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Commodity Overview</h1>
</div>

<?php 

$commod = new commod();
$commods = $commod->listCommods(); ?>

<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Minimum Techlevel</th>
      <th>Number of ports</th>
      <th>Base Cost / ton</th>
      <th>Base Supply</th>
      <th>Total tons in ports</th>
      <th>Average Cost / ton</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($commods as $commod) : ?>
    <tr class='commod commod-<?php echo $commod->type;?>'>
      <td><?php echo $commod->name;?></td>
      <?php if ($commod->type != 'C') : ?>
      <td colspan="3"><?php echo commodtype($commod->type);?></td>
      <?php else : ?>
      <td><?php echo commodtype($commod->type);?></td>
      <td><?php echo $commod->techlevel;?></td>
      <td><?php echo $commod->spobs;?></td>
      <?php endif; ?>
      <td><?php echo credits($commod->basecost);?></td>
      <td><?php echo singular($commod->basesupply,'ton','tons');?></td>
      <?php if ($commod->type != 'C') : ?>
      <td colspan="2"><?php echo commodtype($commod->type);?></td>
      <?php else : ?>
      <td><?php echo singular($commod->totalsupply,'ton','tons');?></td>
      <td><?php echo credits($commod->avgcost);?></td>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php


require_once('footer.php');
