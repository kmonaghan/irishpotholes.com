<?php
include 'boot.php';
include 'header.php';

$page = (isset($_GET['page']) && ($_GET['page'] > 1)) ? $_GET['page'] : 0;
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
	<li class="span4">
		<div class="thumbnail">
			<img data-src="holder.js/300x300" alt="" src="/uploads/300x300_<?php echo $image->get('filename');?>">
			<h5>Reported by <?php echo $pothole->get('nickname')?> on the <?php echo date('d/m/Y', $pothole->get('report_date')); ?></h5>
			<p><?php echo $pothole->get('description')?></p>
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
    <li><a href="/potholes.php?page=">Prev</a></li>
    <li><a href="/potholes.php?page=">1</a></li>
    <li><a href="/potholes.php?page=">2</a></li>
    <li><a href="/potholes.php?page=">3</a></li>
    <li><a href="/potholes.php?page=">4</a></li>
    <li><a href="/potholes.php?page=">5</a></li>
    <li><a href="/potholes.php?page=">Next</a></li>
  </ul>
</div>
<?php
	}
}

include 'footer.php';