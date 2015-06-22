<?php

require_once('header.php');

?>

<div class="page-header">
  <h1>Fingerprints</h1>
</div>

<?php 

function hexPrint2($string, $prefix = "0x") {
  $return = $prefix;
  $array = str_split(substr(sha1($string),0,18),3);
  foreach ($array as $val) {
    $return.= ':'.$val;
  }
  return $return;
}


?>

<pre>
<?php
  echo hexprint2('nfreader')."<br>";
  echo hexprint2('qwertyuiop')."<br>";
  echo hexprint2('asdfghjkl')."<br>";
  echo hexprint2('zxcvbnm')."<br>";
  echo hexprint2('qazwsxedcrfvtgbyhnujmiklop')."<br>";
  echo hexprint2(time());
?>
</pre>

<?php

require_once('footer.php');
