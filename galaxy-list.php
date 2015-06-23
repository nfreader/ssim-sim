<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>System and Port List</h1>
</div>

<?php 

$syst = new syst();
$systs = $syst->listSysts();

$spob = new spob();
$spobs = $spob->listSpobs();
?>
<table class='table table-condensed table-bordered'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Techlevel</th>
      <th>Homeworld</th>
      <th>Bluespace Node</th>
      <th>Fuel Cost/unit</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($systs as $syst) : ?>
  <tr>
    <td colspan=6 style='color: #<?php echo $syst->color;?>; background: #<?php echo $syst->color2;?>'>
      <strong><?php echo $syst->name;?> (<?php echo $syst->govtname;?>)</strong>
    </td>
  </tr>
<?php 
if ($syst->spobs == 0) {
  echo "<tr><td colspan=6>No ports</td></tr>";
} else {
foreach ($spobs as $spob) : echo "<tr>"; if ($spob->parent == $syst->id) : 

?>

<td><?php echo $spob->name;?></td>
<td><?php echo spobtype($spob->type);?></td>
<td><?php echo $spob->techlevel;?></td>
<td><?php echo $spob->homeworld;?></td>
<td><?php echo "<code>".hexprint($spob->name.$syst->name)."</code>";?></td>
<td><?php echo credits(fuelcost($spob->techlevel,$spob->type));?></td>

<?php endif; echo "</tr>"; endforeach; } ?>


<?php endforeach; ?>
</tbody>
</table>

<?php

require_once('footer.php');
