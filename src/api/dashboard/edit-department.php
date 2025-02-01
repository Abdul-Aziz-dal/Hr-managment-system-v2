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
require_once '../../classes/Department.class.php';


$data =  $_POST;

//****CheckParams*****//

if (!isset($data['DepartmentId']) &&  !isset($data['DepartmentName'])) {
    echo json_encode(array(
        "status" => false,
        "message" => "Department Name is required!"
    ));
    http_response_code(400);
    die;
}


//*****GettingParams*******//
$departmentName = $data['DepartmentName'];
$departmentid = $data['DepartmentId'];


$department = new Department();

$department->updateDepartment($departmentName, $departmentid);
