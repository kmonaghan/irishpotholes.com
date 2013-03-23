
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

    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: auto;
        max-width: 680px;
      }
      .container .credit {
        margin: 20px 0;
      }

	/* Fine Uploader
      -------------------------------------------------- */
      .qq-upload-list {
        text-align: left;
      }
 
      /* For the bootstrapped demos */
      li.alert-success {
        background-color: #DFF0D8;
      }
 
      li.alert-error {
        background-color: #F2DEDE;
      }
 
      .alert-error .qq-upload-failed-text {
        display: inline;
      }

    </style>
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
      <div class="container">
        <div class="page-header">
          <h1>Irish Potholes</h1>
        </div>
        <p class="lead">Irish Potholes</p>
        <p>Some more details</p>

	<form method="POST" action="">
		<input type="hidden" name="lat" value="" />
		<input type="hidden" name="lng" value="" />
		<fieldset>
			<legend>Pothole Details</legend>
			<label>Your Email</label>
			<input class="span3" type="email" required>
    			<label>Where's the pothole? </label>
        		<input class="span3" type="text" id="addresspicker_map" />
        		<div style="width:300px;height:300px;margin-top:20px">
            			<div id="map_canvas" style="width:100%; height:100%"></div>
            			<div id="location" class=""></div>
        		</div>
			<label>When did you encounter it?</label>
			<div class="input-append date datepicker" data-date="<?php echo Date('d/m/Y'); ?>" data-date-format="dd/mm/yyyy">
    				<input size="16" type="text" value="<?php echo Date('d/m/Y'); ?>" readonly><span class="add-on"><i class="icon-calendar"></i></span>
			</div>
			<div class="input-wrapper">
              			<label>How Bad? 1 (being a tooth chipper) to 5 (being the Grand Canyon)</label>
              			<input type="radio" class="pothole-radio" value="1" id="Test3_0" name="Test3" data-label="1" checked data-customclass="margin-right"/>
              			<input type="radio" class="pothole-radio" value="2" id="Test3_1" name="Test3" data-label="2" />
            			<input type="radio" class="pothole-radio" value="3" id="Test3_2" name="Test3" data-label="3" />
				<input type="radio" class="pothole-radio" value="4" id="Test3_3" name="Test3" data-label="4" />
				<input type="radio" class="pothole-radio" value="5" id="Test3_4" name="Test3" data-label="5" />
			</div>
			<div class="input-wrapper" style="height:46px;">
				<div id="bootstrapped-fine-uploader"></div>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn">Add Pothole</button>
			</div>
		</fieldset>
	</form>
      </div>

      <div id="push"></div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="muted credit">Built by <a href="http://karlmonaghan.com">Karl Monaghan</a> from an idea by <a href="https://twitter.com/AaronMcAllorum">Aaron McAllorum</a>.</p>
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
            		endpoint: 'server/handleUploads'
          	},
          	text: {
            		uploadButton: '<div><i class="icon-upload icon-white"></i> Upload a picture</div>'
          	},
          	template: '<div class="qq-uploader span3">' +
                      '<pre class="qq-upload-drop-area span3"><span>{dragZoneText}</span></pre>' +
                      '<div class="qq-upload-button btn btn-success" style="width: auto;">{uploadButtonText}</div>' +
                      '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
                      '<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
                    '</div>',
		classes: {
            		success: 'alert alert-success',
            		fail: 'alert alert-error'
          	}
        });
      }

	$(function() {
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
            		})
        	});
	});
</script>
  </body>
</html>

