var marker;
var map;

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
	
	var mapOptions = {
	          center: new google.maps.LatLng(lat, lng),
	          zoom: 15,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	marker = new google.maps.Marker({
        map:map,
        draggable:true,
        animation: google.maps.Animation.DROP,
        position: map.getCenter()
      });
	google.maps.event.addListener(marker, 'click', toggleBounce);
 
	$("#map_canvas").height($("#pothole-details").height());
});

function toggleBounce() 
{
	if (marker.getAnimation() != null) 
	{
      marker.setAnimation(null);
    } else {
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}