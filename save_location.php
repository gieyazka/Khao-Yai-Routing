<?php
require_once("connect.php");
// print_r($_REQUEST);
$lat= $_REQUEST['myPosition_lat'];
$lon = $_REQUEST['myPosition_lon'];
$user = $_REQUEST['user'];
$name = $_REQUEST['name'];
$sql = "update user_position SET user_latitude='". $lat ."', user_longitude='". $lon ."'  WHERE username='". $user ."'";
echo $sql ;
$result = $con->query($sql);
echo $result;


?>