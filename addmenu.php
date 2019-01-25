<?php 

if(isset($_POST['menu_save'])){ 
			$filepath = "images/" . $_FILES["images"]["name"];
			 
			if(move_uploaded_file($_FILES["images"]["tmp_name"], $filepath)) 
			{
				echo "<img src=".$filepath." height=200 width=300 />";
			} 
			else 
			{
				echo "Error !!";
			}
			}

      /*require_once __DIR__ . '/db_config.php';
      $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());

      $dish_name = $_POST['dish_name'];
      $dish_type = $_POST['dish_type'];
      $price = $_POST['price'];
      $menu_id = $_POST['id_menu'];

      if (isset($_POST['dish_name']) && isset($_POST['dish_type']) && isset($_POST['price']) && isset($_POST['id_menu']) && isset($_FILE['dish_image'])) {
      		 
      }else {
      	echo "<script>alert('Please enter all the required data.')</script>";
      }*/

?>