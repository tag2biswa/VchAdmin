$(document).ready(function(){  
$('.active_menu').click(function(e){
	
	var menuid = $(this).attr('data-menu-id');
	var menu_active = $(this).attr('data-menu-active');

	$.ajax({
	                type: "POST",
	                url: "activeMenu.php",
	                data: 'menu_id='+menuid+'&menu_active='+menu_active,
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