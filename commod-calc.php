<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Commodity Price Calculator</h1>
</div>

<?php 

$commod = new commod();
$commods = $commod->listCommods();

?>

<pre>
Commodity Base Cost * ((Commodity Techlevel / Port Techlevel) / Port Supply) * <?php echo COMMOD_COST_MODIFIER;?>
</pre>

<table class="table table-condensed table-bordered">
  <thead>
    <tr>
      <th>Port Supply Available</th>
      <th>100 tons</th>
      <th>200 tons</th>
      <th>300 tons</th>
      <th>400 tons</th>
      <th>500 tons</th>
    </tr>
  </thead>
  <tbody>
<?php $techlevel = 9; while ($techlevel > 0) : ?>
    <tr>
      <td colspan=6><strong><?php echo "Techlevel $techlevel"; ?></strong></td>
    </tr>
<?php foreach ($commods as $commod) : 
  if ($commod->techlevel <= $techlevel && $commod->type == 'C') : ?>
    <tr class='commod commod-<?php echo $commod->type;?>'
    style='text-align:right;'>
      <td><?php echo $commod->name;?></td>
      <td><?php echo credits(commodCost($commod->basecost, $commod->techlevel,$techlevel,100));?> / ton</td>
      <td><?php echo credits(commodCost($commod->basecost, $commod->techlevel,$techlevel,200));?> / ton</td>
      <td><?php echo credits(commodCost($commod->basecost, $commod->techlevel,$techlevel,300));?> / ton</td>
      <td><?php echo credits(commodCost($commod->basecost, $commod->techlevel,$techlevel,400));?> / ton</td>
      <td><?php echo credits(commodCost($commod->basecost, $commod->techlevel,$techlevel,500));?> / ton</td>
    </tr>
<?php endif; endforeach; ?>

<?php $techlevel = $techlevel-2; endwhile; ?>
  </tbody>
</table>
<?php
require_once('footer.php');
