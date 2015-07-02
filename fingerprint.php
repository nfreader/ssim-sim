<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Fingerprints</h1>
</div>

<pre>
<?php

  $misn = new misn();
  $misns = $misn->generatemissions(100);
  
?>
</pre>

<?php

require_once('footer.php');
