<?php echo
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html');?>
<?php
session_start();
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$message="";

if (isset($_POST["username"],$_POST["password"])){
	$sqlq = "SELECT * FROM admin_tab WHERE username='" . $_POST["username"] . "' and password = '". $_POST["password"]."'";
	$result = mysqli_query($con,$sqlq);
	$row = mysqli_fetch_assoc($result);
	if(is_array($row)) {
		$_SESSION["id"] = $row["id"];
		$_SESSION["username"] = $row["username"];
	} else {
		$message = "Invalid Username or Password!";
	}
}else{
	$message = "Please enter username and password";
}

if(isset($_SESSION["id"])) {
	header("Location:allorderlist.php");
}


?>
<html>
<head>
	<title>Victoria Club Hotel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.ico" type="image/gif">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>
<body id="LoginForm">
	<div class="V_Hotel">
        <div class="row section">
            <div class="container">
                  
                <div class="login-form">
                    <div class="main-div">
                        <div class="panel">
	                        <a class="" href="#"><img src="images/vch_logo.png" alt="VCH"></a>
	                        <br>
	                        <br>
	                        <div class="clearfix"></div>
	                        <h2>Admin Login</h2>
	                        <p class="message"><?php if($message!="") { echo $message; } ?></p>
						</div>
						<form name="frmUser" method="post" action="" align="center">
							
							<div class="form-group">
								<input type="text" name="username" placeholder="User Name" class="form-control">
							</div>
							<div class="form-group">
								<input type="password" name="password" placeholder="Password" class="form-control">
							</div>
							<input type="submit" name="submit" value="Submit" id="login" class="btn btn-primary">
						</form>
	 				</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>