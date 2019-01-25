<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();
if(isset($_POST['old_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])){
	$old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

	$sql = "SELECT * FROM `password`";
    $result = mysqli_query($con,$sql);
    if (mysqli_num_rows($result) > 0) {
        $obj=mysqli_fetch_object($result);
        $curr_pwd = $obj->pwd;
           if (strcasecmp($old_password,$curr_pwd) == 0) {
            if (strcasecmp($new_password,$confirm_password) == 0) {
                $update_qry = "UPDATE `password` SET `pwd` = $new_password";
                if (mysqli_query($con, $update_qry)) {
                    $response['result'] = '1';
                    $response['message'] = "Password updated successfully.";
                 } else {
                    $response['result'] = '0';
                    $response['message'] = "Password not updated.";
                 }
            }else{
                $response['result'] = '0';
                $response['message'] = "New and Confirm password shoild be same.."; 
            }  
            }else{
                $response['result'] = '0';
                $response['message'] = "Please enter exact current password."; 
            }     
    }
}else{
	$response['result'] = '0';
    $response['message'] = "Please enter all the required parameters.";
}
echo json_encode($response);
mysqli_close($con);
?>