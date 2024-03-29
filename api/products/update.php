<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../../config/database.php';
include_once '../../models/Products.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Products($db);

// get id of product to be edited
$product_data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$product->product_id = $product_data->product_id;

// set product property values
$product->name = $product_data->name;
$product->price = $product_data->price;
$product->description = $product_data->description;
$product->department_id = $product_data->department_id;

// update the product
if ($product->update()) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Product was updated."));
}

// if unable to update the product, tell the user
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update product."));
}
