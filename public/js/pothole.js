$(function() {
	$('#post-report').click(function() {
		$.post("/ajax/report.php", { message : $('#report-message').val(), pothole_id : $('#pothole-id').val()  },
			function(data){
    				console.log(data.response.message); 
    				console.log(data.status);
				if (data.status)
				{
					$('#myModal').modal('hide');
					$('#main').prepend('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Pothole Reported</div>');
				}
				else
				{

				}
  			}, "json");
	});
});
