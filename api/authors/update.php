
<?php
// The below code is setup for updating an author to a db on a website

//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
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

//Get raw authors data
$data = json_decode(file_get_contents("php://input"));



// Set up ID to update
$authors->id = isset($data->id) ? $data->id : null;


//Assign data to authors
$authors->author = isset($data->author) ? $data->author : null;



// Checks for required parameters 
if (empty($authors->author)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}

if (empty($authors->id)) {
    echo json_encode(
        array('message' => $authors->id . ' Not Found')
    );
    return;
}




//update author
if($authors->update()){
    echo json_encode(
        array('message' => 'Author Updated')
    );
    return;

    }else{
        echo json_encode(
            array('message' =>'Author NOT Updated'));

    }
