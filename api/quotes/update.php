
<?php
// The below code is setup for submitting a post on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once "../../config/Database.php";
include_once "../../models/Quotes.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate quotes object
//pass database inside of object
//quotes object created from the Quotes class in Quotes.php
$quotes = new Quotes($db);

//Get raw quotes data
$data = json_decode(file_get_contents("php://input"));


// Checks for required parameters 
if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters')
    );
    return;
}

// Set up ID to update
$quotes->id = $data->id;

//Assign data to quotes

$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

// Checks quote
if (empty($quotes->quote) || $quotes->quote == '') {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
    return;
}
// Checks author_id
if (empty($quotes->author_id) || $quotes->author_id == 0) {
    echo json_encode(
        array('message' => 'author_id Not Found')
    );
    return;
}

//Checks category_id
if (empty($quotes->category_id) || $quotes->category_id == 0) {
    echo json_encode(
        array('message' => 'category_id Not Found')
    );
    return;
}

//update quote
if($quotes->update()){
    echo json_encode(
        array('message' =>'Quote Updated'));

    }else{
        echo json_encode(
            array('message' =>'Quote Not Updated'));

    }
