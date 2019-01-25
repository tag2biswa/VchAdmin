<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['room_num']) {
	$roomtypenum = $_REQUEST['room_num'];

	$sqlroom = "SELECT `room_num` FROM `room` WHERE `room_num` = $roomtypenum";
	$resroom = mysqli_query($con, $sqlroom);
	while ( $objroom=mysqli_fetch_object($resroom)) {
		$sqldishdel = "SELECT `order_id` FROM `order_status` WHERE `room_num` = $roomtypenum";
		$resdishdel = mysqli_query($con, $sqldishdel);
			while ( $objord=mysqli_fetch_object($resdishdel)) {
				$sqlorddel = "DELETE FROM order_details WHERE order_id=$objord->order_id";
				$resultorddel = mysqli_query($con, $sqlorddel) or die("database error:". mysqli_error($con));
			}
		$sqlorsdel = "DELETE FROM order_status WHERE room_num=$roomtypenum";
		$resultorsdel = mysqli_query($con, $sqlorsdel) or die("database error:". mysqli_error($con));
	}
	$sqlmenudel = "DELETE FROM room WHERE room_num=$roomtypenum";
	$resultset = mysqli_query($con, $sqlmenudel) or die("database error:". mysqli_error($con));
	if($resultset) {
		echo "Room Deleted successfully.";
	}
}
?>