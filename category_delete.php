<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
$response['result'] = '0';
$response['message'] = "Please enter all the required parameters.";
echo json_encode($response);

/*if(!empty($_POST['cat_id'])){
	$category_id = $_POST['cat_id'];
	$sql = "DELETE FROM `category` WHERE `cat_id`= '$category_id'";
	$res = mysqli_query($con, $sql);
        if ($res) {
            $response['result'] = '1';
            $response['message'] = "Category deleted successfully.";
        }else{
        	$response['result'] = '0';
            $response['message'] = "Category not deleted. Please try again.".mysqli_error($con);
        }
}else{
	$response['result'] = '0';
    $response['message'] = "Please enter all the required parameters.";
}
echo json_encode($response);
mysqli_close($con);*/
?>