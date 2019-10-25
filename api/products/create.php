<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//
require_once '../../config/database.php';
require_once '../../models/Products.php';
//
$database = new Database();
$db = $database->getConnection();
//
$product = new Products($db);
//
//Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;
$product->department_id = $data->department_id;
//
//Add new product
if ($product->create()) {
    echo json_encode(array(
        'message' => 'New product added'
    ));
} else {
    echo json_encode(array(
        'message' => 'Failed to add a product'
    ));
}
