<?php
// The below code is setup for deleting an author on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once "../../config/Database.php";
include_once "../../models/Authors.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate authors object
//pass database inside of object
//authors object created from the Authors class in Authors.php
$authors = new Authors($db);

//Get raw author data
$data = json_decode(file_get_contents("php://input"));

// Set up ID to update
$authors->id = $data->id;



//delete author
if($authors->delete($authors->id)){
    echo json_encode(array('id' => $authors->id));

    }else{
        echo json_encode(
            array('message' =>'No Author Found'));

    }
