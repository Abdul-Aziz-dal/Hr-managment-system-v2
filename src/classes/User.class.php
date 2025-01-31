<?php
require_once('Database.class.php');
require_once __DIR__ . '/../config/helpers.php';
checkRequestMethod();
session_start();
class User
{
    //****Variables*****//
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }

    public function getUserDetails($id)
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT UserId,R.RoleId,RoleName AS Role ,Name AS FullName,Email,U.AddedOn,Status,U.UpdatedOn FROM users AS U
            INNER JOIN roles AS R ON U.RoleId = R.RoleId WHERE U.UserId = '$id' LIMIT 1";
            $result  = $this->db->query($query);

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Users data fetched successfully!',
                'data' => $data[0]
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

    public function viewUsers()
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT UserId,R.RoleId,RoleName AS Role ,Name AS FullName,Email,U.AddedOn,Status FROM users AS U
            INNER JOIN roles AS R ON U.RoleId = R.RoleId ";
            $result  = $this->db->query($query);

            $department = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Users data fetched successfully!',
                'data' => $department
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

    public function createUser($data)
    {
        try {

            //*****CheckIfExists*******//
            $email = $data['Email'];
            $name = $data['FullName'];
            $password = $data['Password'];
            $role = $data['RoleId'];
            $status = $data['Status'];
            $checkQuery = "SELECT * FROM users WHERE Email = '$email'";
            $result = $this->db->query($checkQuery);

            if ($result->num_rows > 0) {
                $response = [
                    'status' => false,
                    'message' => 'User with email already exists!'
                ];
                http_response_code(400);
            } else {
                $addedOn = date('Y-m-d H:i:s');
                $updatedOn = date('Y-m-d H:i:s');
                $insertQuery = "INSERT INTO users (Name,Email,Password,RoleId,Status, AddedOn, UpdatedOn) VALUES ('$name','$email','$password','$role','$status', '$addedOn', '$updatedOn')";
                $result = $this->db->query($insertQuery);
                $response = [
                    'status' => true,
                    'message' => 'Users added successfully!',

                ];
                http_response_code(200);
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage(),

            ];
        }

        echo json_encode($response);
    }

    public function saveToken($user_id,$refresh_token)
    {
        try {

            $updateQuery = "UPDATE users SET GoogleDriveRefreshToken='$refresh_token' WHERE UserId = '$user_id'";
            $result = $this->db->query($updateQuery);

        } catch (\Throwable $th) {
            return "";
        }
    }


    public function getUser($id)
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT UserId,R.RoleId,RoleName AS Role ,Name AS FullName,Email,U.AddedOn,Status FROM users AS U
            INNER JOIN roles AS R ON U.RoleId = R.RoleId WHERE U.UserId = '$id' ";
            $result  = $this->db->query($query);

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Users data fetched successfully!',
                'data' => $data[0]
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

    public function updateUser($data)
    {
        try {


            //*****CheckIfExists*******//
            $id = $data['UserId'];
            $email = $data['Email'];
            $name = $data['FullName'];
            $role = $data['RoleId'];
            $status = $data['Status'];
            $checkQuery = "SELECT * FROM users WHERE Email = '$email' AND  Userid <> '$id'  ";
            $result = $this->db->query($checkQuery);


            if ($result->num_rows > 0) {
                $response = [
                    'status' => false,
                    'message' => 'User email already exists!'
                ];
                http_response_code(400);
            } else {
                $addedOn = date('Y-m-d H:i:s');
                $updatedOn = date('Y-m-d H:i:s');
                $updateQuery = "UPDATE users SET Name='$name',Email='$email',RoleId='$role',Status='$status',UpdatedOn = '$updatedOn' WHERE UserId = '$id'";
                $result = $this->db->query($updateQuery);
                $response = [
                    'status' => true,
                    'message' => 'User Updated successfully!',

                ];
                http_response_code(200);
            }
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage(),

            ];
        }

        echo json_encode($response);
    }
}
