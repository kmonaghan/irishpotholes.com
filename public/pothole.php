<?php
include 'boot.php';
include 'header.php';

$pothole = new Pothole($_GET['pothole_id']);

if (!$pothole->get('pothole_id'))
{
	header('Location: /404.php', false, 404);
	exit();
}

// /$images = $pothole->getImages();
?>
<ul class="thumbnails">
<?php
	$image = $pothole->getFirstImage();

	?>
	<li class="span4">
		<div class="thumbnail">
			<img data-src="holder.js/300x300" alt="" src="/uploads/300x300_<?php echo $image->get('filename');?>">
			<h5>Reported by <?php echo $pothole->get('nickname')?> on the <?php echo date('d/m/Y', $pothole->get('report_date')); ?></h5>
			<p><?php echo $pothole->get('description')?></p>
		</div>
	</li>
</ul>
<!-- Button to trigger modal -->
<a href="#myModal" role="button" class="btn btn-danger" data-toggle="modal"><i class="icon-warning-sign icon-white"></i> Report</a>
 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Report pothole</h3>
  </div>
  <div class="modal-body">
	<p>
		Please add a short note about why you are reporting this pothole. 
	</p>
	<form>
		<input type="hidden" name="pothole-id" id="pothole-id" value="<?php echo $pothole->get('pothole_id'); ?>" />
		<textarea id="report-message" class="required" rows="4"></textarea>
	</form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-danger" id="post-report"><i class="icon-warning-sign icon-white"></i> Report</button>
  </div>
</div>
<?php
$js = array('pothole');
include 'footer.php';
