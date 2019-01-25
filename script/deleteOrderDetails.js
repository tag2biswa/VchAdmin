$(document).ready(function(){ 
$('.delete_order_item').click(function(e){ 
	e.preventDefault();
	var order_details_id = $(this).attr('data-order_details_id');
	var parent = $(this).parent("td").parent("tr");
	bootbox.dialog({
		message: "Are you sure you want to Delete this Order Item?",
		title: "<i class='glyphicon glyphicon-trash'></i> Delete !",
		buttons: {
			success: {
				label: "No",
				className: "btn-success",
				callback: function() {
					$('.bootbox').modal('hide');
				}
			},
			danger: {
				label: "Delete!",
				className: "btn-danger",
				callback: function() {
					$.ajax({
						type: 'POST',
						url: 'deleteOrderItem.php',
						data: 'order_details_id='+order_details_id
					})
					.done(function(response){
						bootbox.alert(response);
						parent.fadeOut('slow');
					})
					.fail(function(){
						bootbox.alert('Error....');
					})
				}
			}
		}
	});
});
});