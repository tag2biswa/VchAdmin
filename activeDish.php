<?php
    require_once __DIR__ . '/db_config.php';
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
    $dish_id = $_POST['dish_id'];
    $dish_active = $_POST['dish_active'];
    if ($dish_active == 1) {
        $dish_active = 0;
    }else{
        $dish_active = 1;
    }
        mysqli_query($con, "UPDATE `dish` SET `d_isactive` = $dish_active WHERE `dish_id`=$dish_id");
        mysqli_close($con);
?>