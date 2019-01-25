<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
?>

<?php

$DB_TBLName = "order_status"; 
$filename = "orders";  
$file_ending = "xls";   

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

$sep = "\t";

$sql="SELECT order_status.order_id,order_status.room_num,order_status.staff_id,order_status.place_delivery,order_status.mobile_num,order_status.start_time,order_status.end_time,order_status.order_status,order_details.dish_id,order_details.dish_price,order_details.qty,dish.dish_name,dish.dish_type FROM order_status,order_details,dish WHERE order_status.order_id=order_details.order_id AND order_details.dish_id=dish.dish_id"; 
$resultt = $con->query($sql);
while ($property = mysqli_fetch_field($resultt)) { 
    echo $property->name."\t";
}

print("\n");    

while($row = mysqli_fetch_row($resultt))  
{
    $schema_insert = "";
    for($j=0; $j< mysqli_num_fields($resultt);$j++)
    {
        if(!isset($row[$j]))
            $schema_insert .= "NULL".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}

?>