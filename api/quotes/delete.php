<?php
// The below code is setup for deleting a quote on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
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

//Get raw quote data
$data = json_decode(file_get_contents("php://input"));

// Set up ID to update
$quotes->id = $data->id;

//delete quote
if($quotes->delete()){
    echo json_encode(array('id' => $quotes->id));

    } 
    else{
        echo json_encode(
            array('message' =>'No Quotes Found'));

    }
