<?php
// The below code is setup for collecting a single category on a website when category_id is entered on url
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Categories.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate categories object
//pass database inside of object
//categories object created from the Categories class in Categories.php
$categories = new Categories($db);

// Get ID from URL
$categories->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get Category
if($categories->read_single()){

   //Create an array
$categories_arr = array(
   "id" => $categories->id,
   "category" =>$categories->category_name
   
);

//Make JSON
print_r(json_encode($categories_arr));

}else{
   echo json_encode(array ("message" => "category_id Not Found"));
}



