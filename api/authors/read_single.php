<?php
// The below code is setup for collecting a single author on a website when author id is entered on url
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Authors.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate authors object
//pass database inside of object
//authors object created from the Authors class in Authors.php
$authors = new Authors($db);

// Get ID from URL
$authors->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get author
if ($authors->read_single()){
   //Create an array
$authors_arr = array(
   "id" => $authors->id,
   "author" =>$authors->author
   
);

//Make JSON
print_r(json_encode($authors_arr));

}else{
   echo json_encode(array ("message" => "author_id Not Found"));
}


