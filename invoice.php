
<?php
require_once __DIR__ . '/db_config.php';
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD,DB_DATABASE) or die(mysqli_connect_error());
$order_id = $_REQUEST['orderid'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>Invoice</title>
	<link rel='stylesheet' type='text/css' href='css/styleprint.css' />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>

	<style type="text/css" media="print">
		@media print {
		  body {-webkit-print-color-adjust: exact;}
		}
		
	</style>

	<script type="text/javascript">     
    function PrintDiv() {    
     var printContents = document.getElementById('page-wrap').innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
    }
 </script>
</head>

<body>
	<div id="page-wrap">

		<textarea id="header">MEMO</textarea>
		
		<div id="identity">

			<span id="address">
				Marine Drive Road, Sea Beach, 
				Puri, Odisha 752001
			</span>

			<div id="logo">
				<img id="image" src="images/vch_logo.png" alt="logo" />
			</div>

		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

			<Label id="customer-title">Victoria Club Hotel</Label>

			<table id="meta">
				<tr>
					<td class="meta-head">OrderNo. #</td>
					<td><div><label id="invoice_num"><?php echo $order_id; ?></label></div></td>
				</tr>
				<tr>

					<td class="meta-head">Date</td>
					<td><div id="date"><?php echo date("d/m/Y")?></div></td>
				</tr>
				<?php
				$order_status = mysqli_query($con, "SELECT * FROM `order_status` WHERE  order_id = $order_id");
				if (mysqli_num_rows($order_status) > 0) {
					$g_obj=mysqli_fetch_object($order_status);
				}
				?>
				<tr>
					<td class="meta-head">Delivery Place</td>
					<td><?php echo $g_obj->place_delivery ?></td>
				</tr>
				<tr>

					<td class="meta-head">Delivery Time</td>
					<td><div id="date"><?php echo $g_obj->last_modification_time ?></div></td>
				</tr>
				
			</table>

		</div>
		
		<table id="items">

			<tr>
				<th>No.#</th>
				<th>Dish Name</th>
				<th>Dish Price</th>
				<th>Qty</th>
			</tr>
			<?php
			$members = mysqli_query($con, "SELECT * FROM `order_details` WHERE  order_id = $order_id");
			if (mysqli_num_rows($members) > 0) {
				$total = 0;
				$i = 1;
				while ($d_obj=mysqli_fetch_object($members)){
					$sql3 = "SELECT * FROM `dish` WHERE dish_id = $d_obj->dish_id";
					$result3 = mysqli_query($con,$sql3);
					if (mysqli_num_rows($result3) > 0) {
						$dish_obj=mysqli_fetch_object($result3);
						$order_details_id = $d_obj->order_details_id;
						?>
						<tr class="item-row">
							<td><?php echo $i; ?></td>
							<td><?php echo $dish_obj->dish_name; ?></td>
							<td><i class="fa fa-inr"></i><?php echo $d_obj->dish_price; ?></td>
							<td><?php echo $d_obj->qty ?></td>
						</tr>

						<?php
					}
					$i = $i + 1;
					$total = $total + ( $d_obj->qty * $d_obj->dish_price );
				}
			}
			?>

			<tr id="hiderow">
				<td colspan="4" style="padding:0;"><!-- <a id="addrow" href="javascript:;" title="Add a row">Add a row</a> --></td>
			</tr>

			<tr>
				<td colspan="2" class="blank" style="border: 1px solid #fff;border-right: 1px solid black;"> </td>
				
				<td colspan="1" class="total-line balance">Balance Due</td>
				<td class="total-value balance"><div class="due"><i class="fa fa-inr"></i><?php echo $total; ?></div></td>
			</tr>

		</table>
		
		<div id="terms">
			<h5>If you have any query, please contact<br> +91 9078802005</h5>
		</div>
		<br/>
		
		
		<br/>
		<br/>
		<br/>
		
	</div>
	<div align="center"><button type="button" id="printBtn" onclick="PrintDiv();" value="Print"><span>Print</span></button></div>
</body>

</html>

