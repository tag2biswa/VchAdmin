<?php
    require_once __DIR__ . '/db_config.php';
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
    $cat_id = $_GET['cat_id'];
 
    if (isset($_POST['submit'])) {
        $cat_id = $_POST['cat_id'];
        $cat_name = $_POST['cat_name'];
        $uploadedFile = '';

        if($_FILES['images']['size'] != 0){
            echo "img";
         foreach($_FILES['images']['name'] as $name => $value){  
             $file_name = explode(".", $_FILES['images']['name'][$name]);  
             $allowed_extension = array("jpg", "jpeg", "png", "gif");  
             if(in_array($file_name[1], $allowed_extension)){  
                $new_name = round(microtime(true)*1000) . '.'. $file_name[1];  
                $sourcePath = $_FILES["images"]["tmp_name"][$name];  
                $targetPath = "images/".$new_name; 

                if(move_uploaded_file($sourcePath, $targetPath)){
                  $uploadedFile = $targetPath;
                  mysqli_query($con, "UPDATE `category` SET `cat_name` = '$cat_name',`cat_img` = '$targetPath' WHERE `cat_id`=$cat_id");
                }
            }
        }
    }else{
        echo "img not";
    mysqli_query($con, "UPDATE `category` SET `cat_name` = '$cat_name' WHERE `cat_id`=$cat_id");
    }
        
        header("location:categorylist.php");
    }
 
    $members = mysqli_query($con, "SELECT * FROM `category` WHERE `cat_id`='$cat_id'");
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
 
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<form method="post" action="editCategory.php" role="form" id="edit_form" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="form-group">
            <label for="cat_id">Category ID</label>
            <input type="text" class="form-control" id="cat_id" name="cat_id" value="<?php echo $mem['cat_id'];?>" readonly="true"/>
        </div>
        <div class="form-group">
            <label for="cat_name">Category Name</label>
                <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo $mem['cat_name'];?>" />
        </div>
        <div class="form-group">
                    <label>Image</label>
                    <input type="file" class="form-control" placeholder="Upload Image" name="images[]" accept="image/*"  id="select_image">
                </div>
        </div>
        <div class="modal-footer">
             <input type="submit" class="btn btn-primary" name="submit" value="Update" />&nbsp;
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
</body>
</html>