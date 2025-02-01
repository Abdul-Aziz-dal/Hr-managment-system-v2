<?php
require_once('Database.class.php');
require_once __DIR__ . '/../config/helpers.php';
checkRequestMethod();
session_start();
class Roles
{
    //****Variables*****//
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }

    public function getAllRoles()
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT * FROM roles";
            $result  = $this->db->query($query);

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Roles data fetched successfully!',
                'data' => $data
            ];
            http_response_code(200);
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage(),

            ];
            http_response_code(400);
        }

        echo json_encode($response);
    }
}
