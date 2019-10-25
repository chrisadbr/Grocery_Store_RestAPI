<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../../config/database.php';
require_once '../../models/Products.php';
//
$database = new Database();
$db = $database->getConnection();

$product = new Products($db);
//
$data = json_decode(file_get_contents("php://input"));
//
$product->product_id = $data->product_id;
//Delete Product
if ($product->delete()) {
    echo json_encode(array(
        'message' => 'Successfully Deleted Product'
    ));
} else {
    echo json_encode(array(
        'message' => 'Error Deleting Product'
    ));
}
