<?php
include 'boot.php';

$allowedExtensions = array('png','jpg','jpeg');
$sizeLimit = 10 * 1024 * 1024;

$uploader = new \Fine\FileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(UPLOAD_DIR);
$output = array('success' => false);
if (isset($result['success'])) {
    $output['success'] = true;
    $output['filename'] = $uploader->getUploadName();
} else {
    $output['message'] = $result['error'];
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($output);
