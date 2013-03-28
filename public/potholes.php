<?php
include 'boot.php';
include 'header.php';

$page = (isset($_GET['page']) && ($_GET['page'] > 1)) ? $_GET['page'] - 1 : 0;
$perPage = (isset($_GET['count']) && ($_GET['count'] > 0) && ($_GET['count'] <= 20)) ? $_GET['count'] : 20;

$mapper = new PotholeMapper();
$potholes = $mapper->getAll($page, $perPage);
$pagination = $mapper->getPagination($page, $perPage);

if ($potholes)
{
?>
<ul class="thumbnails">
<?php
	foreach($potholes as $pothole)
	{
		$image = $pothole->getFirstImage();
?>
	<li>
		<div class="thumbnail">
			<div class="pagination-centered">
				<a href="/uploads/<?php echo $image->get('filename');?>"><img data-src="holder.js/300x300" alt="" src="/uploads/300x300_<?php echo $image->get('filename');?>"></a>
			</div>
			<h5>Reported by <?php echo $pothole->get('nickname')?> on the <?php echo date('d/m/Y', $pothole->get('report_date')); ?></h5>
			<p><?php echo $pothole->get('description')?></p>
			<a href="/pothole.php?pothole_id=<?php echo $pothole->get('pothole_id'); ?>" class="btn btn-primary">View</a>
		</div>
	</li>
<?php
	}	
?>
</ul>
<?php 
	if ($pagination['pages'] > 1)
	{
?>
<div class="pagination pagination-centered">
  <ul>
<?php if ($pagination['currentPage'] > 2) {?>
    <li><a href="/potholes.php?page=<?php echo ($pagination['currentPage'] - 1); ?>">Prev</a></li>
<?php }?>
    <li><a href="/potholes.php?page=">1</a></li>
    <li><a href="/potholes.php?page=">2</a></li>
    <li><a href="/potholes.php?page=">3</a></li>
    <li><a href="/potholes.php?page=">4</a></li>
    <li><a href="/potholes.php?page=">5</a></li>
<?php if ($pagination['currentPage'] < $pagination['pages']) {?>
    <li><a href="/potholes.php?page=<?php echo ($pagination['currentPage'] + 1); ?>">Next</a></li>
<?php }?>
  </ul>
</div>
<?php
	}
}

include 'footer.php';