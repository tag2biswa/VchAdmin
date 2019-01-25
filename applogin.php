    <?php
    require_once __DIR__ . '/db_config.php';
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
    $response = array();
    if(isset($_REQUEST['userid']) && isset($_REQUEST['password'])){
        $userid = $_REQUEST['userid'];
        $password = $_REQUEST['password'];

    	/*$sql = "SELECT * FROM `password`";
        $result = mysqli_query($con,$sql);
        if (mysqli_num_rows($result) > 0) {*/
            //$obj=mysqli_fetch_object($result);

               //if (strcasecmp($password,$obj->pwd) == 0) {
                $isLoggedin = false;
                //if userid is room_num
                $sql_userid = "SELECT * FROM `room`";
                $res_room = mysqli_query($con,$sql_userid);
                if (mysqli_num_rows($res_room) > 0) {
                    $checked = 0;
                    while($row = mysqli_fetch_object($res_room)) {
                        if ((strcasecmp($row->room_num, $userid ) == 0) and (strcasecmp($row->password, $password) == 0))
                            $checked = 1;
                    }
                    if ($checked == 1) {
                        $isLoggedin = true;
                        $response['result'] = '1';
                        $response['message'] = "Login successful.";
                        $response['type'] = "room";
                    }
                }

                //if userid is staff_id
                $sql_usrid = "SELECT * FROM `staff`";
                $res_staff = mysqli_query($con,$sql_usrid);
                if (mysqli_num_rows($res_staff) > 0) {
                    $checked2 = 0;
                    while($row1 = mysqli_fetch_object($res_staff)) {
                        if ((strcasecmp($row1->staff_id, $userid ) == 0) and (strcasecmp($row1->password, $password ) == 0))
                            $checked2 = 1;
                    }
                    if ($checked2 == 1) {
                        $isLoggedin = true;
                        $response['result'] = '1';
                        $response['message'] = "Login successful.";
                        $response['type'] = "staff";
                    }
                }

                //userid is not a staff_id and not a room_num
                if (!$isLoggedin) {
                    $response['result'] = '0';
                    $response['message'] = "Userid or Password not exist.";
                }
                /*}else{
                    $response['result'] = '0';
                    $response['message'] = "Enter correct password."; 
                }   */  
        //}
    }else{
    	$response['result'] = '0';
        $response['message'] = "Please enter all the required parameters.";
    }
    echo json_encode($response);
    mysqli_close($con);
    ?>