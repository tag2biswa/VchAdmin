<?php
    require_once __DIR__ . '/db_config.php';
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
    $menu_id = $_POST['menu_id'];
    $menu_active = $_POST['menu_active'];
    if ($menu_active == 1) {
        $menu_active = 0;
    }else{
        $menu_active = 1;
    }
        mysqli_query($con, "UPDATE `menu` SET `m_isactive` = $menu_active WHERE `menu_id`=$menu_id");
        mysqli_close($con);
?>