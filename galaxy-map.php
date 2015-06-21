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

    function systemDot(data,i) {
      var circle = new createjs.Shape();
      circle.sysdata = data;
      circle.sysid = circle.sysdata.id;
      circle.id = circle.sysdata.id;
      x = parseInt(circle.sysdata.x);
      y = parseInt(circle.sysdata.y);
      if (circle.sysdata.color) {
        circle.graphics.beginFill(circle.sysdata.color2).drawCircle(x,y,5);
        circle.graphics.beginFill(circle.sysdata.color).drawCircle(x,y,3);
        circle.graphics.beginFill(circle.sysdata.color2).drawCircle(x,y,2);
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
      console.log(circle.id,circle.sysid,connections);
      stage.addChild(circle);
      stage.addChild(text);
    }

    function jumpLine(data) {
      dx = Math.abs(data.x*10)+5;
      dy = Math.abs(data.y*10)+5;
      ox = Math.abs(data.x*10)+5;
      oy = Math.abs(data.y*10)+5;
      var line = new createjs.Shape();
      line.graphics.mt(ox,oy).setStrokeStyle(1).beginStroke('red').lt(dx,dy).lt(ox,oy);
      stage.addChild(line);
    }

    function connectSystems(data) {
      dx = data[0].x;
      dy = data[0].y;
      ox = data[1].x;
      oy = data[1].y;
      if (data[0].id == data[1].id) {
        $('#sysname').text('You cannot link a system to itself!');
        return false;
      }
      var line = new createjs.Shape();
      line.graphics.setStrokeStyle(1).beginStroke('red').mt(dx,dy).lt(ox,oy);
      stage.addChild(line);
      stage.update();
      var templink = {};
      templink.origin = data[0].id;
      templink.dest = data[1].id;
      templink.type = 'R';
      newlinks.push(templink);
      var templink = {};
      templink.origin = data[1].id;
      templink.dest = data[0].id;
      templink.type = 'R';
      newlinks.push(templink);
      $('.newlinkjson').text(JSON.stringify(newlinks));
      $('#sysname').text('Linked '+data[0].name+ ' to '+data[1].name+'!');
    }

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
      if (circle.sysdata.color) {
        circle.graphics.beginFill(circle.sysdata.color2).drawCircle(x,y,5);
        circle.graphics.beginFill(circle.sysdata.color).drawCircle(x,y,3);
        circle.graphics.beginFill(circle.sysdata.color2).drawCircle(x,y,2);
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
      console.log(circle.id,circle.sysid,connections);
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
