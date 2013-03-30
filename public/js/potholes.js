var marker;
var map;
var infowindow = null;

$(function() {
//	info_window = new google.maps.InfoWindow();

	infowindow = new google.maps.InfoWindow({
                content: "loading..."
        });

	var mapOptions = {
	          center: new google.maps.LatLng(53.4239331, -7.940689799999973),
	          zoom: 7,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	if (latlngs.length)
	{
		var total = latlngs.length;
		var latlngbounds = new google.maps.LatLngBounds();
		
		for (var i = 0; i < total; i++)
		{ 
			var currentLatLng = new google.maps.LatLng(latlngs[i].lat, latlngs[i].lng);

			var marker = new google.maps.Marker({
				position: currentLatLng,
				map:map,
				animation: google.maps.Animation.DROP,
			});

			marker.note = '<img src="/uploads/100x100_' + latlngs[i].imagename + '" /><a href="/pothole.php?pothole_id=' + latlngs[i].id + '">View</a>';

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.content = this.note;
				infowindow.open(map,this);
			});

			latlngbounds.extend(currentLatLng);
		}

		map.setCenter(latlngbounds.getCenter());
		map.fitBounds(latlngbounds); 
	}
});
