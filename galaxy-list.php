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

foreach($systs as $syst) : ?>

<div class="panel panel-default">

<div class="panel-heading" style='color: #<?php echo $syst->color;?>; background: #<?php echo $syst->color2;?>'>
  <strong><?php echo $syst->name;?></strong>
</div>

<table class='table table-condensed'>
<thead>
<tr>
<th>Name</th>
<th>Type</th>
<th>Techlevel</th>
<th>Can be homeworld</th>
</tr>
</thead>
<tbody>

<?php foreach ($spobs as $spob) : echo "<tr>"; if ($spob->parent == $syst->id) : ?>

<td><?php echo $spob->name;?></td>
<td><?php echo spobtype($spob->type);?></td>
<td><?php echo $spob->techlevel;?></td>
<td><?php echo $spob->can_be_homeworld;?></td>

<?php endif; echo "</tr>"; endforeach; ?>
</table>

</div>

<?php endforeach; ?>


<?php

require_once('footer.php');
