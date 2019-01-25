<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['menu_id']) {
	$menuid = $_REQUEST['menu_id'];

	$sqldish = "SELECT `dish_id` FROM `dish` WHERE `menu_id` = $menuid";
	$resdish = mysqli_query($con, $sqldish);
	while ( $objdish=mysqli_fetch_object($resdish)) {
		$sqldishdel = "DELETE FROM dish WHERE dish_id=$objdish->dish_id";
		$resdishdel = mysqli_query($con, $sqldishdel);
	}
	$sqlmenudel = "DELETE FROM menu WHERE menu_id=$menuid";
	$resultset = mysqli_query($con, $sqlmenudel) or die("database error:". mysqli_error($con));
	if($resultset) {
		echo "Menu Deleted successfully.";
	}
}
?>