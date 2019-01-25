<?php
    require_once __DIR__ . '/db_config.php';
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
    $cat_id = $_POST['cat_id'];
    $cat_active = $_POST['cat_active'];
    if ($cat_active == 1) {
        $cat_active = 0;
    }else{
        $cat_active = 1;
    }
        mysqli_query($con, "UPDATE `category` SET `c_isactive` = $cat_active WHERE `cat_id`=$cat_id");
        mysqli_close($con);
?>