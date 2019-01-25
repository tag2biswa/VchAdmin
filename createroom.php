<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();

if (isset($_REQUEST['room_num'])) {
	$room_num = $_REQUEST['room_num'];
	
	$result = mysqli_query($con,"INSERT INTO `room` (`room_num`, `room_type_num`, `floor`) VALUES ('$room_num', 1, 0)");
	if ($result) {
		$response["success"] = true;
		$response["message"] = "Room successfully created.";
		echo json_encode($response);
	}else{
		$response["success"] = false;
        $response["message"] = "Oops! An error occurred.";
        $response["dberror"] = mysqli_error($con);
        echo json_encode($response);
	}
}else{
	$response["success"] = false;
    $response["message"] = "Required field(s) is missing";
    echo json_encode($response);
}
mysqli_close($con);
?>