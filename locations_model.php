<?php
require_once("connect.php");

// Gets data from URL parameters.
if(isset($_GET['add_location'])) {
    add_location();
}
if(isset($_GET['confirm_location'])) {
    confirm_location();
}



function add_location(){
    $con=mysqli_connect ("localhost", 'sirkysco_khaoyai', 'Gie54321','sirkysco_khaoyai');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }$con->set_charset("utf8");
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $description =$_GET['description'];
    $Type =$_GET['Type'];
    // Inserts new row with place data.
    $query = sprintf("INSERT INTO locations " .
        " (id, lat, lng, description,Type) " .
        " VALUES (NULL, '%s', '%s', '%s', '%s');",
        mysqli_real_escape_string($con,$lat),
        mysqli_real_escape_string($con,$lng),
        mysqli_real_escape_string($con,$description),
        mysqli_real_escape_string($con,$Type));
    echo $query;
    $result = mysqli_query($con,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function confirm_location(){
    $con=mysqli_connect ("localhost", 'sirkysco_khaoyai', 'Gie54321','sirkysco_khaoyai');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }$con->set_charset("utf8");
    $id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update locations set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($con,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function load_marker(){
    $con=mysqli_connect ("localhost", 'sirkysco_khaoyai', 'Gie54321','sirkysco_khaoyai');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }$con->set_charset("utf8");
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select * from help where Used ='Yes'");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    } 
}

function load_am(){
    $con=mysqli_connect ("localhost", 'sirkysco_khaoyai', 'Gie54321','sirkysco_khaoyai');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }$con->set_charset("utf8");
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"select * from user_position ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    } 
}

function get_confirmed_locations(){
    $con=mysqli_connect ("localhost", 'sirkysco_khaoyai', 'Gie54321','sirkysco_khaoyai');
    
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }$con->set_charset("utf8");
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"
select id ,lat,lng,description,location_status,Type as isconfirmed
from locations WHERE  location_status = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    } 
}
 
function get_all_locations(){
    $con=mysqli_connect ("localhost", 'sirkysco_khaoyai', 'Gie54321','sirkysco_khaoyai');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }$con->set_charset("utf8");
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"
select id ,lat,lng,description,location_status as isconfirmed
from locations
  ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
  $indexed = array_map('array_values', $rows);
  //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}
function array_flatten($array) {
    if (!is_array($array)) {
        return FALSE;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        }
        else {
            $result[$key] = $value;
        }
    }
    return $result;
}
function delData($id){
	echo $id;
}
?>