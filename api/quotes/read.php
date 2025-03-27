<?php
// The below code is setup for displaying all quotes from a database on a website
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

// Filter by author and category
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

//Quotes query
$result = $quotes->read();

//Get row count
// use result of read object and store it in $num
$num = $result->rowCount();

//Check if any quotes
if($num > 0){

//create quotes array
$quotes_arr = array();
$quotes_arr["data"] = array();

//loop through result
while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $quotes_item = array(
        "id" => $id,
        "quote" => html_entity_decode($quote),
        "author" => $author_name,
        "category" => $category_name 

    );
    // Push to "data"
    array_push($quotes_arr["data"], $quotes_item);
}
//turn array to JSON & output
echo json_encode($quotes_arr);
}else{
// No quotes
echo json_encode(
    array("message" => "No Quotes Found")
    );
}
