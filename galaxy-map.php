<?php

require_once('header.php');

?>
<script src="https://code.createjs.com/easeljs-0.8.1.min.js"></script>

<script>

var systems = {
  "data":
  [
    {
      "id": 1,
      "name": "Levo",
      "coord_x": 0,
      "coord_y": 0,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "58,2,3"
    },
    {
      "id": 2,
      "name": "Tyson",
      "coord_x": 10,
      "coord_y": -10,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "1,69,70"
    },
    {
      "id": 3,
      "name": "Juliard",
      "coord_x": -10,
      "coord_y": 10,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "63,1,59"
    },
    {
      "id": 58,
      "name": "Jevon",
      "coord_x": -1,
      "coord_y": 5,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "1,68,64"
    },
    {
      "id": 59,
      "name": "BNR-Petronius",
      "coord_x": -15,
      "coord_y": 7,
      "govt": 1,
      "government": "Pirate",
      "isoname": "PI",
      "color": "#00A6A6",
      "color2": "#FFFFFF",
      "connections": "60,3,62"
    },
    {
      "id": 60,
      "name": "Aktinos",
      "coord_x": -13,
      "coord_y": 9,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "61,59"
    },
    {
      "id": 61,
      "name": "Laidlaw",
      "coord_x": -8,
      "coord_y": 8,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "60"
    },
    {
      "id": 62,
      "name": "Deaton",
      "coord_x": -11,
      "coord_y": 2,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "59"
    },
    {
      "id": 63,
      "name": "Vaughan",
      "coord_x": -12,
      "coord_y": 5,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "3"
    },
    {
      "id": 64,
      "name": "Carroll",
      "coord_x": 3,
      "coord_y": 7,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "58,67,65"
    },
    {
      "id": 65,
      "name": "BNR-Moore",
      "coord_x": 1,
      "coord_y": 3,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "66,64"
    },
    {
      "id": 66,
      "name": "Allais",
      "coord_x": -1,
      "coord_y": 8,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "65"
    },
    {
      "id": 67,
      "name": "McLain",
      "coord_x": 2,
      "coord_y": 10,
      "govt": 1,
      "government": "Pirate",
      "isoname": "PI",
      "color": "#00A6A6",
      "color2": "#FFFFFF",
      "connections": "64"
    },
    {
      "id": 68,
      "name": "Grice",
      "coord_x": -4,
      "coord_y": 1,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "58"
    },
    {
      "id": 69,
      "name": "Moore",
      "coord_x": -6,
      "coord_y": 2,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "2,71,72"
    },
    {
      "id": 70,
      "name": "Galileo",
      "coord_x": 5,
      "coord_y": -24,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "2"
    },
    {
      "id": 71,
      "name": "Archer",
      "coord_x": -25,
      "coord_y": -7,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "69"
    },
    {
      "id": 72,
      "name": "Braess",
      "coord_x": 5,
      "coord_y": 8,
      "govt": 0,
      "government": "Independent",
      "isoname": "IN",
      "color": "#CCCCCC",
      "color2": "#444444",
      "connections": "69"
    }
  ]
};

