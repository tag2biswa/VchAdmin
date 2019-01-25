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
  <script type="text/javascript" src="script/deleteDish.js"></script>
  <script type="text/javascript" src="script/activeDish.js"></script>
  <script type="text/javascript">
    function Category() {
      $('#id_category').empty();
      $('#id_category').append("<option>Loading.....</option>");
      $('#id_menu').append("<option>Select Menu</option>");
      $.ajax({
        type: "POST",
        url: "category_dropdown.php",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        async: false,
        success: function(data) {
          $('#id_category').empty();
          $('#id_category').append("<option>Select Category</option>");
          $.each(data, function(i, item) {
            $('#id_category').append('<option value="' + data[i].cat_id + '">' + data[i].cat_name + '</option>');
          });
        }
      });
    }

    function Menu(cat_id) {
      $('#id_menu').empty();
      $('#id_menu').append("<option>Loading.....</option>");
      $.ajax({
        type: "POST",
        url: "menu_dropdown.php?cat_id=" + cat_id,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        async: false,
        success: function(data) {
          $('#id_menu').empty();
          $('#id_menu').append("<option>Select Menu</option>");
          $.each(data, function(i, item) {
            $('#id_menu').append('<option value="' + data[i].menu_id + '">' + data[i].menu_name + '</option>');
          });
        }
      });
    }

    $(document).ready(function() {
      Category();
      $("#id_category").change(function() {
        var catid = $("#id_category").val();
        Menu(catid);
      });
            /*$('#select_image').change(function(){  
                 $('#upload_form').submit();  
               });*/
               $('#menu_save').click(function() {
                $('#upload_form').submit();
              });
               $('#upload_form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                  url: "dish_upload.php",
                  method: "POST",
                  data: new FormData(this),
                  contentType: false,
                  processData: false,
                  dataType: "json",
                  success: function(data) {
                    if (data['result'] == '1') {
                      alert(data['message']);
                      $('#select_image').val('');
                      $('#add-new-item').modal('hide');
                      location.reload();
                    } else {
                      alert(data['message']);
                    }
                  }
                })
              });


               $('#edit-item').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget) // Button that triggered the modal
                  var recipient = button.data('whatever') // Extract info from data-* attributes
                  var modal = $(this);
                  var dataString = 'dishid=' + recipient;

                  $.ajax({
                    type: "GET",
                    url: "editDish.php",
                    data: dataString,
                    cache: false,
                    success: function (data) {
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
	<!--  -->
<!--     <link rel="stylesheet" type="text/css" href="css/style.css">
-->    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
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
    <li class="active">
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
  <div class="row">
    <div class="col-md-12 form-group">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-new-item">Add New Dish</butto>
      </div>
    </div>
    <!-- Menu Listing -->
    <table class="table table-striped admin-table">
      <thead>
        <tr>
          <th>Sl No.</th>
          <th>Name</th>
          <th>Price</th>
          <th>Image</th>
          <th>Category</th>
          <th>Veg / Non-Veg</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "select * from `dish`";
        $res = mysqli_query($con, $sql);
        if(mysqli_num_rows($res) > 0) {
          $i = 0;
          while($row = mysqli_fetch_object($res)) {
            $i++;
            $dish_id = $row->dish_id;
            if ($row->dish_type == 0) {
              $type = "Veg";
            }else{
              $type = "Non-veg";
            }
            $sql2 = "select `cat_name` from `category` where `cat_id`=(select `cat_id` from `menu` where `menu_id`=".mysqli_real_escape_string($con, $row->menu_id).")";
            $res2 = mysqli_query($con, $sql2);
            if(mysqli_num_rows($res2) > 0) {
              $row2 = mysqli_fetch_object($res2);
              $category_name = $row2->cat_name;
            }
            ?> 
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->dish_name; ?></td>
              <td><?php echo $row->price; ?></td>
              <td><img src='<?php echo $row->dish_img; ?>'></td>
              <td><?php echo $category_name; ?></td>
              <td><?php echo $type; ?></td>
              <td>
                <a class="btn update" data-target="#edit-item" data-dish-id="<?php echo $row->dish_id; ?>" data-toggle="modal" data-whatever="<?php echo $row->dish_id; ?>">
                  <button type="button" class="btn btn-info" ><span class="glyphicon glyphicon-pencil"></span></button>
                </a>


                <a class="delete_dish" data-dish-id="<?php echo $row->dish_id; ?>" href="javascript:void(0)">
                  <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                </a>
		<!-- <button type="button" class="btn btn-success enbableBtn" style="display: none;">Enable</button>
                  <button type="button" class="btn btn btn-default disableBtn">Disable</button> -->
		            <a class="active_dish" data-dish-id="<?php echo $row->dish_id; ?>" data-dish-active="<?php echo $row->d_isactive; ?>" href="javascript:void(0)">
                    <?php 
                    $d_isactive = $row->d_isactive;
                          if ($d_isactive == 1) {?>
                            <button type="button" class="btn btn-success enbableBtn" style="display: none;">Enable</button>
                            <button type="button" class="btn btn btn-default disableBtn">Disable</button>
                          <?php }else{ ?>
                            <button type="button" class="btn btn-success enbableBtn" >Enable</button>
                            <button type="button" class="btn btn btn-default disableBtn" style="display: none;">Disable</button>
                          <?php 
                        }
                    ?>
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
            <h4 class="modal-title">Add New Dish</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" placeholder="Name" name="dish_name" required="required">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Price</label>
                  <input type="number" class="form-control" placeholder="Price" name="price" required="required">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Image</label>
                  <input type="file" class="form-control" placeholder="Upload Image" name="images[]" accept="image/*" required="required" id="select_image">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="n/nv">Category</label>
                  <select class="form-control" id="id_category" name='id_category' required="required">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="n/nv">Menu Type</label>
                  <select class="form-control" id="id_menu" name='id_menu' required="required">
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="n/nv">Veg / Non-Veg</label>
                  <select class="form-control" name="dish_type" required="required">
                    <option value="0">Veg</option>
                    <option value="1">Non-Veg</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" name="menu_save" id="menu_save"> Save </button>

            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
            <div id='preview'></div>
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
          <h4 class="modal-title" id="memberModalLabel">Edit Dish</h4>
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
            <li><a href="login.php">Yes</a></li>
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