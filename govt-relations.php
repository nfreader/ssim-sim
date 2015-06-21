<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Government Relations</h1>
</div>


<?php 

$govt = new govt();
$relations = $govt->listRelations();

echo tableHeader('Subject,Status,Target');

foreach ($relations as $relation) {

  $subject = "<td><span class='label' style='color: #$relation->subjectcolor; background: #$relation->subjectcolor2'><a href='govt-list.php#gov-$relation->subject'>$relation->subjectname</a></span></td>";
  $target = "<td><span class='label' style='color: #$relation->targetcolor; background: #$relation->targetcolor2'><a href='govt-list.php#gov-$relation->target'>$relation->targetname</a></span></td>";

  echo "<tr>";
  $status = relationtype($relation->status);
  echo $subject;
  echo "<td class='".$status['CSS']."'>is ".$status['Full']." with</td>";
  echo $target;
  if ($relation->reciprical == true) {
    echo "</tr><tr>";
    echo $target;
    echo "<td class='".$status['CSS']."'>is ".$status['Full']." with</td>";
    echo $subject;
  }
  echo "</tr>";
}

echo tablefooter();

?>



<?php
require_once('footer.php');