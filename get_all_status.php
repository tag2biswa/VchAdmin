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
$result = mysqli_query($con,"SELECT * FROM `status_type`");
if (!empty($result)) {
	if (mysqli_num_rows($result) > 0) {
		$response["status_type"] = array();
		while ($obj=mysqli_fetch_object($result)){
			$order = array();
			$order["status_id"] = $obj->status_id;
			$order["status_type"] = $obj->status_type;
			array_push($response["status_type"], $order);
		}
		$response["success"] = true;
		$response["message"] = "order status list found.";
		//echo json_encode($response);
	}else{
		$response["success"] = false;
		$response["message"] = "No order status found.";
	}
}else{
	$response["success"] = false;
	$response["message"] = "No order status found.";
}
mysqli_free_result($result);
echo json_encode($response);
mysqli_close($con);
?>