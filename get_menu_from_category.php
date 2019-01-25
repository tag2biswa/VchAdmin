<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
if(isset($_POST['id_category'])) {
  $sql = "select * from `menu` where `cat_id`=".mysqli_real_escape_string($con, $_POST['id_category']);
  $res = mysqli_query($con, $sql);
  if(mysqli_num_rows($res) > 0) {
    echo "<option value=''>------- Select --------</option>";
    while($row = mysqli_fetch_object($res)) {
      echo "<option value='".$row->menu_id."'>".$row->menu_name."</option>";
    }
  }
} else {
  header('location: ./');
}
?>