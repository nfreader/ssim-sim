<?php

$wide = true;

require_once('header.php');

?>

<?php

$commod = new commod();
$commods = $commod->listCommods(); ?>

<div class="row">

<div class="col-md-2">

<div class="list-group">
  <a href="commod-list.php" class="list-group-item">
    <strong>Commodities</strong>
  </a>
<!--   <a href="commod-graphs.php" class="list-group-item load">
    Commodity Graphs
  </a> -->
    <?php foreach ($commods as $commod): ?>
    <a href="viewcommod.php?commod=<?php echo $commod->id;?>" class="list-group-item commod load">
      <?php echo $commod->name; ?>
    </a>
    <?php endforeach; ?>
</div>

</div>

<div class="col-md-10" id="content">

  <div class="page-header">
    <h1>Commodity Overview</h1>
  </div>

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
        <th>Average Supply</th>
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
        <td colspan="3"><?php echo commodtype($commod->type);?></td>
        <?php else : ?>
        <td><?php echo singular($commod->totalsupply,'ton','tons');?></td>
        <td><?php echo singular($commod->avgsupply,'ton','tons');?></td>
        <td><?php echo credits($commod->avgcost);?></td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>

<script>
  $('a.commod').click(function(event){
    event.preventDefault();
    var url = $(this).attr('href');
    var commod = url.replace('viewcommod.php?commod=','');
    if (commod != '') {
      history.pushState(null,null,'commod-list.php#'+commod);
    };
  });
  var commod = window.location.hash.substring(1);
  if (commod != '') {
      $('#content').empty().load('viewcommod.php?commod='+commod);
    };
</script>

<?php

require_once('footer.php');
