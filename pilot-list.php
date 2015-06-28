<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Pilot List</h1>
</div>

<?php

$pilot = new pilot(NULL,FALSE);
$pilots = $pilot->listPilots();
//var_dump($pilots);
?>

<table class='table table-condensed table-bordered'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Vessel</th>
      <th>Government</th>
    </tr>
  </thead>
  <tbody>

<?php foreach ($pilots as $pilot) : ?>
  <tr>
    <td>
      <a href='viewpilot.php?pilot=<?php echo $pilot->id;?>'>
        <?php echo $pilot->name;?>
      </a>
    </td>
    <?php if (!$pilot->vessel) : ?>
    <td>No vessel</td>
    <?php else : ?>
    <td>
      <a href='viewvessel.php?vessel=<?php echo $pilot->vessel;?>'>
        <?php echo $pilot->vesselname;?>
      </a>
    </td>
    <?php endif; ?>
    <td>
      <?php echo govtLabel($pilot->govtname,$pilot->govtiso,$pilot->govt);?>
      </td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php

require_once('footer.php');
