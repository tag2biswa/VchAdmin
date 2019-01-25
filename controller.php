<?php
session_start();
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());

date_default_timezone_set("Asia/Manila");
$date = date("Y-m-d");
$date_time = date("Y-m-d h:i:s");

$usernameErr = $passwordErr = "";

function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["loginusername"])) {
        $usernameErr = "Username is required";
    } else {
        $username = clean($_POST["loginusername"]);
    }

    if (empty($_POST["loginpassword"])) {
        $passwordErr = "password is required";
    } else {
        $txtpassword = clean($_POST["loginpassword"]);
    }
}*/

//Login Query
if(isset($_POST['login']) && isset($_POST['loginusername'])){
	$username = $_POST['loginusername'];
    $sql = "SELECT * FROM admin_tab WHERE username='$username'";
    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['password'] == $txtpassword){
                $_SESSION['user_name'] = $row['username'];
                header("location:allorderlist.php");
            } else {
                $passwordErr = '<div class="alert alert-warning">
                        <strong>Login!</strong> Failed.
                        </div>';
                $username = $row['username'];
            }
        }
    } else {
        $usernameErr = '<div class="alert alert-danger">
  <strong>Username</strong> Not Found.
</div>';
        $username = "";
    }
}
?>