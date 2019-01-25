<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['order_details_id']) {
	$order_item_id = $_REQUEST['order_details_id'];

	$sqldishdel = "DELETE FROM order_details WHERE order_details_id=$order_item_id";
	$resultset = mysqli_query($con, $sqldishdel) or die("database error:". mysqli_error($con));
	if($resultset) {
		echo "Order Item Deleted successfully.";
	}
}
?>