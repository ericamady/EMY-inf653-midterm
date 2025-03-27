
<?php
// The below code is setup for submitting an category to a db on a website

//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once "../../config/Database.php";
include_once "../../models/Categories.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate categories object
//pass database inside of object
//categories object created from the Categories class in Categories.php
$categories = new Categories($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Checks for required parameters 
if (!isset($data->category)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}



// Set up ID to update
$categories->id = $data->id;

//Assign data to authors

$categories->category = $data->category;


//update author
if($categories->update()){
    echo json_encode(
        array('message' =>'Category Updated'));

    }else{
        echo json_encode(
            array('message' =>'Category Not Updated'));

    }
