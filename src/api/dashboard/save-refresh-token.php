<?php

//****Importing Config******//
require_once '../../config/settings.php';

//****Headers*****//
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../../classes/User.class.php';

//****Read JSON Input****//
$data = json_decode(file_get_contents("php://input"), true);

//****Skip if Data is Missing****//
if (!isset($data['UserId']) || !isset($data['RefreshToken'])) {
    exit; // Simply stop execution without any output
}

//****Process the Request****//
$user = new User();
$user->saveToken($data['UserId'], $data['RefreshToken']);

?>