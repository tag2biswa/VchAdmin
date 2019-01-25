$(document).ready(function(){  
$('.active_dish').click(function(e){
	
	var dishid = $(this).attr('data-dish-id');
	var dish_active = $(this).attr('data-dish-active');

	$.ajax({
	                type: "POST",
	                url: "activeDish.php",
	                data: 'dish_id='+dishid+'&dish_active='+dish_active,
	                cache: false,
	                success: function (data) {
	                    console.log(data);
	                    window.location.reload();
	                },
	                error: function(err) {
	                    console.log(err);
	                }
	            });
e.preventDefault();
});
});