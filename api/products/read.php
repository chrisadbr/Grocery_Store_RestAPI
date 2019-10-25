<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../models/Products.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();

//Instantiate blog Post object
$product = new Products($db);

//Blog Post query
$result = $product->read();
//Get row count
$num = $result->rowCount();

//Check if any posts
if ($num > 0) {
    //Post array
    $product_arr = array();
    $product_arr['data'] = array();
    //
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        //
        extract($row);
        $product_item = array(
            'product_id' => $product_id,
            'name' => $name,
            'description' => html_entity_decode($description),
            'price' => $price,
            'department_id' => $department_id,
            'dpt_name' => $department_name
        );

        //Push to data 
        array_push($product_arr['data'], $product_item);
    }
    //Turn on to JSON
    echo json_encode($product_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
    //No posts
    echo json_encode(array(
        'message' => 'No products found'
    ));
}
