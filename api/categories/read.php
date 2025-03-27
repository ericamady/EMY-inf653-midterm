<?php
// The below code is setup for displaying all categories from a database on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once "../../config/Database.php";
include_once "../../models/Categories.php";

//Instantiate DB & Connect
$database = new Database();
$db = $database ->connect();

//Instantiate authors object
//pass database inside of object
//categories object created from the Authors class in Categories.php
$categories = new Categories($db);

//authors query
$result = $categories->read();

//Get row count
// use result of read object and store it in $num
$num = $result->rowCount();

//Check if there are any categories
if($num > 0){

    //create post array
$categories_arr = array();
$categories_arr["data"] = array();
//loop through result
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $categories_item = array(
        "id" => $id,
        "category" => $category_name
      

    );
    // Push to "data"
    array_push($categories_arr["data"], $categories_item);
}
//turn array to JSON & output
echo json_encode($categories_arr);
}
else{
// No posts
echo json_encode(
    array("message" => "category_id Not Found")
    );
}
