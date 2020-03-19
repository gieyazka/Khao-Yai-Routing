
<?php
session_start();
if (!isset($_POST['Username'])) {
  header('location:login.php');
}
if (isset($_POST['Username'])) {

  require_once("connect.php");
  
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
  $sql = "SELECT * FROM `member` WHERE Username = '" . trim($_POST['Username'])."' " ;
  $query = $con->query($sql) ;
  $data = $query -> fetch_assoc();
  // print_r($data);

  $Password = md5($_POST['Password']).md5($data['timestamp']);




  $sql = "SELECT * FROM member WHERE Username = '" . trim($_POST['Username']) . "' 
        and Password = '" . trim($Password) . "'
        and Active = 'Yes' ";
  $result = mysqli_query($con, $sql);

  if (mysqli_num_rows($result) == 1) {

    $row = mysqli_fetch_array($result);

    $_SESSION["username"] = $row["Username"];
    $_SESSION["User"] = $row["Name"];
    $_SESSION["type"] = $row["Status"];
    $_SESSION["Lastname"] = $row["Lastname"];
    $_SESSION["email"] = $row["Email"];
    $_SESSION['Tel'] = $row['Tel'];

    if ($_SESSION["type"] == "employee") { //ถ้าเป็น employee ให้กระโดดไปหน้า em-index.php

      header("Location: dashboard.php");
    }

    if ($_SESSION["type"] == "USER") {  //ถ้าเป็น member ให้กระโดดไปหน้า user_page.php
      header("Location: user-index.php");
    }
    if ($_SESSION["type"] == "admin") {  //ถ้าเป็น member ให้กระโดดไปหน้า user_page.php
      header("Location: adminem.php");
    }
    if ($_SESSION["type"] == "ambulance") { //ถ้าเป็น ambulance ให้กระโดดไปหน้า ambulancemap.php

      header("Location: ambulancemap.php");
    }
  } else {
    $sql = "SELECT * FROM `user_position` WHERE username = '" . trim($_POST['Username'])."' " ;
      $query = $con->query($sql) ;
      $data = $query -> fetch_assoc();
      // print_r($data);
      // echo "$sql";
      $Password = md5($_POST['Password']).md5($data['timestamp']);
      // $Password = md5(11111111);
      // echo "<br>".$_POST['Password'] ;
      // echo "<br>".md5($_POST['Password']) ;
      // echo "<br>$Password";
    $sql = "SELECT * FROM `user_position` WHERE username = '" . trim($_POST['Username']) . "' 
        and Password = '" . trim($Password) . "'
        and Active = 'Yes' ";

    $result = $con->query($sql);
    if (mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_array($result);

      $_SESSION["username"] = $row["username"];
      $_SESSION["User"] = $row["Name"];
      $_SESSION["type"] = $row["Status"];
      $_SESSION["Lastname"] = $row["Lastname"];
      $_SESSION["email"] = $row["Email"];
      echo $_SESSION["type"];
      if ($_SESSION["type"] == "Ambulance") { //ถ้าเป็น ambulance ให้กระโดดไปหน้า ambulancemap.php

        header("Location: ambulancemap.php");
      }
    } else {
      echo "<script>";
      echo "alert(\" user หรือ  password ไม่ถูกต้อง\");";
      // echo "window.history.back()";
      echo "</script>";
    }
  }
} else {




  Header("Location: login.php"); //ไมม่ีค่า username ส่งมา

}
?>