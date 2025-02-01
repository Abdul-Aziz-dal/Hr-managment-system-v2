<?php

//****ImportingConfig******//
require_once '../../config/settings.php';

//****Headers*****//
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//*****CheckPostRequest*******//
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    echo json_encode(array(
        "status" => false,
        "message" => "Invalid Request Method"
    ));
    http_response_code(400);
    die;
}

//*****ImportingLibraies******//
require_once '../../classes/Auth.class.php';

//****Get Raw JSON Request Body*****//
$data =  $_POST;

//****CheckParams*****//

if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(array(
        "status" => false,
        "message" => "Email and Password is required!"
    ));
    http_response_code(400);
    die;
}


//*****GettingParams*******//
$email = $data['email'];
$password = $data['password'];

$auth = new Auth();

$auth->verifyLogin($email, $password);
