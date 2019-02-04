$(document).ready(function(){  
$('.pull_order').click(function(e){
	e.preventDefault();
	var startdate = document.getElementById("startDate").value;
	var enddate = document.getElementById("endDate").value;
	var dataString = 'startdate=' + startdate + '&enddate=' + enddate;
	$.ajax({
                    type: "GET",
                    url: "orderdatapull.php",
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