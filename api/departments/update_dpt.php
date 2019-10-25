<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//
require_once '../../models/Department.php';
require_once '../../config/database.php';
//
$database = new Database();
$db = $database->getConnection();
//
$up_dpt = new Department($db);
//
$data = json_decode(file_get_contents("php://input"));
//
$up_dpt->id = $data->id;
$up_dpt->name = $data->name;
//
if ($up_dpt->update_dpt()) {
    echo json_encode(array(
        'message' => 'Department updated'
    ));
} else {
    echo json_encode(array(
        'message' => 'Error updating department'
    ));
}
