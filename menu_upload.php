<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
if(!empty($_POST['menu_name']) || !empty($_POST['id_category'])){
          $menu_name = $_POST['menu_name'];
          $id_category = $_POST['id_category'];
          $sql = "INSERT INTO menu (menu_name, cat_id) VALUES ('$menu_name','$id_category')";
          $res = mysqli_query($con, $sql);
          if ($res) {
            $response['result'] = '1';
            $response['message'] = "Menu added successfully.";
          }else{
            $response['result'] = '0';
            $response['message'] = "Menu not added. Please try again.";
          }
}else{
  $response['result'] = '0';
  $response['message'] = "Parameter missing.";
}
echo json_encode($response);
mysqli_close($con);
?>