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

		if (isset($_REQUEST['cat_id'])) {
			$cat_id = $_REQUEST['cat_id'];
			$result = mysqli_query($con,"SELECT * FROM `menu`,dish WHERE cat_id = $cat_id");
			if (mysqli_num_rows($result) > 0) {
				$room = array();
				while ($obj=mysqli_fetch_object($result)){
					$room["room_num"] = $obj->room_num;
					$room["room_type_num"] = $obj->room_type_num;
					$room["floor"] = $obj->floor;
					//array_push($response["room"], $room);
				}
				$response["room"] = $room;
				$response["success"] = true;
				$response["message"] = "Room found.";
				//echo json_encode($response);
			}else{
				$response["success"] = false;
				$response["message"] = "No room found.";
			}
		}else{
			$response["success"] = false;
			$response["message"] = "Required field(s) is missing";
		}
	
		
		mysqli_free_result($result);
		echo json_encode($response);
		mysqli_close($con);
		?>