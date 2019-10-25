<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//
require_once '../../config/database.php';
require_once '../../models/Products.php';
//

$database = new Database();
$db = $database->getConnection();
//
$product = new Products($db);
$product->id = isset($_GET['product_id']) ? $_GET['product_id'] : die();
//
$product->read_single();
$product_arr = array(
    'product_id' => $product->id,
    'name' => $product->name,
    'description' => $product->description,
    'price' => $product->price,
    'department_id' => $product->department_id,
    'department_name' => $product->department_name,
    'created_at' => $product->created_at
);
//Display Product
print_r(json_encode($product_arr));
