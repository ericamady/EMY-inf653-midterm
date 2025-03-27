<?php
// The below code is setup for collecting a single quote on a website when quote id is entered on url
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Quotes.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate quotes object
//pass database inside of object
//quotes object created from the Quotes class in Quotes.php
$quotes = new Quotes($db);

// Get ID from URL
$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();

if(isset($_GET['author_id'])){
   $author_id = $_GET['author_id'];
   $quotes->author_id = $author_id;
}

else{
   $quotes->author_id = null;
}

if(isset($_GET['category_id'])){
   $category_id = $_GET['category_id'];
   $quotes->category_id = $category_id;
}

else{
   $quotes->category_id = null;
}


//Get Quotes
if($quotes->read_single()){
   //Create an array
   $quotes_arr = array(
   "id" => $quotes->id,
   "quote" => $quotes->quote,
   "author" =>$quotes->author_name,
   "category" => $quotes->category_name
);

//Make JSON
print_r(json_encode($quotes_arr));
}
else{
   echo json_encode(array ("message" => "No Quotes Found"));
}



