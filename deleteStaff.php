<?php 
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if($_REQUEST['staff_id']) {
	$staffId = $_REQUEST['staff_id'];

	
	$sqlmenudel = "DELETE FROM staff WHERE staff_id=$staffId";
	$resultset = mysqli_query($con, $sqlmenudel) or die("database error:". mysqli_error($con));
	if($resultset) {
		echo "Staff Deleted successfully.";
	}
}
?>