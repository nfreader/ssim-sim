<?php

require_once('header.php');

?>

<div class="page-header">
<h1>Galaxy Editor <small>Click on two systems to link them</small></h1>
</div>
<?php $syst = new syst();?>

<script src="https://code.createjs.com/easeljs-0.8.1.min.js"></script>

<script>


  function init() {

    var canvas = document.getElementById("demoCanvas");
    var context = canvas.getContext("2d");

    var systems = <?php echo json_encode($syst->listSysts(),JSON_NUMERIC_CHECK); ?>;
    var linksys = [];
    var newlinks = [];
    var oldX;


    var stage = new createjs.Stage("demoCanvas");
    var sys = systems.data;
    //var jumps = connections.data;
    //for (var i = jumps.length - 1; i >= 0; i--) {
    //  jumpLine(jumps[i]);
    //};

    var gridline = new createjs.Shape();
    //context.clearRect(0, 0, canvasW, canvasH);
    for (var x = 0.5; x < canvas.width; x += 8) {
      gridline.graphics.setStrokeStyle(1).beginStroke('#eee').mt(x,0).lt(x,canvas.height);
      stage.addChild(gridline);
    }
    
    for (var y = 0.5; y < canvas.height ; y += 8) {
      gridline.graphics.setStrokeStyle(1).beginStroke('#eee').mt(0,y).lt(canvas.width,y);
      stage.addChild(gridline);
    }

    stage.update();

    var sysdots=[];

    for (var i = systems.length - 1; i >= 0; i--) {
      var circle = new createjs.Shape();
      circle.sysdata = systems[i];
      circle.sysid = circle.sysdata.id;
      circle.id = circle.sysdata.id;
      x = parseInt(circle.sysdata.x);
      y = parseInt(circle.sysdata.y);
      if (circle.sysdata.hexcolor) {
        circle.graphics.beginFill(circle.sysdata.hexcolor2).drawCircle(x,y,5);
        circle.graphics.beginFill(circle.sysdata.hexcolor).drawCircle(x,y,3);
        circle.graphics.beginFill(circle.sysdata.hexcolor2).drawCircle(x,y,2);
      } else {
        circle.graphics.beginFill('#FFF').drawCircle(x,y,5);
        circle.graphics.beginFill('#000').drawCircle(x,y,3);
        circle.graphics.beginFill('#FFF').drawCircle(x,y,2);
      }
      var text = new createjs.Text(circle.sysdata.name,"10px Helvetica",'#000');
      text.x = circle.sysdata.x+10;
      text.y = circle.sysdata.y-5;

      var connections = ''+circle.sysdata.connections;
      connections = connections.split(',');
      //console.log(circle.id,circle.sysid,connections);
      var jumpline = new createjs.Shape();
      for (var c = connections.length - 1; c >= 0; c--) {
      //jumpline.graphics.setStrokeStyle(1).beginStroke('red').mt(circle.sysdata.x,circle.sysdata.y).lt(sysdots[connections[c]].sysdata.x,sysdots[connections[c]].sysdata.y);
      //stage.addChild(jumpline);
      console.log(sysdots[connections[c]]);
      //console.log(connections[c]);
    }
      stage.addChild(circle);
      stage.addChild(text);
      sysdots[circle.id] = circle;

    };
    stage.update();

    stage.on('stagemousedown',function(event){
      if (event.relatedTarget == null) {
        linksys = [];
      }
    });
    //console.log(sysdots[2].sysdata.x,sysdots[2].sysdata.y);
    //console.log(sysdots);
  }
  $(document).ready(function(){
    init();
  })
</script>
<div class="row">
<div class="col-md-9">
<p id="sysname">&nbsp;</p>
<canvas id="demoCanvas" width="513" height="513"></canvas>
</div>
<div class="col-md-3">
<h3>JSON output</h3>
<pre class='newlinkjson'>&nbsp;</pre>
</div>
</div>
<?php

require_once('footer.php');
