<?php
require_once('Database.class.php');
require_once __DIR__ . '/../config/helpers.php';
checkRequestMethod();
session_start();
class Department
{
    //****Variables*****//
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }

    public function viewDepartments()
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT * FROM departments";
            $result  = $this->db->query($query);

            $department = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Departments data fetched successfully!',
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

    public function createDepartment($deptName)
    {
        try {

            //*****CheckIfExists*******//

            $checkQuery = "SELECT * FROM departments WHERE DepartmentName = '$deptName'";
            $result = $this->db->query($checkQuery);

            if ($result->num_rows > 0) {
                $response = [
                    'status' => false,
                    'message' => 'Department name already exists!'
                ];
                http_response_code(400);
            } else {
                $addedOn = date('Y-m-d H:i:s');
                $updatedOn = date('Y-m-d H:i:s');
                $insertQuery = "INSERT INTO departments (DepartmentName, AddedOn, UpdatedOn) VALUES ('$deptName', '$addedOn', '$updatedOn')";
                $result = $this->db->query($insertQuery);
                $response = [
                    'status' => true,
                    'message' => 'Department added successfully!',

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

    public function getDepartmentDetails($id)
    {
        try {

            //*****CheckIfExists*******//

            $checkQuery = "SELECT * FROM departments WHERE DepartmentId = '$id' LIMIT 1";
            $result = $this->db->query($checkQuery);

            if ($result->num_rows == 0) {
                $response = [
                    'status' => false,
                    'message' => 'No Data Found!'
                ];
                http_response_code(400);
            } else {
                $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $response = [
                    'status' => true,
                    'data' => $data,
                    'message' => 'Department Details fetched successfully!',

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

    public function updateDepartment($deptName, $id)
    {
        try {

            //*****CheckIfExists*******//

            $checkQuery = "SELECT * FROM departments WHERE DepartmentName = '$deptName' AND DepartmentId <> '$id'";
            $result = $this->db->query($checkQuery);

            if ($result->num_rows > 0) {
                $response = [
                    'status' => false,
                    'message' => 'Department name already exists!'
                ];
                http_response_code(400);
            } else {
                $addedOn = date('Y-m-d H:i:s');
                $updatedOn = date('Y-m-d H:i:s');
                $updateQuery = "UPDATE departments SET DepartmentName='$deptName',UpdatedOn = '$updatedOn' WHERE DepartmentId = '$id'";
                $result = $this->db->query($updateQuery);
                $response = [
                    'status' => true,
                    'message' => 'Department Updated successfully!',

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
