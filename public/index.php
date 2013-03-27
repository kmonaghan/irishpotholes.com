<?php 
include 'boot.php';
include 'header.php';

$message = false;

if (count($_POST))
{
	$pothole = new Pothole();

	if ($pothole->create($_POST))
	{
		header('Location: /pothole.php?pothole_id=' . $pothole->get('pothole_id'));
		exit;
	}
	else
	{
		$type = 'error';
		$message = $pothole->getError();
	}
}
?>
        <div class="row-fluid">
			<form method="POST" action="/index.php" id="pothole-form">
				<input type="hidden" id="lat" name="lat" value="" />
				<input type="hidden" id="lng" name="lng" value="" />
			<fieldset>	
					<legend>Pothole Details</legend>
					<div class="input-wrapper">
						<label>Your Email</label>
						<input type="email" id="report-email" name="report-email" required>
					</div>
					<div class="input-wrapper">
						<label>A nickname</label>
						<input type="text" id="report-nick" name="report-nick" required>
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
						<label>Tell us a bit more about it</label>
						<textarea id="report-description" name="report-description" rows="4"></textarea>
					</div>
					<div class="input-wrapper">
						<div id="bootstrapped-fine-uploader"></div>
					</div>
					<div class="form-actions">
						<button id="add-pothole-button" disabled="disabled" type="submit" class="btn btn-primary">Add Pothole</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
<?php
$js = array('add', 'jquery.fineuploader-3.3.0', 'bootstrap-datepicker', 'prettyCheckable', 'jquery.addresspicker', 'bootstrap-typeahead');
include 'footer.php';
