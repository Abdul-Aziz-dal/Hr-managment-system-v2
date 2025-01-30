<?php

//****ImportingConfig******//
require_once '../../config/settings.php';

//****Headers*****//
header('Content-Type:application/json');
header('Access-Control-Allow-Origin: *');

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
require_once '../../classes/Employee.class.php';


$data =  $_POST;

//****CheckParams*****//

if (!isset($data['EmployeeId']) &&  !isset($data['EmployeeName'])) {
    echo json_encode(array(
        "status" => false,
        "message" => "Fields are required!"
    ));
    http_response_code(400);
    die;
}



$employee = new Employee();

$employee->updateEmployee($data);
