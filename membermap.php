<?php require_once 'locations_model.php'; ?>
<?php require_once 'connect.php'; ?>
<?php SESSION_START();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8'); ?>
<?php

//*** Select วันที่ในตาราง Counter ว่าปัจจุบันเก็บของวันที่เท่าไหร่  ***//
//*** ถ้าเป็นของเมื่อวานให้ทำการ Update Counter ไปยังตาราง daily และลบข้อมูล เพื่อเก็บของวันปัจจุบัน ***//
$sql = " SELECT DATE FROM counter LIMIT 0,1";
$query = $con->query($sql);
$row = $query->fetch_assoc();
if ($row["DATE"] != date("Y-m-d")) {
	//*** บันทึกข้อมูลของเมื่อวานไปยังตาราง daily ***//
	$sql = " INSERT INTO daily (DATE,NUM) SELECT '" . date('Y-m-d', strtotime("-1 day")) . "',COUNT(*) AS intYesterday FROM  counter WHERE 1 AND DATE = '" . date('Y-m-d', strtotime("-1 day")) . "'";
	$query = $con->query($sql);

	//*** ลบข้อมูลของเมื่อวานในตาราง counter ***//
	$sql = " DELETE FROM counter WHERE DATE != '" . date("Y-m-d") . "' ";
	$query = $con->query($sql);
}

//*** Insert Counter ปัจจุบัน ***//
$sql = " INSERT INTO counter (DATE,IP) VALUES ('" . date("Y-m-d") . "','" . $_SERVER["REMOTE_ADDR"] . "') ";
$query = $con->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!--font-family-->
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- title of site -->
	<title>อุทยานแห่งชาติเขาใหญ่</title>
	<!-- For favicon png -->
	<link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png" />

	<!--font-awesome.min.css-->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">

	<!--animate.css-->
	<link rel="stylesheet" href="assets/css/animate.css">

	<!--flaticon.css-->
	<link rel="stylesheet" href="assets/css/flaticon.css">

	<!--bootstrap.min.css-->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!--style.css-->
	<link rel="stylesheet" href="assets/css/style.css">

	<!--responsive.css-->
	<link rel="stylesheet" href="assets/css/responsive.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<style>
		.footer {
			position: fixed;
			left: 0;
			bottom: 0;
			width: 100%;
			background-color: #0d47a1;


		}
	</style>
	<style>
		img {
			width: 100%;
			height: 500px;
			object-fit: cover;
			background-repeat: no-repeat;
			background-size: cover;
		}

		#contain_map {
			position: relative;
			width: 75%;
			height: 200px;
			margin: auto;
		}

		/* css กำหนดความกว้าง ความสูงของแผนที่ */
		#map_canvas {
			overflow: hidden;
			padding-bottom: 56.25%;
			position: relative;
			height: 200%;
		}
	</style>
</head>

<!-- <body Onload = "bodyOnload();" id="page-top">
	 -->

