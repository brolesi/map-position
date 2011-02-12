<?php

require_once('connection.php');


$db->query('TRUNCATE TABLE positions');

$result = $db->query("SHOW TABLES LIKE 'positions'");
print_r($result);
if(!$result)
{
  try{
    
    /*$create_table = 'TRUNCATE TABLE positions';
    $result_create = $db->query($create_table);*/
    $create_table = 'CREATE TABLE IF NOT EXISTS positions (id INTEGER PRIMARY KEY, date DATETIME, pos_x INTEGER, pos_y INTEGER);';
    $result_create = $db->query($create_table);
    //print_r($result_create);
  }
  catch (Exception $e) {
    $db->rollBack();
    echo "Failed: " . $e->getMessage();
  }
}
$sql_put_data = "INSERT INTO positions VALUES (null, '" . date("Y-m-d H:i:s") . "', '". (int)$_REQUEST['pos_x'] . "', '". (int)$_REQUEST['pos_y'] . "');";
$db->query($sql_put_data) or die('ERRO');
header('location: index.php');
?>
