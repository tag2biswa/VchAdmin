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


		if (isset($_REQUEST['placeorder']) && isset($_REQUEST['start_time']) && isset($_REQUEST['end_time']) && isset($_REQUEST['room_num'])){
			$place_order = $_REQUEST['placeorder'];
			$room_num = $_REQUEST['room_num'];
			$start_time = $_REQUEST['start_time'];
			$end_time = $_REQUEST['end_time'];
			$place_delivery = $_REQUEST['place_delivery'];
			$staff_id = $_REQUEST['staff_id'];
			$mobile_num = $_REQUEST['mobile_num'];
			$timestamp = time();
			$flag = true;
			$arr = json_decode($place_order,true);
			foreach ($arr as $order) {
				$dish_id = $order['dishId'];
				$dish_price = $order['dishPrice'];
				$qty = $order['dishQty'];
				$sql2 = "INSERT INTO order_details (order_id,dish_id, dish_price, qty) VALUES ('$timestamp','$dish_id', '$dish_price', '$qty')";
				$res2 = mysqli_query($con, $sql2);
				if (!$res2) {
					$flag = false;
					//echo mysqli_error($con);
				}
			}
			if ($flag) {
				$sql1 = "INSERT INTO order_status (order_id, room_num, staff_id, place_delivery, mobile_num, start_time, end_time, order_status) VALUES ('$timestamp','$room_num','$staff_id','$place_delivery','$mobile_num','$start_time', '$end_time', '1')";
				//echo $sql1;
				$res = mysqli_query($con, $sql1);
				if ($res) {
					$response['order_id'] = $timestamp;
					$response['success'] = true;
					$response['message'] = "Order created successfully";

			///// Place order msg /////
					$msg = "Your%20order%20". $timestamp . "%20has%20been%20succesfully%20placed.%0A--Victoria%20Club%20Hotel--";
					$authkey = "248997AVB9cXyuB5bfaa9cf";
					$msgUrl = "http://api.msg91.com/api/sendhttp.php?country=91&sender=MSGIND&route=4&mobiles="
					. $mobile_num ."&message=". $msg ."&authkey=".$authkey;

					//echo $msgUrl;
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => $msgUrl,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "GET",
						CURLOPT_SSL_VERIFYHOST => 0,
						CURLOPT_SSL_VERIFYPEER => 0,
					));

					$responsee = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					/*if ($err) {
						echo "cURL Error #:" . $err;
					} else {
						echo $response;
					}*/

				}else{
					$response['success'] = false;
					$response['message'] = "Order not created. ".mysqli_error($con);
				}
			}else{
				$response['success'] = false;
				$response['message'] = "Order not created.";
			}
		}else{
			$response["success"] = false;
			$response["message"] = "Required field(s) is missing";
		}
		//mysqli_free_result($res);
		echo json_encode($response);
		mysqli_close($con);
		?>