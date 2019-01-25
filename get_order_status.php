<?php
  // required headers
      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json; charset=UTF-8");
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Max-Age: 3600");
      header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
      require_once __DIR__ . '/db_config.php';
      $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
      $response = array();
      $result = mysqli_query($con,"SELECT * FROM `status_type`");
      if (mysqli_num_rows($result) > 0) {
          $response = array();
          while ($obj=mysqli_fetch_object($result)){
            $response[] = array(
              'status_id' => $obj->status_id,
              'status_type' => $obj->status_type
            );
          }
          //echo json_encode($response);
      }
      mysqli_free_result($result);
      echo json_encode($response);
      mysqli_close($con);
  ?>