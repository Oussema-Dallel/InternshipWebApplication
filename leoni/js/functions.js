function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
      document.getElementById('fullscreen').innerHTML = "Quitter le mode plein écran";
    if (document.documentElement.requestFullScreen) {  
      document.documentElement.requestFullScreen();  
    } else if (document.documentElement.mozRequestFullScreen) {  
      document.documentElement.mozRequestFullScreen();  
    } else if (document.documentElement.webkitRequestFullScreen) {  
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
    }  
  } else {  
       document.getElementById('fullscreen').innerHTML = "Passer en mode plein écran";
    if (document.cancelFullScreen) {  
      document.cancelFullScreen();  
    } else if (document.mozCancelFullScreen) {  
      document.mozCancelFullScreen();  
    } else if (document.webkitCancelFullScreen) {  
      document.webkitCancelFullScreen();  
    }  
  }  
}


function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function startTime() {
    var today = new Date();
    var d = today.getDate();
    var month = today.getMonth()+1;
    var y = today.getFullYear();    
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML =  h + ":" + m + ":" + s;
    document.getElementById('date').innerHTML =  d + "/" + month + "/" + y;
    t = setTimeout(function () {
        startTime()
    }, 500);
}

function makepass()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    document.getElementById('defaultpassword').value = text;
}

 function PrintElem(id)
    {
        var mywindow = window.open('bon.php?id='+id, 'my div', 'height=400,width=600');
        return true;
    }
function ZoomElem(id)
    {
        var mywindow = window.open('historiquedetails.php?id='+id, 'my div', 'height=600,width=800,scrollbars=yes');
        return true;
    }