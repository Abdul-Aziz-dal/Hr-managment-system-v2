<?php
require_once('Database.class.php');
require_once __DIR__ . '/../config/helpers.php';
checkRequestMethod();
session_start();
class Auth
{
    //****Variables*****//
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }

    public function verifyLogin($email, $password)
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result  = $this->db->query($query);
            $user = mysqli_fetch_assoc($result);
            if (!$user) {
                throw new Exception('User Account Not Found.');
            }

            //*****Check If Account is Active*******//
            if ($user['Status'] != 1) {
                throw new Exception('Your account has been deactivated');
            }

            if ($user['Password'] != $password) {
                throw new Exception('Wrong Credentials');
            }
            $_SESSION['user'] = $user;
            $response = [
                'status' => true,
                'message' => 'Login Successfull',
                'data' => ['user' => $_SESSION['user']]
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

    public function logout()
    {

        try {
            session_unset();
            session_destroy();
            $response = [
                'status' => true,
                'message' => 'Logout Successfull!',

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
