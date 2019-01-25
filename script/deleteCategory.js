$(document).ready(function(){  
$('.delete_category').click(function(e){
	e.preventDefault();
	var catid = $(this).attr('data-cat-id');
	var parent = $(this).parent("td").parent("tr");
	bootbox.dialog({
		message: "Are you sure you want to Delete this Category? Once you delete, all menu and dishes in this category should be lost.",
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
						url: 'deleteCategory.php',
						data: 'cat_id='+catid
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