<?php 
if(!isset($_POST['id'])){
	header('location:login.php');
}
require_once("connect.php");
 $id = $_POST["id"];
 $sql = "DELETE FROM `locations` WHERE `id`= ".$id;
 echo $sql;
 $result = $con->query($sql);
 echo "success";
?>