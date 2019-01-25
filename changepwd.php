<?php
session_start();
if(empty($_SESSION['id'])){
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Victoria Club Hotel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.ico" type="image/gif">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#save_pwd').click(function() {
                $('#upload_form').submit();
            });
            $('#upload_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "update_password.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data['result'] == '1') {
                            alert(data['message']);
                            $('#add-new-item').modal('hide');
                            location.reload();
                        } else {
                            alert(data['message']);
                        }
                    }
                });
            });

        });
    </script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
</head>

<body>
    <?php 
  require_once __DIR__ . '/db_config.php';
  $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
  ?>
        <div class="V_Hotel">
           <nav class="navbar navbar-inverse navbar-fixed-top VCH_navbar">
                <div class="container-fluid">
                   <div class="navbar-header">
                      <a class="navbar-brand" href="#"><img src="images/vch_logo.png" alt="VCH"></a>
                   </div>
                   <ul class="navbar-nav ml-auto pull-right">
                      
                      <li class="logout">
                          <a href="#" data-toggle="modal" data-target="#logout"><img src="images/power-button-outline.svg"> Logout</a>
                      </li>
                    </ul>
                </div>
            </nav>
             <div class="row section">
                <nav class="pull-left sidebar">
                  <div class="sidebar-header">
                     Admin Panel
                  </div>
                  <ul class="list-unstyled main_list">
                      <li>
                          <a href="allorderlist.php"><img src="images/Dish1.svg"> All Order List</a>
                      </li>
                      <li>
                          <a href="categorylist.php"><img src="images/Dish2.svg"> Category List</a>
                      </li>
                      <li>
                          <a href="menulist.php"><img src="images/Dish3.svg"> Menu List</a>
                      </li>
                      <li>
                          <a href="dishlist.php"><img src="images/Dish4.svg"> Dish List</a>
                      </li>
                      <li>
                          <a href="roomlist.php"><img src="images/Dish5.svg"> Room List</a>
                      </li>
                       <li>
                          <a href="roomtypelist.php"><img src="images/Dish6.svg"> Room Type List</a>
                      </li>
		      <li>
          		  <a href="stafflist.php"><img src="images/maids.svg"> Staff List</a>
        	      </li>
                      <li>
                          <a href="orderbystaff.php"><img src="images/search_order.svg"> Search order by Staff Id</a>
                      </li>
                      <li class="active">
                          <a href="changepwd.php"><img src="images/lock.svg"> Change App Password</a>
        	      </li>
                  </ul>
                </nav>
                <div class="pull-right main_content">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-new-item">Change Password</button>
                        </div>
                    </div>
                </div>

                <!-- Add New Item Modal Start -->
                <form method="post" id="upload_form" enctype="multipart/form-data">
                    <div class="modal fade" id="add-new-item" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Change Password</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <input type="text" class="form-control" placeholder="Old password" name="old_password" required="required">
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>New Password</label>
                                                <input type="Password" class="form-control" placeholder="New Password" name="new_password" required="required" data-toggle="password">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="Password" class="form-control" placeholder="Confirm Password" name="confirm_password" required="required" data-toggle="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" name="save_pwd" id="save_pwd"> Save </button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Add New Item Modal End -->

                <!-- Edit Item Modal Start -->
                <div class="modal fade" id="edit-item" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit Category</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="email" class="form-control" value="Chicken 65" name="name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="email" class="form-control" value="250" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control" placeholder="Upload Image">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="email" class="form-control" value="Call it what you may, but the dum biriyani.">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="n/nv">Category</label>
                                            <select class="form-control" id="n/nv">
                                                <option>Indian</option>
                                                <option>Chinese</option>
                                                <option>North Indian</option>
                                                <option>American</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="n/nv">Veg / Non-Veg</label>
                                            <select class="form-control" id="n/nv">
                                                <option>Veg</option>
                                                <option>Non-Veg</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info">Save</button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Edit Item Modal End -->

            </div>
            <!-- Logout Modal Start-->
            <div class="modal fade" id="logout" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Log Out</h4>
                    </div>
                    <div class="modal-body">
                      <div class="cd-popup-container">
                        <p>Are you sure you want to <b>Logout</b>?</p>
                        <ul class="cd-buttons">
                            <li><a href="logout.php">Yes</a></li>
                            <li><a href="#0" data-dismiss="modal">No</a></li>
                        </ul>
                        </div>
                    </div>
                  </div>
                  
                </div>
            </div>
            <!-- Logout Modal End-->
        </div>
</body>
<?php 
  mysqli_close($con);
  ?>

</html>