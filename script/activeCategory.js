$(document).ready(function(){  
$('.active_category').click(function(e){
	
	var catid = $(this).attr('data-cat-id');
	var cat_active = $(this).attr('data-cat-active');

	$.ajax({
	                type: "POST",
	                url: "activeCategory.php",
	                data: 'cat_id='+catid+'&cat_active='+cat_active,
	                cache: false,
	                success: function (data) {
	                    console.log(data);
	                    window.location.reload();
	                },
	                error: function(err) {
	                	alert('Exception:'+err );
	                    console.log(err);
	                }
	            });
e.preventDefault();
});
});