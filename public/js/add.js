function createUploader() {
                var uploader = new qq.FineUploader({
                        element: document.getElementById('bootstrapped-fine-uploader'),
                request: {
                        endpoint: 'image_uploader.php'
                },
                validation: {
                        allowedExtensions: ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG']
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
                        $('#pothole-form').append('<input type="hidden" name="images[]" value="' + response.filename + '" />');
			$('#add-pothole-button').removeAttr("disabled");
                                        }
                }
            }
        });
      }

        $(function() {
                createUploader();
//See: http://stackoverflow.com/a/3605248/806442
//Sob.  I hate JS dates.
		var currentDate = new Date();
		var currentDateString;

		currentDateString = ('0' + currentDate.getDate()).slice(-2) + '/'
             				+ ('0' + (currentDate.getMonth()+1)).slice(-2) + '/'
             				+ currentDate.getFullYear();
                $('.datepicker').datepicker({
                        format: 'dd-mm-yyyy',
                        endDate: currentDateString,
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