<body id="page-top">
	<section class="top-area">
		<nav class="navbar navbar-expand-lg navbar-dark " id="mainNav">
			<div class="container">
				<a class="navbar-brand js-scroll-trigger" href="#page-top">Khao Yai</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa fa-bars"></i>
				</button>
				<div class="collapse navbar-collapse nav-responsive-list" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">

						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="index.html">หน้าแรก</a>
						</li>
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="howto.pdf">คู่มือการใช้งาน</a>
						</li>
						<!--/.nav-item-->
						<li class="nav-item">
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="https://www.google.com/maps/d/u/1/edit?mid=1bueiOTbkCEPaFmGEiQoEpl9VlzKCTrD5&ll=14.365375032066165%2C101.36685480000006&z=11">แผนที่ออฟไลน์</a>
						</li>
						<!--/.nav-item-->
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">ขอความช่วยเหลือ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="https://docs.google.com/forms/d/1QEayEkpIPAttu86zIdQoVjQtgXBVQQkEOuH9uTJhODk/edit">แบบสอบถาม</a>
						</li>
						<li class="nav-item">
							<a class="nav-link js-scroll-trigger" href="login.php">สำหรับเจ้าหน้าที่</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</section>

	<div id="contain_map">
		<div id="map_canvas">&nbsp;</div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">ขอความช่วยเหลือ</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form id="form_user">
						<div class="form-group">
							<label for="name" class="col-form-label">ชื่อ</label>
							<input type="text" class="form-control" id="name" name="name" autocomplete="off">
							<label for="tel" class="col-form-label">เบอร์โทร</label>
							<input type="text" class="form-control" id="tel" name="tel" autocomplete="off">
							<label for="detail" class="col-form-label">ข้อความ</label>
							<input type="text" class="form-control" id="detail" name="detail" autocomplete="off">
						</div>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onClick="dataList.addData($('#form_user').serializeArray());">Submit</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

	<script type="text/javascript">
		var geocoder;
		var my_Marker;

		var map;
		var GGM;
		var my_Latlng;

		var autocomplete;
		var bb;
		var cc;

		var myPosition_lat;
		var myPosition_lon;

		function initialize() {
			GGM = new Object(google.maps);
			directionShow = new GGM.DirectionsRenderer({
				draggable: true
			});
			directionsService = new GGM.DirectionsService();
			geocoder = new GGM.Geocoder();

			navigator.geolocation.getCurrentPosition(function(position) {

				var pos = new GGM.LatLng(position.coords.latitude, position.coords.longitude);

				my_Latlng = new GGM.LatLng(position.coords.latitude, position.coords.longitude);

				initialTo = new GGM.LatLng(14.439424, 101.372485);
				var my_mapTypeId = GGM.MapTypeId.ROADMAP;
				var my_DivObj = $("#map_canvas")[0];

				var myOptions = {
					zoom: 13,
					center: my_Latlng,
					mapTypeId: my_mapTypeId
				};

				map = new GGM.Map(my_DivObj, myOptions);
				directionShow.setMap(map);
				var infowindow = new GGM.InfoWindow({
					map: map,
					position: my_Latlng,
					content: 'คุณอยู่ที่นี่.'
				});

				var my_Point = infowindow.getPosition();
				map.panTo(my_Point);
				$("#lat_value").val(my_Point.lat());
				$("#lon_value").val(my_Point.lng());
				$("#zoom_value").val(map.getZoom());
				map.setCenter(my_Latlng);
				inputSearch = $("#pac-input")[0];
				map.controls[GGM.ControlPosition.TOP_LEFT].push(inputSearch);
				infowindow = new GGM.InfoWindow();
				my_Marker = new GGM.Marker({
					map: map,
					anchorPoint: new GGM.Point(0, -29)
				});
			});

			navigator.geolocation.watchPosition(function(position) {

				var myPosition_lat = position.coords.latitude;
				var myPosition_lon = position.coords.longitude;


				var pos = new GGM.LatLng(myPosition_lat, myPosition_lon);
				$.post("addhelp.php", {
					lat: myPosition_lat,
					lon: myPosition_lon,
					action: 1
				});

				var pos = new GGM.LatLng(myPosition_lat, myPosition_lon);

				my_Marker.setPosition(pos);

				var my_Point = my_Marker.getPosition();
				$("#lat_value").val(my_Point.lat());
				$("#lon_value").val(my_Point.lng());
				$("#zoom_value").val(map.getZoom());




				map.panTo(pos);
				map.setCenter(pos);
				var red_icon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
				var a = <?php load_am(); ?>;

				for (var j = 0; j < a.length; j++) {
					var ic = "image/ambulance.png";
					marker = new google.maps.Marker({
						position: new google.maps.LatLng(a[j][3], a[j][4]),
						map: map,
						icon: ic


					});
				}
				var locations = <?php get_confirmed_locations() ?>; /*marker*/
				var i;
				var confirmed = 0;
				for (i = 0; i < locations.length; i++) {
					if (locations[i][5] == '1') {
						var ic = "image/pong.png";
					} else if (locations[i][5] == '2') {
						var ic = "image/2.png";
					} else if (locations[i][5] == '3') {
						var ic = "image/waterfall.png";
					} else if (locations[i][5] == '5') {
						var ic = "image/park.png";
					} else if (locations[i][5] == '4') {
						var ic = "image/info.png";
					} else if (locations[i][5] == '6') {
						var ic = "image/viewpoint.png";
					} else if (locations[i][5] == '7') {
						var ic = "image/boat.png";
					} else if (locations[i][5] == '8') {
						var ic = "image/tent.png";
					} else if (locations[i][5] == '9') {
						var ic = "image/home.png";
					} else if (locations[i][5] == '10') {
						var ic = "image/temple.png";
					} else if (locations[i][5] == '11') {
						var ic = "image/map.png";
					} else if (locations[i][5] == '12') {
						var ic = "image/toilet.png";
					} else if (locations[i][5] == '13') {
						var ic = "image/road.png";
					} else if (locations[i][5] == '14') {
						var ic = "image/lake.png";
					} else if (locations[i][5] == '15') {
						var ic = "image/food.png";
					} else if (locations[i][5] == '0') {
						var ic = "image/wifi.png";
					} else {
						var ic = red_icon;
					}

					marker = new google.maps.Marker({
						position: new google.maps.LatLng(locations[i][1], locations[i][2]),
						map: map,
						icon: ic,
						html: "<div>\n" +
							"<table class=\"map1\">\n" +
							"<tr>\n" +
							"<td><a>รายละเอียด :  </a></td>\n" +
							"<td> " + locations[i][3] + "</td></tr>\n" +
							"</table>\n" +
							"</div>"
					});

					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow = new google.maps.InfoWindow();
							var confirmed = locations[i][4] === '1' ? 'checked' : 0;
							$("#confirmed").prop(confirmed, locations[i][4]);
							$("#id").val(locations[i][0]);
							$("#description").val(locations[i][3]);
							$("#form").show();
							infowindow.setContent(marker.html);
							infowindow.open(map, marker);
						}
					})(marker, i));
				}

				function downloadUrl(url, callback) {
					var request = window.ActiveXObject ?
						new ActiveXObject('Microsoft.XMLHTTP') :
						new XMLHttpRequest;
					request.onreadystatechange = function() {
						if (request.readyState == 4) {
							callback(request.responseText, request.status);
						}
					};
					request.open('GET', url, true);
					request.send(null);
				}
			});
		}
		var dataList = {}
		$(function() {
			dataList.addData = function(dataSend) {
				// console.log(dataSend);
				// console.log(dataSend[0].value);
				var name = dataSend[0].value;
				var tel = dataSend[1].value;
				var detail = dataSend[2].value;

				$.post("addhelp.php", {

						name: name,
						tel: tel,
						detail: detail,
						action: 2
					})
					.done(function() {
						$('#form_user')[0].reset();
						alert('ส่งข้อความช่วยเหลือสำเร็จ');
						window.location.reload();
						s
					})
					.fail(function() {
						alert("error");
					})
					.always(function() {
						alert("finished");
					});

			}
		});
		$(function() {
			$("<script/>", {
				"type": "text/javascript",
				src: "//maps.google.com/maps/api/js?key=AIzaSyD0xTflD2TcRSIu_bQzF1Sa2xLMKPsMZLA&sensor=false&language=th&callback=initialize&libraries=places"
			}).appendTo("body");

		});
	</script>



	<!-- End Edit Modal -->
	<script src="assets/js/jquery.js"></script>

	<!-- popper js -->
	<script src="assets/js/popper.min.js"></script>

	<!--bootstrap.min.js-->
	<script src="assets/js/bootstrap.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

	<!--Custom JS-->
	<script src="assets/js/custom.js"></script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>


</html>
<script>
	function bodyOnload() {


		// setTimeout("window.location.reload();",20000);
		// window.location.reload();
	}
</script>