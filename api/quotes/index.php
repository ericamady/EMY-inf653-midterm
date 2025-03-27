<?php
header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];



    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
        //Get raw posted data
$data = json_decode(file_get_contents("php://input"));

    switch($method){
        case'GET':
            if(isset($_GET['id'])){
            include_once "../quotes/read_single.php";
            }
            else{
                include_once "../quotes/read.php";
            }
            break;
        
    
        case 'POST':
            include_once "../quotes/create.php";;
            break;
        
        case 'PUT':
            include_once "../quotes/update.php";
            break;

        case 'DELETE':
            include_once "../quotes/delete.php";
            break;

        default:
            echo json_encode(['message' => 'Invalid request method']);
            break;

    }