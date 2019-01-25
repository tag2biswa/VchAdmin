  <?php
  require_once __DIR__ . '/db_config.php';
  $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
  $dishid = $_GET['dishid'];

  if (isset($_POST['submit'])) {

    $dish_id = $_POST['dish_id'];
    $dish_name = $_POST['dish_name'];
    $price = $_POST['price'];
    $id_menu = $_POST['id_menuu'];
    $dish_type = $_POST['dish_type'];
    $uploadedFile = ''; 


    if($_FILES['images']['size'] != 0){
     foreach($_FILES['images']['name'] as $name => $value){  
         $file_name = explode(".", $_FILES['images']['name'][$name]);  
         $allowed_extension = array("jpg", "jpeg", "png", "gif");  
         if(in_array($file_name[1], $allowed_extension)){  
            $new_name = round(microtime(true)*1000) . '.'. $file_name[1];  
            $sourcePath = $_FILES["images"]["tmp_name"][$name];  
            $targetPath = "images/".$new_name;  
            if(move_uploaded_file($sourcePath, $targetPath)){
              $uploadedFile = $targetPath;

              /*$sql = "INSERT INTO dish (dish_name, dish_img ,dish_type ,price, menu_id) VALUES ('$dish_name','$uploadedFile','$dish_type','$price','$id_menu')";*/
              $sql = "UPDATE `dish` SET `dish_name` = '$dish_name',`dish_img`= '$uploadedFile',`dish_type`= '$dish_type',`price`= '$price',`menu_id`= '$id_menu' WHERE `dish_id`= $dish_id";
              $res = mysqli_query($con, $sql);
          }
      }
  } 
}else{
    $sql = "UPDATE `dish` SET `dish_name` = '$dish_name',`dish_type`= '$dish_type',`price`= '$price',`menu_id`= '$id_menu' WHERE `dish_id`= $dish_id";
    $res = mysqli_query($con, $sql);
}
header("location:dishlist.php");
}

$members = mysqli_query($con, "SELECT * FROM `dish` WHERE `dish_id`='$dishid'");
$mem = mysqli_fetch_assoc($members);
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Victoria Club Hotel</title>
    <script type="text/javascript">

        function Category() {
            $('#id_categoryy').empty();
            $('#id_categoryy').append("<option>Loading.....</option>");
            $('#id_menuu').append("<option>Select Menu</option>");
            $.ajax({
                type: "POST",
                url: "category_dropdown.php",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                async: false,
                success: function(data) {
                    $('#id_categoryy').empty();
                    $('#id_categoryy').append("<option>Select Category</option>");
                    $.each(data, function(i, item) {
                        $('#id_categoryy').append('<option value="' + data[i].cat_id + '">' + data[i].cat_name + '</option>');
                    });
                }
            });
        }  


        function Menu(cat_id) {
            $('#id_menuu').empty();
            $('#id_menuu').append("<option>Loading.....</option>");
            $.ajax({
                type: "POST",
                url: "menu_dropdown.php?cat_id=" + cat_id,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                async: false,
                success: function(data) {
                    $('#id_menuu').empty();
                    $('#id_menuu').append("<option>Select Menu</option>");
                    $.each(data, function(i, item) {
                        $('#id_menuu').append('<option value="' + data[i].menu_id + '">' + data[i].menu_name + '</option>');
                    });
                }
            });
        }


        $(document).ready(function() {
            Category();
            $("#id_categoryy").change(function() {
                var catid = $("#id_categoryy").val();
                Menu(catid);
            });
        });
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form method="post" action="editDish.php" role="form" id="edit_form" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Dish Id</label>
                    <input type="text" class="form-control" placeholder="Dish id" id="dish_id" name="dish_id" readonly="true" value="<?php echo $mem['dish_id'];?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="dish_name" value="<?php echo $mem['dish_name'];?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" placeholder="Price" name="price" value="<?php echo $mem['price'];?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" placeholder="Upload Image" name="images[]" accept="image/*"  id="select_image">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="n/nv">Category</label>
                    <select class="form-control" id="id_categoryy" name='id_categoryy' required="required">
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="n/nv">Menu Type</label>
                    <select class="form-control" id="id_menuu" name='id_menuu' required="required">
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
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" name="submit" value="Update" />&nbsp;
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
 </form>
</body>
</html>