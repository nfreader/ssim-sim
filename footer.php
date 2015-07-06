
<hr>
<footer>
<p class="pull-left" id="clock">
  Current in-game time: <?php echo date(SSIM_DATE,time());?>
  <span id="hour"></span>.
  <span id="minutes"></span>.
  <span id="seconds"></span>
  &nbsp;
  <span id="day"></span>.
  <span id="month"></span>.
  <span id="year"></span>
</p>
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

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

var a = new Date(<?php echo date(GAME_YEAR.",m,j,H,i,s");?>);

a.gameHours = if(a.getHours() < 10) {'0'+a.getHours();} else {a.getHours();}
a.gameYear = a.getYear() + 1900;

var dateString = a.gameHours+'.'+a.getMinutes()+'.'+a.getSeconds()+' '+a.getDay()+'.'+a.getMonth()+'.'+a.gameYear;

console.log(dateString);

</script>

</body>