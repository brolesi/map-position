<?php
require_once('connection.php');
list($bullet_width, $bullet_height) = getimagesize('bullet.png'); 
$result       = $db->query('SELECT * FROM positions WHERE date=(SELECT MAX(date) FROM positions);');
$last_entry   = $result->fetch();
$map          = imagecreatefromjpeg('map.jpg');
$bullet       = imagecreatefrompng('bullet.png');
$bullet_pos_x = $last_entry['pos_x'];
$bullet_pos_y = $last_entry['pos_y'];


imagesavealpha($bullet, false);
imagealphablending($bullet, false);
imagecopy($map, $bullet, $bullet_pos_x, $bullet_pos_y, 0, 0, $bullet_width, $bullet_height);


header('Content-Type: image/jpg');
imagejpeg($map, null, 80); 
?>
