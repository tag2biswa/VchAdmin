<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
if(!empty($_POST['roomtype_name'])){
          $room_type = $_POST['roomtype_name'];
          $sql = "INSERT INTO room_type (room_type_name) VALUES ('$room_type')";
          $res = mysqli_query($con, $sql);
          if ($res) {
            $response['result'] = '1';
            $response['message'] = "Room Type added successfully.";
          }else{
            $response['result'] = '0';
            $response['message'] = "Room Type not added. Please try again.";
          }
}else{
  $response['result'] = '0';
  $response['message'] = "Parameter missing.";
}
echo json_encode($response);
mysqli_close($con);
?>