<?php 
include 'boot.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Irish Potholes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="humans.txt">

    <!-- CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/prettyCheckable.css" rel="stylesheet">
	<link href="/css/datepicker.css" rel="stylesheet">
	<link href="/css/fineuploader-3.3.0.css" rel="stylesheet">
	<link href="/css/pothole.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="/ico/favicon.png">
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="container-fluid">
        <div class="page-header">
          <h1>Irish Potholes</h1>
        </div>
        <p class="lead">Irish Potholes</p>
        <p>Some more details</p>

        <div class="row-fluid">
			<form method="POST" action="">
				<input type="hidden" name="lat" value="" />
				<input type="hidden" name="lng" value="" />

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
						<div class="input-append date datepicker" data-date="<?php echo Date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy">
		    				<input size="16" type="text" value="<?php echo Date('d/m/Y'); ?>" readonly><span class="add-on"><i class="icon-calendar"></i></span>
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

      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container-fluid">
        <p class="muted credit">Built by <a href="http://karlmonaghan.com">Karl Monaghan</a> from an idea by <a href="https://twitter.com/AaronMcAllorum">Aaron McAllorum</a>.&nbsp;|&nbsp;<a href="http://www.karlmonaghan.com/contact">Get in touch</a>&nbsp;|&nbsp;<a href="http://www.karlmonaghan.com/">About</a>&nbsp;|&nbsp;<a href="https://github.com/kmonaghan/irishpotholes.com">Code</a></p>
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
					}
                }
            }
        });
      }

	$(function() {
		if(navigator.geolocation) 
		{
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = new google.maps.LatLng(position.coords.latitude,
									 position.coords.longitude);

				map.setCenter(pos);
			});
		}
		
		createUploader();

		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			endDate: '<?php echo Date('d/m/Y');?>',
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
					center: new google.maps.LatLng(52.5122, 13.4194)
				}
		});

		addresspickerMap.on("addressChanged", function(evt, address) {
 			console.dir(address);
			console(address.LatLng);
		});
        
		addresspickerMap.on("positionChanged", function(evt, markerPosition) {
			markerPosition.getAddress( function(address) {
				if (address) {
					$( "#addresspicker_map").val(address.formatted_address);
				}
			});
		});
	});
</script>
  </body>
</html>

