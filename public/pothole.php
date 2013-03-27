<?php
include 'boot.php';
include 'header.php';

$pothole = new Pothole($_GET['pothole_id']);

if (!$pothole->get('pothole_id'))
{
	header('Location: /404.php', false, 404);
	exit();
}

$images = $pothole->getImages();
?>
	<div class="row-fluid">
		<div id="pothole-details" class="span6">
			<div id="myCarousel" class="carousel slide">
				<ol class="carousel-indicators">
<?php 
$count = 0;
$active = 'active';
foreach ($images as $image)
{
?>			
                  <li data-target="#myCarousel" data-slide-to="<?php echo $count; ?>" class="<?php echo $active;?>"></li>
<?php 
	$active = '';
	$count++;
}
?>
                </ol>
                <div class="carousel-inner">
<?php 
$active = 'active ';
foreach ($images as $image)
{
?>
                  <div class="<?php echo $active;?>item">
                    <img class="image-center" src="/uploads/600x600_<?php echo $image->get('filename');?>" alt="">
                  </div>
<?php 
	$active = '';
}
?>
                </div>
<?php 
if (count($images) > 1)
{
?>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
<?php 
}
?>
              </div>
				<div>
					<h5>Reported by <?php echo $pothole->get('nickname')?> on the <?php echo date('d/m/Y', $pothole->get('report_date')); ?></h5>
					<p><?php echo $pothole->get('description')?></p>
				</div>
		</div>
		<div class="span6">
			<div id="map_canvas"></div>
		</div>
	</div>
	<div class="row-fluid">
		<!-- Button to trigger modal -->
		<a href="#myModal" role="button" class="pull-right btn btn-danger" data-toggle="modal"><i class="icon-warning-sign icon-white"></i> Report</a>
	</div> 
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
		<textarea class="input-xlarge" id="report-message" class="required" rows="4"></textarea>
	</form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-danger" id="post-report"><i class="icon-warning-sign icon-white"></i> Report</button>
  </div>
</div>
<script type="text/javascript">
	var lat = <?php echo $pothole->get('lat');?>;
	var lng = <?php echo $pothole->get('lng');?>;
</script>
<?php
$js = array('pothole');
include 'footer.php';
