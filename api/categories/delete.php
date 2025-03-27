<?php
// The below code is setup for deleting a category on a website
//Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
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



// Set up ID to update
if (isset($data->id) && !empty($data->id)) {
$categories->id = $data->id;



//delete post
if($categories->delete($categories->id)){
    echo json_encode(array('id' => $categories->id));

    } else {
        echo json_encode(
            array('message' =>'No Category Found'));

    }
}
