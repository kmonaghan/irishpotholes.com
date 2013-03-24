<?php 
include 'boot.php';
include 'header.php';

$message = false;

if (count($_POST))
{
	$pothole = new Pothole();
	
	if ($pothole->create($_POST))
	{
		$type = 'success';
		$message = 'Thanks for adding a pothole';
	}
	else
	{
		$type = 'error';
		$message = $pothole->getError();
	}
}
?>
        <div class="page-header">
          <h1>Irish Potholes</h1>
        </div>
        <p class="lead">Irish Potholes</p>
        <p>Some more details</p>
<?php
if ($message)
{
	?>
<div class="alert alert-<?php echo $type; ?>">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo $message;?>
</div>
<?php
}
?>
        <div class="row-fluid">
			<form method="POST" action="">
				<input type="hidden" id="lat" name="lat" value="" />
				<input type="hidden" id="lng" name="lng" value="" />
				<input type="hidden" id="image" name="image" value="" />
				
					<legend>Pothole Details</legend>
					<div class="input-wrapper">
						<label>Your Email</label>
						<input type="email" id="report-email" name="report-email" required>
					</div>
					<div class="input-wrapper">
		    			<label>Where's the pothole? </label>
		        		<input type="text" id="addresspicker_map" />
		        		<div style="width:280px;height:300px;margin-top:20px">
		            			<div id="map_canvas" style="width:100%; height:100%"></div>
		            			<div id="location" class=""></div>
		        		</div>
		        	</div>
		        	<div class="input-wrapper">
						<label>When did you encounter it?</label>
						<div class="input-append date datepicker" data-date="<?php echo Date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
		    				<input size="16" type="text" value="<?php echo Date('d-m-Y'); ?>" id="report-date" name="report-date" readonly><span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>
					<div class="input-wrapper">
		              			<label>How Bad? 1 (being a tooth chipper) to 5 (being the Grand Canyon)</label>
		              			<input type="radio" class="pothole-radio" value="1" id="bad-0" name="bad" data-label="1" checked data-customclass="margin-right"/>
		              			<input type="radio" class="pothole-radio" value="2" id="bad-1" name="bad" data-label="2" />
		            			<input type="radio" class="pothole-radio" value="3" id="bad-2" name="bad" data-label="3" />
								<input type="radio" class="pothole-radio" value="4" id="bad-3" name="bad" data-label="4" />
								<input type="radio" class="pothole-radio" value="5" id="bad-4" name="bad" data-label="5" />
					</div>
					<div class="input-wrapper">
						<div id="bootstrapped-fine-uploader"></div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn">Add Pothole</button>
					</div>
			</form>
		</div>
      </div>

	<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/bootstrap-typeahead.js"></script>
	<script src="/js/jquery.addresspicker.js"></script>
	<script src="/js/prettyCheckable.js"></script>
	<script src="/js/bootstrap-datepicker.js"></script>
	<script src="/js/jquery.fineuploader-3.3.0.js"></script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-5653857-13', 'irishpotholes.com');
	ga('send', 'pageview');

	function createUploader() {
		var uploader = new qq.FineUploader({
			element: document.getElementById('bootstrapped-fine-uploader'),
          	request: {
            		endpoint: 'image_uploader.php'
          	},
          	validation: {
          		allowedExtensions: ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF']
          	},
          	text: {
            		uploadButton: '<i class="icon-upload icon-white"></i> Upload a picture'
          	},
          	template: '<div class="qq-uploader">' +
                      '<pre class="qq-upload-drop-area"><span>{dragZoneText}</span></pre>' +
                      '<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' +
                      '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
                      '<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
                    '</div>',
			classes: {
            		success: 'alert alert-success',
            		fail: 'alert alert-error'
          	},
          	callbacks: {
                onComplete: function(id, name, response) {
					if (response.success)
					{
                    	console.log('filename: ' + response.filename);
                    	$('#image').val(response.filename);
					}
                }
            }
        });
      }

	$(function() {
		createUploader();

		$('.datepicker').datepicker({
			format: 'dd-mm-yyyy',
			endDate: '<?php echo Date('d-m-Y');?>',
			todayHighlight: true,
			autoclose: true,
		});

		$('input.pothole-radio').prettyCheckable();

		var addresspickerMap = $( "#addresspicker_map" ).addresspicker(
        	{
				regionBias: "ie",
				map:      "#map_canvas",
				typeaheaddelay: 1000,
				mapOptions: {
					zoom:16,
					center: new google.maps.LatLng(53.4239331, -7.940689799999973)
				}
		});

		addresspickerMap.on("addressChanged", function(evt, address) {
 			//console.dir(address);
			$('#lat').val(address.geometry.location.lat());
			$('#lng').val(address.geometry.location.lng());
		});
        
		addresspickerMap.on("positionChanged", function(evt, markerPosition) {
			console.log('positionChanged');
			markerPosition.getAddress( function(address) {
				if (address) {
					$( "#addresspicker_map").val(address.formatted_address);
				}
			});

			$('#lat').val(markerPosition.lat());
			$('#lng').val(markerPosition.lng());
		});

		if(navigator.geolocation) 
		{
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = new google.maps.LatLng(position.coords.latitude,
									 position.coords.longitude);
				//var map = addresspickerMap.map;
				//map.setCenter(pos);
			});
		}
	});
</script>
<?php
include 'footer.php';
