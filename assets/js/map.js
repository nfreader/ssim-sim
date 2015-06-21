function sysDot(x, y, color, title, id) {
        if (color == undefined) {
          var color = '#FFF';
        }
        context.beginPath();
        context.arc(newx, newy, 2, 0, 2 * Math.PI, false);
        context.strokeStyle = color;
        context.fillStyle = color;
        context.fill();
        context.stroke();
    context.beginPath();
        context.font = 'normal 10pt Helvetica';
        context.fillStyle = color;
    context.fillText(title+' ('+newx+','+newy+') ('+ id +')',newx+5,newy+5);
}

$(document).ready(function(){

  function sysDot(sys) {
    context.beginPath();
    context.arc(sys.coord_x+64,sys.coord_y+64,2,0,2*Math.PI,false);
    context.strokeStyle = '#000';
    context.fillStyle = '#000';
    context.fill();
    context.stroke();
    context.beginPath();
    context.font = 'normal 10pt Helvetica';
    context.fillStyle = '#000';
    context.fillText(sys.name,sys.coord_x+69,sys.coord_y+69);
  }

  var canvas = document.getElementById("temp-syst-map");
  var context = canvas.getContext("2d");
  context.beginPath();
  //context.clearRect(0, 0, canvasW, canvasH);
  for (var x = 0.5; x < canvas.width; x += 10) {
    context.moveTo(x, 0);
    context.lineTo(x, canvas.height);
  }
  
  for (var y = 0.5; y < canvas.height ; y += 10) {
    context.moveTo(0, y);
    context.lineTo(canvas.width, y);
  }
  
  context.strokeStyle = "#eee";
  context.stroke();
  
  for (var i = systems.length - 1; i >= 0; i--) {
    sysDot(systems[i]);
  };
});