var connections = {
  "data":
  [
    {
      "dest_x": 10,
      "dest_y": -10,
      "dest": 2,
      "dest_name": "Tyson",
      "origin_x": 0,
      "origin_y": 0,
      "origin": 1,
      "origin_name": "Levo"
    },
    {
      "dest_x": -10,
      "dest_y": 10,
      "dest": 3,
      "dest_name": "Juliard",
      "origin_x": 0,
      "origin_y": 0,
      "origin": 1,
      "origin_name": "Levo"
    },
    {
      "dest_x": -1,
      "dest_y": 5,
      "dest": 58,
      "dest_name": "Jevon",
      "origin_x": 0,
      "origin_y": 0,
      "origin": 1,
      "origin_name": "Levo"
    },
    {
      "dest_x": 0,
      "dest_y": 0,
      "dest": 1,
      "dest_name": "Levo",
      "origin_x": 10,
      "origin_y": -10,
      "origin": 2,
      "origin_name": "Tyson"
    },
    {
      "dest_x": -6,
      "dest_y": 2,
      "dest": 69,
      "dest_name": "Moore",
      "origin_x": 10,
      "origin_y": -10,
      "origin": 2,
      "origin_name": "Tyson"
    },
    {
      "dest_x": 5,
      "dest_y": -24,
      "dest": 70,
      "dest_name": "Galileo",
      "origin_x": 10,
      "origin_y": -10,
      "origin": 2,
      "origin_name": "Tyson"
    },
    {
      "dest_x": 0,
      "dest_y": 0,
      "dest": 1,
      "dest_name": "Levo",
      "origin_x": -10,
      "origin_y": 10,
      "origin": 3,
      "origin_name": "Juliard"
    },
    {
      "dest_x": -15,
      "dest_y": 7,
      "dest": 59,
      "dest_name": "BNR-Petronius",
      "origin_x": -10,
      "origin_y": 10,
      "origin": 3,
      "origin_name": "Juliard"
    },
    {
      "dest_x": -12,
      "dest_y": 5,
      "dest": 63,
      "dest_name": "Vaughan",
      "origin_x": -10,
      "origin_y": 10,
      "origin": 3,
      "origin_name": "Juliard"
    },
    {
      "dest_x": 0,
      "dest_y": 0,
      "dest": 1,
      "dest_name": "Levo",
      "origin_x": -1,
      "origin_y": 5,
      "origin": 58,
      "origin_name": "Jevon"
    },
    {
      "dest_x": 3,
      "dest_y": 7,
      "dest": 64,
      "dest_name": "Carroll",
      "origin_x": -1,
      "origin_y": 5,
      "origin": 58,
      "origin_name": "Jevon"
    },
    {
      "dest_x": -4,
      "dest_y": 1,
      "dest": 68,
      "dest_name": "Grice",
      "origin_x": -1,
      "origin_y": 5,
      "origin": 58,
      "origin_name": "Jevon"
    },
    {
      "dest_x": -10,
      "dest_y": 10,
      "dest": 3,
      "dest_name": "Juliard",
      "origin_x": -15,
      "origin_y": 7,
      "origin": 59,
      "origin_name": "BNR-Petronius"
    },
    {
      "dest_x": -13,
      "dest_y": 9,
      "dest": 60,
      "dest_name": "Aktinos",
      "origin_x": -15,
      "origin_y": 7,
      "origin": 59,
      "origin_name": "BNR-Petronius"
    },
    {
      "dest_x": -11,
      "dest_y": 2,
      "dest": 62,
      "dest_name": "Deaton",
      "origin_x": -15,
      "origin_y": 7,
      "origin": 59,
      "origin_name": "BNR-Petronius"
    },
    {
      "dest_x": -15,
      "dest_y": 7,
      "dest": 59,
      "dest_name": "BNR-Petronius",
      "origin_x": -13,
      "origin_y": 9,
      "origin": 60,
      "origin_name": "Aktinos"
    },
    {
      "dest_x": -8,
      "dest_y": 8,
      "dest": 61,
      "dest_name": "Laidlaw",
      "origin_x": -13,
      "origin_y": 9,
      "origin": 60,
      "origin_name": "Aktinos"
    },
    {
      "dest_x": -13,
      "dest_y": 9,
      "dest": 60,
      "dest_name": "Aktinos",
      "origin_x": -8,
      "origin_y": 8,
      "origin": 61,
      "origin_name": "Laidlaw"
    },
    {
      "dest_x": -15,
      "dest_y": 7,
      "dest": 59,
      "dest_name": "BNR-Petronius",
      "origin_x": -11,
      "origin_y": 2,
      "origin": 62,
      "origin_name": "Deaton"
    },
    {
      "dest_x": -10,
      "dest_y": 10,
      "dest": 3,
      "dest_name": "Juliard",
      "origin_x": -12,
      "origin_y": 5,
      "origin": 63,
      "origin_name": "Vaughan"
    },
    {
      "dest_x": -1,
      "dest_y": 5,
      "dest": 58,
      "dest_name": "Jevon",
      "origin_x": 3,
      "origin_y": 7,
      "origin": 64,
      "origin_name": "Carroll"
    },
    {
      "dest_x": 1,
      "dest_y": 3,
      "dest": 65,
      "dest_name": "BNR-Moore",
      "origin_x": 3,
      "origin_y": 7,
      "origin": 64,
      "origin_name": "Carroll"
    },
    {
      "dest_x": 2,
      "dest_y": 10,
      "dest": 67,
      "dest_name": "McLain",
      "origin_x": 3,
      "origin_y": 7,
      "origin": 64,
      "origin_name": "Carroll"
    },
    {
      "dest_x": 3,
      "dest_y": 7,
      "dest": 64,
      "dest_name": "Carroll",
      "origin_x": 1,
      "origin_y": 3,
      "origin": 65,
      "origin_name": "BNR-Moore"
    },
    {
      "dest_x": -1,
      "dest_y": 8,
      "dest": 66,
      "dest_name": "Allais",
      "origin_x": 1,
      "origin_y": 3,
      "origin": 65,
      "origin_name": "BNR-Moore"
    },
    {
      "dest_x": 1,
      "dest_y": 3,
      "dest": 65,
      "dest_name": "BNR-Moore",
      "origin_x": -1,
      "origin_y": 8,
      "origin": 66,
      "origin_name": "Allais"
    },
    {
      "dest_x": 3,
      "dest_y": 7,
      "dest": 64,
      "dest_name": "Carroll",
      "origin_x": 2,
      "origin_y": 10,
      "origin": 67,
      "origin_name": "McLain"
    },
    {
      "dest_x": -1,
      "dest_y": 5,
      "dest": 58,
      "dest_name": "Jevon",
      "origin_x": -4,
      "origin_y": 1,
      "origin": 68,
      "origin_name": "Grice"
    },
    {
      "dest_x": 10,
      "dest_y": -10,
      "dest": 2,
      "dest_name": "Tyson",
      "origin_x": -6,
      "origin_y": 2,
      "origin": 69,
      "origin_name": "Moore"
    },
    {
      "dest_x": -25,
      "dest_y": -7,
      "dest": 71,
      "dest_name": "Archer",
      "origin_x": -6,
      "origin_y": 2,
      "origin": 69,
      "origin_name": "Moore"
    },
    {
      "dest_x": 5,
      "dest_y": 8,
      "dest": 72,
      "dest_name": "Braess",
      "origin_x": -6,
      "origin_y": 2,
      "origin": 69,
      "origin_name": "Moore"
    },
    {
      "dest_x": 10,
      "dest_y": -10,
      "dest": 2,
      "dest_name": "Tyson",
      "origin_x": 5,
      "origin_y": -24,
      "origin": 70,
      "origin_name": "Galileo"
    },
    {
      "dest_x": -6,
      "dest_y": 2,
      "dest": 69,
      "dest_name": "Moore",
      "origin_x": -25,
      "origin_y": -7,
      "origin": 71,
      "origin_name": "Archer"
    },
    {
      "dest_x": -6,
      "dest_y": 2,
      "dest": 69,
      "dest_name": "Moore",
      "origin_x": 5,
      "origin_y": 8,
      "origin": 72,
      "origin_name": "Braess"
    }
  ]
};

  function init() {

    var linksys = [];
    var newlinks = [];
    var oldX;

    function systemDot(data) {
      var circle = new createjs.Shape();
      circle.sysdata = data;
      x = Math.abs(circle.sysdata.coord_x*10)+5;
      y = Math.abs(circle.sysdata.coord_y*10)+5;
      circle.graphics.beginFill(circle.sysdata.color).drawCircle(x,y,5);
      circle.graphics.beginFill(circle.sysdata.color2).drawCircle(x,y,4);
      circle.graphics.beginFill(circle.sysdata.color).drawCircle(x,y,3);
      var text = new createjs.Text(circle.sysdata.name,"10px Helvetica",circle.sysdata.color);
      text.x = x-5;
      text.y = y+5;
      circle.on("click", function(event) {
        $('#sysname').text(event.target.sysdata.name);
        linksys.push(event.target.sysdata);
        if(linksys.length == 2) {
          connectSystems(linksys);
          linksys = [];
        }   
        // stage.on("stagemousemove",function(evt) {
        //   if (linksys.length == 1) {
        //     var templine = new createjs.Shape();
        //     x = Math.abs(linksys[0].coord_x*10)+5;
        //     y = Math.abs(linksys[0].coord_y*10)+5;
        //     templine.graphics.setStrokeStyle(1).beginStroke('grey').mt(x,y).lt(evt.stageX,evt.stageY);
        //     stage.addChild(templine);
        //     stage.update();
        //   }
        // });
      });
        
      stage.addChild(circle);
      stage.addChild(text);
    }
    function jumpLine(data) {
      dx = Math.abs(data.dest_x*10)+5;
      dy = Math.abs(data.dest_y*10)+5;
      ox = Math.abs(data.origin_x*10)+5;
      oy = Math.abs(data.origin_y*10)+5;
      var line = new createjs.Shape();
      line.graphics.mt(ox,oy).setStrokeStyle(1).beginStroke('#000').lt(dx,dy).lt(ox,oy);
      stage.addChild(line);
    }

    function connectSystems(data) {
      dx = Math.abs(data[0].coord_x*10)+5;
      dy = Math.abs(data[0].coord_y*10)+5;
      ox = Math.abs(data[1].coord_x*10)+5;
      oy = Math.abs(data[1].coord_y*10)+5;
      var line = new createjs.Shape();
      line.graphics.setStrokeStyle(1).beginStroke('grey').mt(dx,dy).lt(ox,oy);
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
    var jumps = connections.data;
    //for (var i = jumps.length - 1; i >= 0; i--) {
    //  jumpLine(jumps[i]);
    //};

    for (var i = sys.length - 1; i >= 0; i--) {
      systemDot(sys[i]);
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
<h3>Galaxy Map <smalL>Click on systems to link</smalL></h3>
<p id="sysname">&nbsp;</p>
<canvas id="demoCanvas" width="500" height="500"></canvas>
</div>
<div class="col-md-3">
<h3>JSON output</h3>
<pre class='newlinkjson'>&nbsp;</pre>
</div>
</div>
<?php

require_once('footer.php');
