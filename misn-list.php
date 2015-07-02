<?php
$wide = true;

require_once('header.php');

?>

<div class="page-header">
  <h1>Mission List</h1>
</div>

<?php $misn = new misn();
$misns = $misn->getMissions();

?>

<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Tons</th>
      <th>Commod</th>
      <th>Pickup</th>
      <th>Destination</th>
      <th>Reward</th>
      <th>Cargo Value</th>
      <th>Diff</th>
      <th>UID</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($misns as $misn) : ?>
    <tr class='commod commod-<?php echo $misn->type;?>'>
      <td class='num'><?php echo singular($misn->amount,'ton','tons');?></td>
      <td><?php echo $misn->commodname;?></td>
      <td><?php echo spoblink($misn->pickup,$misn->pickupname);?></td>
      <td><?php echo spoblink($misn->dest,$misn->destname);?></td>
      <td class='num'><?php echo credits($misn->reward);?></td>
      <td class='num'><?php echo credits($misn->actualvalue);?></td>
      <td class='num'><?php echo credits($misn->diff);?></td>
      <td><code><?php echo $misn->uid;?></code></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php

require_once('footer.php');
