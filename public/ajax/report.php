<?php
include '../boot.php';

$status = 1;
$data = array('message' => '');

if (!$_POST['message'] && empty($_POST['message'])) {
    $status = 0;
    $data['message'] .= "No message supplied\n";
}

$pothole = new Pothole($_POST['pothole_id']);
if (!$pothole->get('pothole_id')) {
    $status = 0;
    $data['message'] .= "Not a valid pothole\n";
}

if ($status) {
    $message = $_POST['message'] . "\n\nhttp://irishpotholes.com/pothole.php?pothole_id=" . $_POST['pothole_id'];

    mail('karl.t.monaghan@gmail.com', '[Irish Potholes] Reported pothole', $message);

    $data['message'] = 'Thanks for getting in touch.';
}

$return = array('status' => $status, 'response' => $data);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($return);
