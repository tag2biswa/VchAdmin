$(document).ready(function(){  
$('.delete_room_type').click(function(e){
	e.preventDefault();
	var roomtypenum = $(this).attr('data-room-type-id');
	var parent = $(this).parent("td").parent("tr");
	bootbox.dialog({
		message: "Are you sure you want to Delete this Room Type? ",
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
						url: 'deleteRoomType.php',
						data: 'room_type_num='+roomtypenum
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