<?php 
 $output = array(); 
 if(is_array($_FILES))  {  
      foreach($_FILES['images']['name'] as $name => $value)  
      {  
           $file_name = explode(".", $_FILES['images']['name'][$name]);  
           $allowed_extension = array("jpg", "jpeg", "png", "gif");  
           if(in_array($file_name[1], $allowed_extension))  
           {  
                $new_name = rand() . '.'. $file_name[1];  
                $sourcePath = $_FILES["images"]["tmp_name"][$name];  
                $targetPath = "images/".$new_name;  
                if(move_uploaded_file($sourcePath, $targetPath)){
                  $output['response'] = '1';
                  $output['path'] = $targetPath;
                }
                else{
						      $output['response'] = '0';
                  $output['path'] = '';
                } 
           }  
      }
      echo json_encode($output);  
 }  
 ?>  