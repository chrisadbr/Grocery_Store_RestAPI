<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';
require_once '../../models/Department.php';
//
$database = new Database();
$db = $database->getConnection();
//
$department = new Department($db);
//
$data = json_decode(file_get_contents("php://input"));
$department->id = $data->id;
//
if ($department->delete_dpt()) {
    echo json_encode(array(
        'message' => 'Successfully deleted department'
    ));
} else {
    echo json_encode(array(
        'message' => 'Error deleting department'
    ));
}
