<?php

//****CheckRequestMethod*******//
function checkRequestMethod()
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('HTTP/1.0 403 Forbidden');
        echo json_encode(array(
            "status" => false,
            "message" => "Forbidden: Direct access to this file is not allowed"
        ));
        exit;
    }
}
