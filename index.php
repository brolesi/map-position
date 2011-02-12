<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-BR">
<?php
require_once('connection.php');
if(isset($_REQUEST['show_all']) && (int)$_REQUEST['show_all'] == 1)
{
}
else
{
  $result = $db->query('SELECT * FROM positions WHERE date=(SELECT MAX(date) FROM positions);');
  if($result)
  {
    $last_entry = $result->fetch();
  }
}
list($bullet_width, $bullet_height) = getimagesize('bullet.png'); 
list($map_width, $map_height) = getimagesize('map.jpg'); 

?>
  <head>
    <title></title>
    <style type="text/css">
    #map {
      background: url(map.jpg) center center no-repeat;
      height: <?php echo $map_height; ?>px;
      position: relative;
      width: <?php echo $map_width; ?>px;
    }
    .bullet
    {
      background: url(bullet.png) center center no-repeat;
      height: <?php echo $bullet_height; ?>px;
      position: absolute;
      width:<?php echo $bullet_width; ?>px;
      top: <?php echo $last_entry['pos_y'] ?>px;
      left: <?php echo $last_entry['pos_x'] ?>px;
    }
    </style>
  </head>
  <body>
    <h1>Where is the car</h1>
    <div id="map">
      <div id="bullet0" class="bullet">
      </div>
    </div>
    <form action="save_data.php" method="post">
      <input type="hidden" name="pos_x" id="pos_x" />
      <input type="hidden" name="pos_y" id="pos_y" />
      <input type="submit" value="Save position" />
    </form>
    <a href="image.php?id= <?php echo $last_entry['id'] ?>">Get last position image</a>
    <script type="text/javascript">
      var IE = document.all ? true : false;
      if (!IE) { document.captureEvents(Event.MOUSEMOVE);}
      document.onmousemove = get_mouse_position;
      var tempX    = 0;
      var tempY    = 0;
      var bullet_w = <?php echo $bullet_width; ?>;
      var bullet_h = <?php echo $bullet_height; ?>;
      document.getElementById('map').addEventListener('click',drop_bullet,false);
      
      function get_by_id(id)
      {
        return document.getElementById(id);
      }
      
      function get_mouse_position(e) {
        if (IE) {
          tempX = event.clientX + document.body.scrollLeft;
          tempY = event.clientY + document.body.scrollTop;
        } else {
          tempX = e.pageX;
          tempY = e.pageY;
        }  
        if (tempX < 0){tempX = 0;}
        if (tempY < 0){tempY = 0;}  

      }
      
      function drop_bullet(e)
      {
        var bullet = get_by_id('bullet0');
        map_position             = findPos(get_by_id('map'));
        px                       = tempX - map_position[0] - bullet_h / 2;
        py                       = tempY - map_position[1] - bullet_w / 2;
        bullet.style.top         = py;
        bullet.style.left        = px;
        get_by_id('pos_x').value = px;
        get_by_id('pos_y').value = py;
        
        
      }
      
      function findPos(obj) {
	      var curleft = 0;
        var curtop  = 0;
        if (obj.offsetParent) {
          do {
	      		curleft += obj.offsetLeft;
			      curtop += obj.offsetTop;
        	} 
          while (obj = obj.offsetParent);
        }
        return [curleft,curtop];
      }
    </script>
  </body>
</html>
