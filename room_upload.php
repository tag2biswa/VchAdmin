<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
if(isset($_POST['room_num']) && isset($_POST['room_type_num']) && isset($_POST['floor']) && isset($_POST['password'])){
	$room_num = $_POST['room_num'];
    $room_type_num = $_POST['room_type_num'];
    $floor = $_POST['floor'];
    $password = $_POST['password'];
	$sql = "INSERT INTO room (room_num, room_type_num, floor, password) VALUES ('$room_num', '$room_type_num', '$floor', '$password')";
	$res = mysqli_query($con, $sql);
        if ($res) {
            $response['result'] = '1';
            $response['message'] = "Room added successfully.";
        }else{
        	$response['result'] = '0';
            $response['message'] = "Room not added. Please try again.".mysqli_error($con);
        }
}else{
	$response['result'] = '0';
    $response['message'] = "Please enter all the required parameters.";
}
echo json_encode($response);
mysqli_close($con);
?>