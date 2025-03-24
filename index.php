<?php
#register_shutdown_function(function (){
#   var_dump(error_get_last());
#});
require 'db.php';

function requireAllFiles($directory) : void {
    foreach (glob($directory . '/*.php') as $file) {
        require $file;
    }
}
//Requiring crud and list creation directories
requireAllFiles(__DIR__ . '/group_crud');
requireAllFiles(__DIR__ . '/student_crud');
requireAllFiles(__DIR__ . '/list_creator');

$get = $_GET;

$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];
$path = trim(parse_url($request_uri, PHP_URL_PATH), '/');


try{
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    #testCreate(3, 'Sunny', $connection);
    #groupCreate('KT-23-04', 'error', $connection);
}

catch (PDOException $e){
    echo "Connection failed " . $e->getMessage();
}

if ($path == 'api/groupsq') {
    if ($request_method == 'GET') {

        $list = readGroups($connection);

        if ($list) {
            echo json_encode(['status' => 'success!', 'data' => $list]);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Item not found']);
        }

    } elseif ($request_method === 'POST') {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $group_id = groupCreate($data, $connection);
            echo json_encode(['status' => 'success!', 'message' => 'Group created', 'group_id' => $group_id]);
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);

        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }

}elseif (preg_match('#^api/groups/(\d+)$#', $path, $matches)) {
    $group_id = $matches[1];
    if ($request_method === 'GET'){
        $item = readGroup($group_id, $connection);

        if ($item){
            echo json_encode(['status' => 'success!', 'data' => $item]);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Item not found']);
        }

    }elseif ($request_method === 'PUT'){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);


        if(json_last_error() === JSON_ERROR_NONE){
            $rowsUpdated  = groupUpdate($data, $connection);
            if ($rowsUpdated > 0){
                echo json_encode(['status' => 'success', 'message' => 'Group updated']);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Group not found']);
            }

        }else{
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
        }
    }elseif ($request_method === 'DELETE'){
        $rowsDeleted = groupDelete($group_id, $connection);
        if ($rowsDeleted > 0){
            echo json_encode(['status' => 'success', 'message' => 'Group deleted']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Group not found']);
        }
    }else{
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }

}else {
    echo json_encode(['status' => 'error', 'message' => 'Endpoint not found']);
}

/* elseif($request_method === 'POST') {
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (json_last_error() === JSON_ERROR_NONE){
    $group_id = groupCreate($data, $connection);
    echo json_encode(['status' => 'success!', 'message' => 'Group created', 'group_id' => $group_id]);
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error' , 'message' => 'Invalid JSON']);
} */
