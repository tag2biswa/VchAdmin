  <?php
  require_once __DIR__ . '/db_config.php';
  $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());


  if (isset($_POST['submit'])) {
    $order_status = $_POST['order_status'];
    $order_id = $_POST['order_idd'];
    $authkey = "248997AVB9cXyuB5bfaa9cf";
    date_default_timezone_set("Asia/Kolkata");
    $timestamp = time();
    $ttime = date("Y-m-d h:i:s");

    $var = mysqli_query($con, "UPDATE `order_status` SET `order_status` = '$order_status',`last_modification_time` = '$ttime' WHERE `order_id`=$order_id");
    /////
    if ($var) {
      $resu = mysqli_query($con, "SELECT * FROM `order_status` WHERE `order_id`=$order_id");
      if(mysqli_num_rows($resu) > 0) {
        $row = mysqli_fetch_object($resu);
        $ordr_status = $row->order_status;
        $ordr_id = $row->order_id;
        $ordr_mobile = $row->mobile_num;
        if ($ordr_status == 1) {
          $msg = "Your%20order%20". $ordr_id . "%20has%20been%20succesfully%20placed.%0A--Victoria%20Club%20Hotel--";
        }elseif ($ordr_status == 2) {
          $msg = "Hang%20on%20we%20are%20processing%20your%20order%20"  . $ordr_id . ".%0A--Victoria%20Club%20Hotel--";
        }elseif ($ordr_status == 3) {
          $msg = "Enjoy%20your%20meal.%20your%20order%20".$ordr_id. "%20has%20been%20delivered.%0A--Victoria%20Club%20Hotel--";
        }elseif ($ordr_status == 4) {
          $msg = "Your%20order%20". $ordr_id ."%20has%20been%20cancelled.%20See%20you%20again.%0A--Victoria%20Club%20Hotel--";
        }

        $msgUrl = "http://api.msg91.com/api/sendhttp.php?country=91&sender=MSGIND&route=4&mobiles="
        . $ordr_mobile ."&message=". $msg ."&authkey=".$authkey;

        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $msgUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
      }
    }//end var
    /////
    header("location:allorderlist.php");
  } 
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
    <script type="text/javascript" src="script/bootbox.min.js"></script>
    <script type="text/javascript" src="script/deleteOrderDetails.js"></script>
    <script type="text/javascript" src="script/editOrderItemQty.js"></script>
    <script type="text/javascript">
      function OrderStatus() {
        $('#order_status').empty();
        $('#order_status').append("<option>Loading.....</option>");
        $.ajax({
          type: "POST",
          url: "get_order_status.php",
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          async: false,
          success: function(data) {
            $('#order_status').empty();
            $.each(data, function(i, item) {
              $('#order_status').append('<option value="' + data[i].status_id + '">' + data[i].status_type + '</option>');
            });
          }
        });
      }

      function editQty(element){
        var parent=$(element).parent().parent();
        var placeholder=$(parent).find('.text-info').text();
        $(parent).find('label').hide();
        var input=$(parent).find('input[type="text"]');
        $(input).show();
        $(input).attr('placeholder', placeholder);
      }

      function saveQty(element){
        var parent=$(element).parent().parent();
        var buttonEdit=$(parent).find('.btn-edit');
        var buttonSave=$(parent).find('.btn-save');
        buttonSave.hide();
        buttonEdit.show();
      }

      $(document).ready(function() {
        OrderStatus();
      });
      $(document).ready(function(){
        	$(".order-edit").click(function(){
  		var $row = $(this).closest("tr"); 
  		var $text = $row.find(".order-save").show();
  		var $text = $row.find(".order-edit").hide();
  		var $text = $row.find(".order-qty").removeClass('after-edit');
          });
  	
      });
      $(document).ready(function(){
        	$(".order-save").click(function(){
  		var $row = $(this).closest("tr"); 
  		var $text = $row.find(".order-edit").show();
  		var $text = $row.find(".order-save").hide();
  		var $text = $row.find(".order-qty").addClass('after-edit');
          });
  	
      });
      
    </script>
  </head>
  <body>
    <form method="post" action="editOrder.php" role="form">
      <div class="modal-body">
        <table class="table table-striped admin-table">
          <thead>
            <tr>
              <th>Dish Name</th>
              <th>Dish Price</th>
              <th>Dish Image</th>
              <th>Qty</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $orderid = $_GET['order_id'];
            $members = mysqli_query($con, "SELECT * FROM `order_details` WHERE  order_id = $orderid");
            if (mysqli_num_rows($members) > 0) {
              while ($d_obj=mysqli_fetch_object($members)){
                $i = 0;
                $sql3 = "SELECT * FROM `dish` WHERE dish_id = $d_obj->dish_id";
                $result3 = mysqli_query($con,$sql3);
                if (mysqli_num_rows($result3) > 0) {
                  $dish_obj=mysqli_fetch_object($result3);
                  $order_details_id = $d_obj->order_details_id;
                  ?>
                  <tr>
                    <td class="nr"><?php echo $dish_obj->dish_name; ?></td>
                    <td><?php echo $d_obj->dish_price; ?></td>
                    <td><img src='<?php echo $dish_obj->dish_img; ?>'></td>
                    <td><p class="text-info" style="width: 40px;"><label><?php echo $d_obj->qty ?></label></p>
                      <input type="text" class="input-medium order-qty" style="display:none;" name="qtyy" id="qtyy_<?php echo $d_obj->order_details_id; ?>">
                    </td>
                    <td>

           	          <a class="edit_qty_item" data-order_details_id="<?php echo $d_obj->order_details_id; ?>" href="javascript:void(0)">
                          <button type="button" class="btn btn-success order-save" onclick="saveQty(this);"><span class="glyphicon glyphicon-ok"></span></button>
                      </a>
                      <button type="button" class="btn btn-info order-edit" onclick="editQty(this);"><span class="glyphicon glyphicon-pencil"></span></button><!-- </p> -->
                      
                      <a class="delete_order_item" data-order_details_id="<?php echo $d_obj->order_details_id; ?>" href="javascript:void(0)">
                        <button type="button" class="btn btn-danger" ><span class="glyphicon glyphicon-remove"></span></button>
                      </a>
                    </td>
                  </tr>
                  <?php
                }
              }
            }?>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <div class="col-md-3 noPadding">
          <div class="form-group">
            <select class="form-control" id="order_status" name='order_status' required="required">
            </select>
  		
          </div>
        </div>
        <div class="col-md-2 text-left">
  	<input type="submit" class="btn btn-primary" name="submit" value="Update" />
        </div>

        <input type="hidden" class="form-control" id="order_idd" name="order_idd" value="<?php echo $orderid;?>" hidden="true"/>
        <?php 
        echo '<a class="print_item" href="invoice.php?orderid='.$orderid.'">
        <button type="button" class="btn btn-success">Print</button>
        </a>' ?>
        &nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </form>
  </body>
  </html>
  <?php
  mysqli_close($con);
  ?>