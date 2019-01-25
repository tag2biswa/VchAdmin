$(document).ready(function(){
$('.delete_record').click(function(e){
	e.preventDefault();
	var catid = $(this).attr('data-rec-id');
	var parent = $(this).parent("td").parent("tr");
	alert('hghhjb');
	bootbox.dialog({
		message: "Are you sure you want to Delete ?",
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
						url: 'deleteRecords.php',
						data: 'empid='+empid
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