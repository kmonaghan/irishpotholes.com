<?php
include 'boot.php';
include 'header.php';

$page = (isset($_GET['page']) && ($_GET['page'] > 1)) ? $_GET['page'] - 1 : 0;
$perPage = (isset($_GET['count']) && ($_GET['count'] > 0) && ($_GET['count'] <= 20)) ? $_GET['count'] : 20;
$perPage = 6;

$mapper = new PotholeMapper();
$potholes = $mapper->getAll($page, $perPage);
$pagination = $mapper->getPagination($page, $perPage);

$latlngs = array();
if ($potholes)
{
?>
<div class="row-fluid">
	<div class="span6">
                <div id="map_canvas" class="potholes-map"></div>
        </div>
	<div class="span6">
		<ul class="thumbnails">
<?php
	foreach($potholes as $pothole)
	{
		$image = $pothole->getFirstImage();
?>
		<li>
			<div class="thumbnail">
				<div class="pagination-centered">
					<a href="/uploads/<?php echo $image->get('filename');?>"><img data-src="holder.js/238x238" alt="" src="/uploads/238x238_<?php echo $image->get('filename');?>"></a>
				</div>
				<h5>Reported by <?php echo $pothole->get('nickname')?> on the <?php echo date('d/m/Y', $pothole->get('report_date')); ?></h5>
				<p><?php echo $pothole->get('description')?></p>
				<a href="/pothole.php?pothole_id=<?php echo $pothole->get('pothole_id'); ?>" class="btn btn-primary">View</a>
			</div>
		</li>
<?php
		$latlngs[] = array('lat' => $pothole->get('lat'), 'lng' => $pothole->get('lng'), 'id' => $pothole->get('pothole_id'), 'imagename' => $image->get('filename'));
	}	
?>
		</ul>
<?php 
	if ($pagination['pages'] > 1)
	{
		$start = ($pagination['currentPage'] <= 2) ? 1 : $pagination['currentPage'] - 2;
		$totalShown = $start + (($pagination['pages'] >= 5) ? 5 : $pagination['pages']);
?>
		<div class="pagination pagination-centered">
			<ul>
<?php 	if ($pagination['currentPage'] >= 2) {?>
    				<li><a href="/potholes.php?page=<?php echo ($pagination['currentPage'] - 1); ?>">Prev</a></li>
<?php 
	}
	for ($start; $start < $totalShown; $start++)
	{
?>
    				<li <?php if ($start == ($pagination['currentPage'])) echo 'class="active"'; ?>><a href="/potholes.php?page=<?php echo $start; ?>"><?php echo $start; ?></a></li>
<?php 
	}
	if ($pagination['currentPage'] < $pagination['pages']) 
	{
?>
    				<li><a href="/potholes.php?page=<?php echo ($pagination['currentPage'] + 1); ?>">Next</a></li>
<?php 	}?>
			</ul>
		</div>
<?php
	}
?>
	</div>
</div>
<script>
var latlngs = <?php echo json_encode($latlngs); ?>;
</script>
<?php
}
$js = array('potholes');
include 'footer.php';
