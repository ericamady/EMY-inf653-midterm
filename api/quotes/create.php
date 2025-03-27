
<?php
// The below code is setup for submitting a quote, author_id and category_id on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once "../../config/Database.php";
include_once "../../models/Quotes.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate quotes object
//pass database inside of object
//quotes object created from the Quotes class in Quotes.php
$quotes= new Quotes($db);

//Get raw quotes data
$data = json_decode(file_get_contents("php://input"));

//check for missing parameters
if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id) || 
    empty($data->quote) || empty($data->author_id) || empty($data->category_id)) 
    {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;  
}

//Assign data to quotes

$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

//Create post
if($quotes->create()){
    echo json_encode(
        array('message' =>'Quote Created'));

    }else{
        echo json_encode(
            array('message' =>'Quote Not Created'));

    }
