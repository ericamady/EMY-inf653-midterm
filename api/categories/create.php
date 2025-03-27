
<?php
// The below code is setup for submitting a category on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
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

//Get raw category data
$data = json_decode(file_get_contents("php://input"));


//check for missing parameters
if (!isset($data->category) || empty($data->category)) 
    {
    echo json_encode(
        
        array('message' => 'Missing Required Parameters')
    );
    return;  
}

//Assign data to category

$categories->category = $data->category;



//Create categories
if($categories->create()){
    echo json_encode(
        array('message' =>'Category Created'));

    }else{
        echo json_encode(
            array('message' =>'Category Not Created'));

    }
