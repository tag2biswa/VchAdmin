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
        <link href="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.rawgit.com/atatanasov/gijgo/master/dist/combined/js/gijgo.min.js" type="text/javascript"></script>
        <style type="text/css">
        	.datepickerDiv {
        		width: 160px;
        		padding: 0 5px;
        	}
        	.datepickerDiv .input-group .form-control {
        		border-radius: 0;
        	}
        	.datepickerDiv .gj-datepicker-bootstrap span[role=right-icon].input-group-addon {
        		border-radius: 0;
        	}

        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#startDate').datepicker({
                    uiLibrary: 'bootstrap'
                });
                $('#endDate').datepicker({
                    uiLibrary: 'bootstrap'
                });
            });
        </script>
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
                $('#room_save').click(function() {
                    $('#upload_form').submit();
                });
                $('#upload_form').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "room_upload.php",
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

                $('#edit-item').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var recipient = button.data('whatever') // Extract info from data-* attributes
                    var modal = $(this);
                    var dataString = 'order_id=' + recipient;

                    $.ajax({
                        type: "GET",
                        url: "editOrder.php",
                        data: dataString,
                        cache: false,
                        success: function(data) {
                            console.log(data);
                            modal.find('.dash').html(data);
                        },
                        error: function(err) {
                            console.log(err);
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
                            <li class="active">
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
                            <li>
                                <a href="changepwd.php"><img src="images/lock.svg"> Change App Password</a>
                            </li>

                        </ul>
                    </nav>

                    <div class="pull-right main_content">
                        <!-- Menu Listing -->
                        <div class="row form-group">
                            <div class="pull-right text-right" style="padding-right: 15px;">
                                <a href="http://vchbillings.info/orderdatapull.php?startdate="<?php echo $_GET['startDate']; ?> class="btn btn-info"><span class="glyphicon glyphicon-share"></span> Export to Excel</a>
                            </div>
                            <div class="datepickerDiv pull-right">

                                <input id="endDate" name="endDate" placeholder="End Date" />
                            </div>
                            <div class="datepickerDiv pull-right">
                                <input id="startDate" name="startDate" placeholder="Start Date" />
                            </div>

                        </div>
                        <table class="table table-striped admin-table all-order-table">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Order Id</th>
                                    <th>Room
                                        <br>Number</th>
                                    <th>Staff Id</th>
                                    <th>Order Created Time</th>
                                    <th>Order Delivery Time</th>
                                    <th>Order Status</th>
                                    <th>Last Modification Time</th>
                                    <th>Mobile Number</th>
                                    <th>Delivery Place</th>
                                    <th>Order Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
            /*$sql = "select * from `order_status` where order_status = 1 order by order_id desc";*/
            $sql = "select * from `order_status` order by order_id desc";
            $res = mysqli_query($con, $sql);
            if(mysqli_num_rows($res) > 0) {
              $i = 0;
              while($row = mysqli_fetch_object($res)) {
                $i++;
                ?>
                                    <tr>

                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->order_id; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->room_num; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->staff_id; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->start_time; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->end_time; ?>
                                        </td>
                                        <td>
                                            <?php
                        $orderstatus = $row->order_status;
                        $sql2 = "select * from `status_type` where status_id = $row->order_status";
                        $res2 = mysqli_query($con, $sql2);
                        if(mysqli_num_rows($res2) > 0) {
                           $row2 = mysqli_fetch_object($res2);
                           echo $row2->status_type;
                       }?>
                                        </td>
                                        <td>
                                            <?php echo $row->last_modification_time; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->mobile_num; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->place_delivery; ?>
                                        </td>
                                        <td>

                                            <a class="btn update" data-target="#edit-item" data-order-id="<?php echo $row->order_id; ?>" data-toggle="modal" data-whatever="<?php echo $row->order_id; ?>">
                                                <button type="button" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></button>
                                            </a>
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
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Room</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Room Number</label>
                                                    <input type="text" class="form-control" placeholder="Room Number" name="room_num" required="required">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="n/nv">Room Type</label>
                                                    <select class="form-control" id="room_type_num" name='room_type_num' required="required">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Floor</label>
                                                    <input type="text" class="form-control" placeholder="Floor" name="floor" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-info" name="room_save" id="room_save"> Save </button>
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Add New Item Modal End -->

                    <!-- Edit Item Modal Start -->
                    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="memberModalLabel">Order Details</h4>
                                </div>
                                <div class="dash">
                                    <!-- Content goes in here -->
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
            <?php 
mysqli_close($con);
?>
    </body>

    </html>