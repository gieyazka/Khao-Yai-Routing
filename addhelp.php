<?php
if(!isset($_POST['action'])){
	header('location:login.php');
}
require_once("connect.php");
SESSION_START();
echo $_POST['action'] ;
print_r($_POST);
if(isset($_POST['action']) && $_POST['action'] == "1"){
	$_SESSION['lat'] = $_POST["lat"];
	$_SESSION['lon'] = $_POST["lon"];
	echo "bbb" ;
}
 if(isset($_POST['action']) && ($_POST['action'] == "2")){
	print_r($_POST);
	$lat = $_SESSION['lat'];
	$lon = $_SESSION['lon'];
	
	$name = $_POST['name'];
	$tel = $_POST['tel'];
	$data = $_POST['detail'];

	$sql = "INSERT INTO `help`(`latitude`, `longitude`, `Tel`, `name`, `description`, `Used`, `date`) 
	VALUES ('{$lat}','{$lon}','{$tel}','{$name}','{$data}','Yes',NOW())" ;
	echo "$sql" ;
	$result = $con->query($sql);
	if($result){
		echo "success";
	}else{
		echo "fail";
	}
	exit();
}

?>
