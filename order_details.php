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

		if (isset($_REQUEST['order_id'])) {
			$orderid = $_REQUEST['order_id'];
				$sql2 = "SELECT * FROM `order_details` WHERE  order_id = $orderid";
					$result2 = mysqli_query($con,$sql2);
					if (mysqli_num_rows($result2) > 0) {
						$response["order_details"] = array();
						while ($d_obj=mysqli_fetch_object($result2)){
							$sql3 = "SELECT * FROM `dish` WHERE dish_id = $d_obj->dish_id";
							$result3 = mysqli_query($con,$sql3);
							if (mysqli_num_rows($result3) > 0) {
								$dish_obj=mysqli_fetch_object($result3);
								$order_details =  array();
								$order_details["order_id"] = $d_obj->order_id;
								$order_details["dish_id"] = $d_obj->dish_id;
								$order_details["dish_price"] = $d_obj->dish_price;
								$order_details["qty"] = $d_obj->qty;
								$order_details["dish_name"] = $dish_obj->dish_name;
								$order_details["dish_img"] = $dish_obj->dish_img;
								array_push($response["order_details"], $order_details);
							}
						}
					}else{
						$response["order_details"] =  array();
					}
				//array_push($response["order"], $order);
				$response["success"] = true;
				$response["message"] = "Order found.";
			}else{
				$response["success"] = false;
				$response["message"] = "Parameter missing.";
			}
		
		//mysqli_free_result($result);
		echo json_encode($response);
		mysqli_close($con);
		?>