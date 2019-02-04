<?php
  require_once __DIR__ . '/db_config.php';
  $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
  $orderDetailsId = $_GET['order_details_id'];
  $qtyy = $_GET['qtyy'];

  $sql = "UPDATE `order_details` SET `qty` = '$qtyy' WHERE `order_details_id`= $orderDetailsId";
  $res = mysqli_query($con, $sql);
  mysqli_close($con);
  ?>