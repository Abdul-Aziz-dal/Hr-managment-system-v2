<?php
require_once('Database.class.php');
require_once __DIR__ . '/../config/helpers.php';
checkRequestMethod();
session_start();
class Dashboard
{
    //****Variables*****//
    private $db;
    public function __construct()
    {

        $this->db = new Database();
    }

    public function viewDashboard()
    {
        try {

            //*****CheckIfExists*******//
            $queryDpartments = "SELECT count(*) AS count FROM departments";
            $resultDpartments  = $this->db->query($queryDpartments);
            $department = mysqli_fetch_all($resultDpartments, MYSQLI_ASSOC);

            $queryEmployees = "SELECT count(*) AS count FROM employees";
            $resultEmployees  = $this->db->query($queryEmployees);
            $employees = mysqli_fetch_all($resultEmployees, MYSQLI_ASSOC);

            $queryEmployeesPermenant = "SELECT count(*) AS count FROM employees WHERE Status=2";
            $resultEmployeesPermenant  = $this->db->query($queryEmployeesPermenant);
            $employeesPermenant = mysqli_fetch_all($resultEmployeesPermenant, MYSQLI_ASSOC);

            $queryRoles = "SELECT count(*) AS count FROM roles";
            $resultRoles  = $this->db->query($queryRoles);
            $roles = mysqli_fetch_all($resultRoles, MYSQLI_ASSOC);

            $queryUsers = "SELECT count(*) AS count FROM users";
            $resultUsers  = $this->db->query($queryUsers);
            $users = mysqli_fetch_all($resultUsers, MYSQLI_ASSOC);


            $response = [
                'status' => true,
                'message' => 'data fetched successfully!',
                'department' => $department,
                'employees'  => $employees,
                'employeesPermenant' => $employeesPermenant,
                'roles' => $roles,
                'users' => $users
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