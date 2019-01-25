<?php
// required headers
/*header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");*/
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
$result = mysqli_query($con,"SELECT * FROM `room`");
if (!empty($result)) {
	if (mysqli_num_rows($result) > 0) {
		$response["room"] = array();
		while ($obj=mysqli_fetch_object($result)){
			$room = array();
			$room["room_num"] = $obj->room_num;
			$room["room_type_num"] = $obj->room_type_num;
			$room["floor"] = $obj->floor;
			array_push($response["room"], $room);
		}
		$response["success"] = true;
		$response["message"] = "Room list found.";
		//echo json_encode($response);
	}else{
		$response["success"] = false;
		$response["message"] = "No room found.";
	}
}else{
	$response["success"] = false;
	$response["message"] = "No room found.";
}
mysqli_free_result($result);
echo json_encode($response);
mysqli_close($con);
?>