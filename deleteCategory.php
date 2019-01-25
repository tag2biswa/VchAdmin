<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['cat_id']) {
	$catid = $_REQUEST['cat_id'];
	$sqlmenu = "SELECT `menu_id` FROM `menu` WHERE `cat_id` = $catid";
	$resmenu = mysqli_query($con, $sqlmenu);
	while ($obj=mysqli_fetch_object($resmenu)){
		$menuid = $obj->menu_id;
		$sqldish = "SELECT `dish_id` FROM `dish` WHERE `menu_id` = $menuid";
		$resdish = mysqli_query($con, $sqldish);
		while ( $objdish=mysqli_fetch_object($resdish)) {
			$sqldishdel = "DELETE FROM dish WHERE dish_id=$objdish->dish_id";
			$resdishdel = mysqli_query($con, $sqldishdel);
		}
		$sqlmenudel = "DELETE FROM menu WHERE menu_id=$menuid";
		$resmenudel = mysqli_query($con, $sqlmenudel);
	}
	$sql = "DELETE FROM category WHERE cat_id=$catid";
	$resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));	
	if($resultset) {
		echo "Category Deleted successfully";
	}
}
?>