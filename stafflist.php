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
    <script type="text/javascript" src="script/bootbox.min.js"></script>
  <script type="text/javascript" src="script/deleteStaff.js"></script>
    <script type="text/javascript">
        function Roomtype() {
            $('#room_type_num').empty();
            $('#room_type_num').append("<option>Loading.....</option>");
            $.ajax({
                type: "POST",
                url: "room_type_dropdown.php",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                async: false,
                success: function(data) {
                    $('#room_type_num').empty();
                    $('#room_type_num').append("<option>Select Room Type</option>");
                    $.each(data, function(i, item) {
                        $('#room_type_num').append('<option value="' + data[i].room_type_num + '">' + data[i].room_type_name + '</option>');
                    });
                }
            });
        }
        $(document).ready(function() {
            Roomtype();
            $('#staff_save').click(function() {
                $('#upload_form').submit();
            });
            $('#upload_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "staff_upload.php",
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
              	      <li class="active">
          		  <a href="stafflist.php"><img src="images/maids.svg"> Staff List</a>
        	      </li>
                      <li>
                          <a href="orderbystaff.php"><img src="images/search_order.svg"> Search order by Staff Id</a>
                      </li>
                      <li>
                          <a href="changepwd.php"><img src="images/lock.svg"> Change App Password</a>
        	      </li>
                  </ul>
                </nav>
                <div class="pull-right main_content">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-new-item">Add New Staff</button>
                        </div>
                    </div>
                    <!-- Menu Listing -->
                    <table class="table table-striped admin-table">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Staff Id</th>
                                <th>Staff Name</th>
								<th>Password</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $sql = "select * from `staff`";
                              $res = mysqli_query($con, $sql);
                              if(mysqli_num_rows($res) > 0) {
                                $i = 0;
                                while($row = mysqli_fetch_object($res)) {
                                  $i++;
                                  ?>
                                  <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $row->staff_id; ?></td>
                                  <td><?php echo $row->staff_name; ?></td>
				  <td><?php echo $row->password; ?></td>
                                  <td>
                                  <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#edit-item"><span class="glyphicon glyphicon-pencil"></span></button> -->
                                   <a class="btn delete_staff" data-staff-id="<?php echo $row->staff_id; ?>" href="javascript:void(0)">
                                  <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                                  </td>
                                </tr>
                                <?php
                                }
                              }
                              ?>
                        </tbody>
                    </table>
                </div>

                <!-- Add New Item Modal Start -->
                <form method="post" id="upload_form" enctype="multipart/form-data">
                    <div class="modal fade" id="add-new-item" role="dialog">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Add Staff</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Staff Id</label>
                                                <input type="text" class="form-control" placeholder="Staff id" name="staff_id" required="required">
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Staff Name</label>
                                                <input type="text" class="form-control" placeholder="Staff Name" name="staff_name" required="required">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Staff Password</label>
                                                <input type="text" class="form-control" placeholder="Staff Password" name="staff_password" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" name="staff_save" id="staff_save"> Save </button>
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