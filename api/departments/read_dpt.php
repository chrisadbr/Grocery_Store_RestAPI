<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once '../../config/database.php';
require_once '../../models/Department.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->getConnection();
//
$read_dpt = new Department($db);
$result = $read_dpt->read_dpt();

if ($result->rowCount() > 0) {
    $dpt_arr = array();
    $dpt_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $dpt_item = array(
            'id' => $id,
            'name' => $name
        );
        array_push($dpt_arr['data'], $dpt_item);
    }
    echo json_encode($dpt_arr);
} else {
    echo json_encode(array(
        'message' => 'No department found'
    ));
}
