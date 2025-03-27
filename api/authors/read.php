<?php
// The below code is setup for displaying all authors from a database on a website
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

//authors query
$result = $authors->read();

//Get row count
// use result of read object and store it in $num
$num = $result->rowCount();

//Check if there are any authors
if($num > 0){

    //create author array
$authors_arr = array();
$authors_arr["data"] = array();
//loop through result
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $authors_item = array(
        "id" => $id,
        "author" => $author_name
      

    );
    // Push to "data"
    array_push($authors_arr["data"], $authors_item);
}
//turn array to JSON & output
echo json_encode($authors_arr);
}else{
// No authors
echo json_encode(
    array("message" => "author_id Not Found")
    );
}
