<?php
include 'boot.php';
include '/home/irishpotholes.com/Classes/php.php';

$allowedExtensions = array('png','jpg','jpeg','gif');
$sizeLimit = 10 * 1024 * 1024;

$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload('uploads/');

$output = array('success' => false);
if (isset($result['success']))
{
	$output['success'] = true;
	$output['filename'] = $uploader->getUploadName();
}
else
{
	$output['message'] = $result['error'];
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($output);