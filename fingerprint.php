<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Fingerprints</h1>
</div>
<?php

$vessel = new vessel();
var_dump($vessel->parseOutfits(1));
  
?>

<?php

require_once('footer.php');
