<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$response = array();

$uploadedFile = ''; 
    foreach($_FILES['images']['name'] as $name => $value){
        $file_name = explode(".", $_FILES['images']['name'][$name]);  
        $allowed_extension = array("jpg", "jpeg", "png", "gif");
        if(in_array($file_name[1], $allowed_extension)){  
                $new_name = round(microtime(true)*1000) . '.'. $file_name[1];  
                $sourcePath = $_FILES["images"]["tmp_name"][$name];  
                $targetPath = "images/".$new_name;
                if(move_uploaded_file($sourcePath, $targetPath)){
                          $uploadedFile = $targetPath;
                          $category_name = $_POST['category_name'];
                          $sql = "INSERT INTO category (cat_name, cat_img) VALUES ('$category_name' , '$uploadedFile')";
                          $res = mysqli_query($con, $sql);
                            if ($res) {
                                $response['result'] = '1';
                                $response['message'] = "Category added successfully.";
                            }else{
                                $response['result'] = '0';
                                $response['message'] = "Category not added. Please try again.".mysqli_error($con);
                            }
                }else{
                    $response['result'] = '0';
                    $response['message'] = "Image not uploaded. Please try again.";
                }
        }else{
            $response['result'] = '0';
            $response['message'] = "Please select an image with jpeg or png format.";
        }  
    }




echo json_encode($response);
mysqli_close($con);
?>