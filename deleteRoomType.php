<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['room_type_num']) {
	$roomtypenum = $_REQUEST['room_type_num'];

	$sqlroom = "SELECT `room_num` FROM `room` WHERE `room_type_num` = $roomtypenum";
	$resroom = mysqli_query($con, $sqlroom);
	while ( $objroom=mysqli_fetch_object($resroom)) {
		$sqldishdel = "DELETE FROM room WHERE room_num=$objroom->room_num";
		$resdishdel = mysqli_query($con, $sqldishdel);
	}
	$sqlmenudel = "DELETE FROM room_type WHERE room_type_num=$roomtypenum";
	$resultset = mysqli_query($con, $sqlmenudel) or die("database error:". mysqli_error($con));
	if($resultset) {
		echo "Room Type Deleted successfully.";
	}
}
?>