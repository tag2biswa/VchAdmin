<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
if(isset($_POST['staff_id']) && isset($_POST['staff_name']) && isset($_POST['staff_password'])){
	$staff_id = $_POST['staff_id'];
    $staff_name = $_POST['staff_name'];
    $staff_password = $_POST['staff_password'];
	$sql = "INSERT INTO staff (staff_id, staff_name, password) VALUES ('$staff_id', '$staff_name', '$staff_password')";
	$res = mysqli_query($con, $sql);
        if ($res) {
            $response['result'] = '1';
            $response['message'] = "Staff added successfully.";
        }else{
        	$response['result'] = '0';
            $response['message'] = "Staff not added. Please try again.".mysqli_error($con);
        }
}else{
	$response['result'] = '0';
    $response['message'] = "Please enter all the required parameters.";
}
echo json_encode($response);
mysqli_close($con);
?>