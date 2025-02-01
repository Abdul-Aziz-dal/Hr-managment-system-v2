<?php
require_once('Database.class.php');
require_once __DIR__ . '/../config/helpers.php';
include_once(__DIR__ .'/../library/sendGrid/sendEmail.php');
require_once(__DIR__ .'/../library/Redis/RedisServer.php');
require_once(__DIR__ .'/../library/googleApi.config/config.php');
require_once(__DIR__ .'/../library/googleApi.config/GoogleDriveUploadAPI.php');


checkRequestMethod();
session_start();

class Employee{
    //****Variables*****//
    private $db;
    private $storage;
    public function __construct()
    {

        $this->db = new Database();
        $this->storage = new RedisStorage(); //Redis connectivity

    }

    public function getEmployeeDetails($id)
    {
        try {

            //*****CheckIfExists*******//
            $query = "SELECT E.*,E.EmployeeName,D.DepartmentName AS Department,U.Name AS Manager,E.Status,E.AddedOn,E.UpdatedOn FROM employees  AS E
            INNER JOIN departments AS D ON E.DepartmentId = D.DepartmentId
                INNER JOIN users AS U ON E.ManagerId = U.UserId WHERE E.EmployeeId = '$id' LIMIT 1 ";
            $result  = $this->db->query($query);

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $getEmployeeDocQuery = "SELECT * FROM employee_documents WHERE EmployeeId = '$id'";
            $getResultEmployeeDoc  = $this->db->query($getEmployeeDocQuery);

            $getEmployeeDocResult = mysqli_fetch_all($getResultEmployeeDoc, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Employee data fetched successfully!',
                'data' => $data[0],
                'documents' => $getEmployeeDocResult
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

    public function getEmployeesList()
    {
        try {

            $query = "SELECT EmployeeId ,EmployeeName FROM employees";
            $result  = $this->db->query($query);

            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            $response = [
                'status' => true,
                'message' => 'Employees data fetched successfully!',
                'data' => $data,
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


    public function uploadEmployeeDocument($EmpolyeeId,$file){
        try{
            
        $gdriveAPI = new GoogleDriveUploadAPI();
        $fileRefId="";
        if (isset($file) && !empty($file['tmp_name'])) {
            $fname = $file['name'];
    
            $upload = move_uploaded_file($file['tmp_name'],__DIR__ .'/../../pages/assets/temp/' . $fname);
            if (!$upload) {
                throw new Exception('File upload failed during temporary storage.');
            }
    
            $access_token = $_SESSION['access_token'] ?? '';
            if (empty($access_token)) {
                throw new Exception('Invalid access token. File upload failed.');
            }
    
            $mimeType = mime_content_type(__DIR__ .'/../../pages/assets/temp/' . $file['name']);
            $FileContents = file_get_contents(__DIR__ .'/../../pages/assets/temp/' . $file['name']);
    
            // Upload File to Google Drive
            $gDriveFID = $gdriveAPI->toDrive($FileContents, $mimeType);
            if (!$gDriveFID) {
                throw new Exception('File upload failed in Google Drive.');
            }
    
            $meta = ["name" => $file['name']];
            $gDriveMeta = $gdriveAPI->FileMeta($gDriveFID, $meta);
            if (!$gDriveMeta) {
                throw new Exception('Failed to update the file meta in Google Drive.');
            }
          
            $fileRefId=$gDriveFID;    
    
            unlink(__DIR__ .'/../../pages/assets/temp/' . $fname);
      }
        

        $documentQuery="INSERT INTO employee_documents (EmployeeId,DocumentReferenceId,DocumentName) 
                                               VALUES ('$EmpolyeeId', '$fileRefId', '$fname')";
        $managerDocumentResult = $this->db->query($documentQuery);



        $response = [
            'status' => true,
            'message' => 'File uploaded succesfully',
            'data' => []
        ];

    } catch (\Throwable $th) {
        $response = [
            'status' => false,
            'message' => $th->getMessage(),

        ];
        http_response_code(400);
    }

    echo json_encode($response);

          
    }

    public function getRedis($redis,$key){
        $data = json_decode($redis->get($key), true);
        return $data;
    }

    public function setRedis($redis,$key,$value){
        $redis->set($key, json_encode($value));
        $redis->expire($key, 3600); // 1 hour expiry time
    }
   
    public function executeEmployeesQuery($db){
        try{
        $query = "SELECT E.*,E.EmployeeName,D.DepartmentName AS Department,U.Name AS Manager,E.Status,E.AddedOn,E.UpdatedOn FROM employees  AS E
                  INNER JOIN departments AS D ON E.DepartmentId = D.DepartmentId
                  INNER JOIN users AS U ON E.ManagerId = U.UserId";
            $result  = $db->query($query);
            $employee = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if($employee){
                return $employee;
            }
            else{
                return [];
            }

        } catch (\Throwable $th) {
            return [];
        }  
             
    }

    public function viewEmployees()
    {
        echo "aaaaaaaaaaa";
        die;
        try {

            $employees=[];
            $redis = $this->storage->getRedisInstance();
            if ($this->storage->isConnected()) {
                if ($redis->exists('employees')) {
                    $employees=  $this->getRedis($redis,"employees");
                    $response = [
                        'status' => true,
                        'message' => 'Data retrieved from Redis',
                        'data' => $employees
                    ];
                }else{
                    //fetch from db and store in redis
                    $employees = $this->executeEmployeesQuery($this->db);
                    if (!empty($employees)) {
                         if($this->storage->isConnected()){
                         $this->setRedis($redis,'employees',$employees);
                         }

                        $response = [
                            'status' => true,
                            'message' => 'Records retrieved from database and cached in Redis',
                            'data' => $employees
                        ];
                    }else{
                        $response = [
                            'status' => true,
                            'message' => 'Records not found..!',
                            'data' => []
                        ];

                    }
                    
                    
                    
                }

            }else{
                //fetch from db
                $employees = $this->executeEmployeesQuery($this->db);
                $response = [
                    'status' => true,
                    'message' => 'Failed to connect to Redis , fetched data from database',
                    'data' => $employees
                ];

            }

            //*****CheckIfExists*******//
            
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

    public function createEmployee($data)
    {

        try {

            //*****CheckIfExists*******//
            $name =   $data['EmployeeName'];
            $email =  $data['EmployeeEmail'];
            $manager= $data['ManagerId'];
            $deptId = $data['DepartmentId'];
            $addres = $data['EmployeeAddress'];
            $status = $data['Status'];

            $checkQuery = "SELECT * FROM employees WHERE EmployeeEmail = '$email'";
            $result = $this->db->query($checkQuery);

            if ($result->num_rows > 0) {
                $response = [
                    'status' => false,
                    'message' => 'Employee with this email already exists!'
                ];
                http_response_code(400);
            } else {
                $addedOn = date('Y-m-d H:i:s');
                $updatedOn = date('Y-m-d H:i:s');
                $insertQuery = "INSERT INTO employees ( ManagerId, DepartmentId, EmployeeName, EmployeeEmail, EmpolyeeAddress, Status, AddedOn, UpdatedOn) 
                            VALUES ('$manager', '$deptId', '$name', '$email', '$addres', '$status', '$addedOn', '$updatedOn')";
                $result = $this->db->query($insertQuery);

                $deparmentQuery = "SELECT DepartmentName from departments WHERE DepartmentId='$deptId' LIMIT 1 ";
                $departmentResult = $this->db->query($deparmentQuery);
                $departmentData = mysqli_fetch_assoc($departmentResult); // Convert to associative array

                $managerQuery = "SELECT Name ,Email from users WHERE UserId='$manager' LIMIT 1 ";
                $managerResult = $this->db->query($managerQuery);
                $managerData = mysqli_fetch_assoc($managerResult); // Convert to associative array
                $managerEmail=$managerData['Email'];
                $mail= new SendGridSendEmail();
                $response=$mail->sendEmailWithCurl($managerEmail, "Hr Management", "A new employee registered", "Account Created with name : '$name' and Email : '$email' ");
                //invalidate Redis
                if ($this->storage->isConnected()) { 
                    $redis = $this->storage->getRedisInstance();
                    if ($redis->exists('employees')) {
                        $employeData = [
                            "EmployeeId" => $this->db->lastInsertId(), // Corrected for mysqli
                            "ManagerId" => $manager,
                            "DepartmentId" => $deptId,
                            "EmployeeName" => $name,
                            "EmployeeEmail" => $email,
                            "EmpolyeeAddress" => $addres,
                            "Status" => $status,
                            "AddedOn" => $addedOn,
                            "UpdatedOn" => $updatedOn,
                            "Department" => $departmentData['DepartmentName'],
                            "Manager" => $managerData['Name']
                             ];
                        $existingEmployees =  $this->getRedis($redis,"employees");
                        $existingEmployees[] = $employeData;
                        $this->setRedis($redis,'employees',$existingEmployees);
                    }
                   }

               
                $response = [
                    'status' => true,
                    'message' => 'Employee added successfully!',

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



    public function updateEmployee($data)
    {
        try {


            //*****CheckIfExists*******//
            $id = $data['EmployeeId'];
            $name = $data['EmployeeName'];

            $status = $data['Status'];


            $addedOn = date('Y-m-d H:i:s');
            $updatedOn = date('Y-m-d H:i:s');
            $updateQuery = "UPDATE employees SET EmployeeName='$name',Status='$status',UpdatedOn = '$updatedOn' WHERE EmployeeId = '$id'";
            $result = $this->db->query($updateQuery);

          
            if ($this->storage->isConnected()) {
                $redis = $this->storage->getRedisInstance();
                if ($redis->exists('employees')) {
                    $existingEmployees = $this->getRedis($redis,"employees");
                    foreach ($existingEmployees as $index => $employee) {
                        if ($employee['EmployeeId'] == $id) {
                            $existingEmployees[$index]['EmployeeName'] =$name ;
                            $existingEmployees[$index]['Status'] =$status ;
                            break;
                        }
                    }
            
                    $this->setRedis($redis,'employees',$existingEmployees);
                }
            }



            $response = [
                'status' => true,
                'message' => 'Employee Updated successfully!',

            ];

            http_response_code(200);
        } catch (\Throwable $th) {
            $response = [
                'status' => false,
                'message' => $th->getMessage(),

            ];
        }

        echo json_encode($response);
    }
}
