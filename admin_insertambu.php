<?php
require_once('connect.php');
session_start();
if(!isset($_POST['username'])){
	header('location:login.php');
}
echo "<meta http-equiv='Content-Security-Policy' content='upgrade-insecure-requests'>";
$sid = session_id();
$username = $_POST['username'];
date_default_timezone_set("Asia/Bangkok");
$date =  date("Y-m-d H:i:s",time()) ;
$password = md5($_POST['password']).md5($date);
$Name = $_POST['Name'];
$Lastname = $_POST['Lastname'];
$Tel = $_POST['Tel'];
$Email = $_POST['Email'];
$Active =  "Yes";
$sql = "SELECT * from user_position where username = '".$username."' or Email = '".$Email."'" ;

$query = mysqli_query($con,$sql);
$result = mysqli_fetch_array($query,MYSQLI_ASSOC);
if($result){?>
   <script language ="javascript"> 
    alert("มี Username หรือ Email ซ้ำ")
    window.location='adminambu.php' 
  </script>
  <?php
}else{
$sql = "INSERT INTO user_position (username,Password,Name,Lastname,Tel,Email,Status,Active,timestamp) VALUES ('".$username."','".$password."','".$Name."',
'".$Lastname."','".$Tel."','".$Email."','Ambulance','Yes','".$date."')" ;
// echo $sql;
$query = mysqli_query($con,$sql);
// $result =mysqli_fetch_array($query);
if(!$query){ ?>
   <script language ="javascript">
 alert("เพิ่มข้อมูลล้มเหลว")
  window.location='adminambu.php' 
</script> ; <?php
 
//  header('Location: emptable.php');
}
else { ?>
   <script language ="javascript">
 alert("เพิ่มข้อมูลสำเร็จ")
  window.location='adminambu.php' 
</script> ; <?php

// header('Location: emptable.php');    
}

}
?>