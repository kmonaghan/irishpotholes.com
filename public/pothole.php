<?php
include 'boot.php';
include 'header.php';

$pothole = new Pothole($_GET['pothole_id']);

if (!$pothole->get('pothole_id'))
{
	header('Location: /404.php', false, 404);
	exit();
}

var_dump($pothole->get());

include 'footer.php';