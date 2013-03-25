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
<?php
include 'footer.php';