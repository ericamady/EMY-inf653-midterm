
<?php
// The below code is setup for submitting an author on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
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

//check for missing parameters
if (!isset($data->author) || empty($data->author)) 
    {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;  
}



//Assign data to authors
$authors->author = $data->author;



//Create authors
if($authors->create()){
    echo json_encode(
        array('message' =>'Author Created'));

    }else{
        echo json_encode(
            array('message' =>'Author Not Created'));

    }
