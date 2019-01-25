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
			$result = mysqli_query($con,"SELECT * FROM `menu` WHERE  cat_id = '".$_GET["cat_id"]."'");
			if (mysqli_num_rows($result) > 0) {
					$response = array();
					while ($obj=mysqli_fetch_object($result)){
						/*$category = array();
						$category["cat_id"] = $obj->cat_id;
						$category["cat_name"] = $obj->cat_name;
						array_push($response["category"], $category);*/
						$response[] = array(
							'menu_id' => $obj->menu_id,
							'menu_name' => $obj->menu_name
						);
					}
					//echo json_encode($response);
			}
			mysqli_free_result($result);
			echo json_encode($response);
			mysqli_close($con);
	?>