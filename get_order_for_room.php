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

		if (isset($_REQUEST['room_num']) && isset($_REQUEST['date'])) {
			$room_num = $_REQUEST['room_num'];
			$date = $_REQUEST['date'];
			$staff_id = $_REQUEST['staff_id'];
			$sql1 = "SELECT * FROM `order_status` WHERE  room_num = $room_num AND staff_id = $staff_id AND start_time LIKE  '%$date%' ORDER BY order_id DESC";
			$result = mysqli_query($con,$sql1);
			$response["order"] = array();
			if (mysqli_num_rows($result) > 0) {
				$order = array();
				while ($obj=mysqli_fetch_object($result)){
					$order["order_id"] = $obj->order_id;
					$order["room_num"] = $obj->room_num;
					$order["start_time"] = $obj->start_time;
					$order["end_time"] = $obj->end_time;
					$order["order_status"] = $obj->order_status;
					$order["last_modification_time"] = $obj->last_modification_time;
					$order["comment"] = $obj->comment;
					array_push($response["order"], $order);
				}
				$response["success"] = true;
				$response["message"] = "Order found.";
			}else{
				$response["success"] = false;
				$response["message"] = "No order found.";
			}
		}else{
			$response["success"] = false;
			$response["message"] = "Required field(s) is missing";
		}
		mysqli_free_result($result);
		echo json_encode($response);
		mysqli_close($con);
		?>