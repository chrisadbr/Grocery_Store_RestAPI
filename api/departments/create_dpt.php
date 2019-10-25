<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//
require_once '../../config/database.php';
require_once '../../models/Department.php';
//
$database = new Database();
$db = $database->getConnection();
//
$department = new Department($db);
//
$data = json_decode(file_get_contents("php://input"));
//
$department->name = $data->name;
$department->id = $data->id;
//Add new product
if ($department->create_dpt()) {
    echo json_encode(array(
        'message' => 'Successfully added a new department'
    ));
} else {
    echo json_encode(array(
        'message' => 'Successfully added a new department'
    ));
}
