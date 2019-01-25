<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['dish_id']) {
	$dishid = $_REQUEST['dish_id'];

	$sqlorder = "SELECT * FROM `order_details` WHERE `dish_id` = $dishid";
	$resorder = mysqli_query($con, $sqlorder);
	while ( $objorder=mysqli_fetch_object($resorder)) {
		$sqlorderdel = "DELETE FROM order_details WHERE dish_id=$objorder->dish_id";
		$resorderdel = mysqli_query($con, $sqlorderdel);
	}
	$sqldishdel = "DELETE FROM dish WHERE dish_id=$dishid";
	$resultset = mysqli_query($con, $sqldishdel) or die("database error:". mysqli_error($con));
	if($resultset) {
		echo "Dish Deleted successfully.";
	}
}
?>