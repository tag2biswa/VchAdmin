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
			$result = mysqli_query($con,"SELECT * FROM `menu` WHERE cat_id = $cat_id AND m_isactive = 1");
			if (mysqli_num_rows($result) > 0) {
				$response["menu"]= array();
				while ($obj=mysqli_fetch_object($result)){
					$menu = array();
					$menu["menu_id"] = $obj->menu_id;
					$menu["menu_name"] = $obj->menu_name;
					$menu_id = $obj->menu_id;
					$dish_result = mysqli_query($con,"SELECT * FROM `dish` WHERE menu_id = $menu_id AND d_isactive = 1");
					if (mysqli_num_rows($dish_result) > 0) {
						$menu["dish"]= array();
						while ($d_obj=mysqli_fetch_object($dish_result)){
							$dish = array();
							$dish["dish_id"] = $d_obj->dish_id;
							$dish["dish_name"] = $d_obj->dish_name;
							$dish["dish_img"] = $d_obj->dish_img;
							$dish["dish_type"] = $d_obj->dish_type;
							$dish["price"] = $d_obj->price;
							$dish["menu_id"] = $d_obj->menu_id;
							array_push($menu["dish"], $dish);
						}
					}else{
						$menu["dish"]= array();
					}
					array_push($response["menu"], $menu);
				}
				//$response["room"] = $room;
				$response["success"] = true;
				$response["message"] = "menu found.";
				//echo json_encode($response);
			}else{
				$response["success"] = false;
				$response["message"] = "No menu found.";
			}
		}else{
			$response["success"] = false;
			$response["message"] = "Required field(s) is missing";
		}
	
		
		mysqli_free_result($result);
		echo json_encode($response);
		mysqli_close($con);
		?>