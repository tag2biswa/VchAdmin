$(document).ready(function(){  
$('.delete_menu').click(function(e){
	e.preventDefault();
	var menuid = $(this).attr('data-menu-id');
	var parent = $(this).parent("td").parent("tr");
	bootbox.dialog({
		message: "Are you sure you want to Delete this Menu? Once you delete, all  dishes in this menu should be lost.",
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
						url: 'deleteMenu.php',
						data: 'menu_id='+menuid
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