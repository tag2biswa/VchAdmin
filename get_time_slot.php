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
			$response["time_table"]= array();
			$result = mysqli_query($con,"SELECT * FROM `time_table` WHERE cat_id = $cat_id");
			if (mysqli_num_rows($result) > 0) {
				while ($obj=mysqli_fetch_object($result)){
					$tt = array();
					$tt["cat_id"] = $obj->cat_id;
					$tt["start_time"] = $obj->start_time;
					$tt["end_time"] = $obj->end_time;
					$tt["time_id"] = $obj->time_id;
					array_push($response["time_table"], $tt);
					}
					$response["success"] = true;
					$response["message"] = "time slot found.";
				}else{
					$response["success"] = false;
					$response["message"] = "time slot not found.";
				}
			
		}else{
			$response["success"] = false;
			$response["message"] = "Required field(s) is missing";
		}
	
		
		mysqli_free_result($result);
		echo json_encode($response);
		mysqli_close($con);
		?>