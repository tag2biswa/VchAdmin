$(document).ready(function(){  
$('.delete_dish').click(function(e){
	e.preventDefault();
	var dishid = $(this).attr('data-dish-id');
	var parent = $(this).parent("td").parent("tr");
	bootbox.dialog({
		message: "Are you sure you want to Delete this Dish?",
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
						url: 'deleteDish.php',
						data: 'dish_id='+dishid
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