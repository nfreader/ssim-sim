<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Fingerprints</h1>
</div>

<pre>
<?php
  echo hexprint('nfreader')."<br>";
  echo hexprint('qwertyuiop')."<br>";
  echo hexprint('asdfghjkl')."<br>";
  echo hexprint('zxcvbnm')."<br>";
  echo hexprint('qazwsxedcrfvtgbyhnujmiklop')."<br>";
  echo hexprint(time())."<br>";
  $hex = explode(':','3f8:48b:193:5c1:571:ebd');
  $hexcode = '';
  foreach ($hex as $color) {
    echo hexdec($color)."<br>";
  }
?>
</pre>

<?php

require_once('footer.php');
