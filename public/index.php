<?php
include 'boot.php';
include 'header.php';

$message = false;

if (count($_POST)) {
    $pothole = new \Pothole\Pothole();

    if ($pothole->create($_POST)) {
        header('Location: /pothole.php?pothole_id=' . $pothole->get('pothole_id'));
        exit;
    } else {
        $type = 'error';
        $message = $pothole->getError();
    }
}
?>
        <div class="row-fluid">
            <form method="POST" action="/index.php" id="pothole-form">
            <fieldset>
                    <legend>Pothole Details</legend>
                    <div class="control-group">
                        <label class="visible-desktop">Your Email</label>
                        <input class="input-xlarge" type="email" id="report-email" name="report-email" required placeholder="Email address">
                    </div>
                    <div class="control-group">
                        <label class="visible-desktop">A nickname</label>
                        <input class="input-xlarge" type="text" id="report-nick" name="report-nick" required placeholder="Nickname">
                    </div>
                    <div class="control-group">
                        <label>Where's the pothole?</label>
                        <div>
                                <div id="map_canvas" style="width:100%; height:100%"></div>
                            <input type="hidden" id="lat" name="lat" value="" data-validation-required-message=
    "Please select a location" class="required" />
                                        <input type="hidden" id="lng" name="lng" value="" />
                        <div class="help-block"></div>
                    </div>
                    </div>
                    <div class="control-group">
                        <label class="visible-desktop">When did you encounter it?</label>
                        <div class="input-append date datepicker" data-date="<?php echo Date('d-m-Y'); ?>" data-date-format="dd-mm-yyyy">
                            <input size="16" type="text" value="<?php echo Date('d-m-Y'); ?>" id="report-date" name="report-date" readonly><span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="control-group">
                                  <label>How Bad? 1 (being a tooth chipper) to 5 (being the Grand Canyon)</label>
                                  <input type="radio" class="pothole-radio" value="1" id="bad-0" name="bad" data-label="1" checked data-customclass="margin-right"/>
                                  <input type="radio" class="pothole-radio" value="2" id="bad-1" name="bad" data-label="2" />
                                <input type="radio" class="pothole-radio" value="3" id="bad-2" name="bad" data-label="3" />
                                <input type="radio" class="pothole-radio" value="4" id="bad-3" name="bad" data-label="4" />
                                <input type="radio" class="pothole-radio" value="5" id="bad-4" name="bad" data-label="5" />
                    </div>
                    <div class="control-group">
                        <label class="visible-desktop">Tell us a bit more about it</label>
                        <textarea class="input-xlarge" id="report-description" name="report-description" rows="4" placeholder="Description"></textarea>
                    </div>
                    <div class="control-group">
                        <div id="bootstrapped-fine-uploader"></div>
                    </div>
                    <div class="form-actions">
                        <button id="add-pothole-button" disabled="disabled" type="submit" class="btn btn-primary">Add Pothole</button>
                    </div>
                </fieldset>
            </form>
        </div>

<?php
$js = array('add', 'jquery.fineuploader-3.3.0.min', 'jqBootstrapValidation', 'bootstrap-datepicker', 'prettyCheckable', 'jquery.addresspicker');
include 'footer.php';
