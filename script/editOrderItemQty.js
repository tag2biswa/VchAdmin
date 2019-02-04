$(document).ready(function(){ 
$('.edit_qty_item').click(function(e){ 
	e.preventDefault();
	var order_details_id = $(this).attr('data-order_details_id');
	var qtyy = $("#qtyy_"+order_details_id).val();
	var dataString = 'order_details_id=' + order_details_id + '&qtyy=' + qtyy;
	$.ajax({
	                    type: "GET",
	                    url: "editOrderItemQty.php",
	                    data: dataString,
	                    cache: false,
	                    success: function (data) {
	                      //console.log(data);
	                      //modal.find('.dash').html(data);
	                    },
	                    error: function(err) {
	                      //console.log(err);
	                    }
	            }); 
});
});