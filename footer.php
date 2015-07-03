
<hr>
<footer>
  <p class="pull-right">
    <?php
      $time = explode(' ',microtime());
      $finish = $time[1] + $time[0];
      $total = round(($finish - $start), 4);
      echo "Page generated in ".$total." seconds.";
    ?>
  </p>
</footer>
</div>

<script>

$('a.load').click(function(){
  event.preventDefault();
  var link = $(this).attr('href');
  $('#content').empty().load(link);
});

</script>

</body>