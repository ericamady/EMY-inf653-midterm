<?php

class Categories{
    private $conn;
    private $table = 'categories';

    // Category properties

    public $id;
    public $category;
    
    
    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;

    }
    // Get category
    public function read(){
        // Create Query
        $query = 'SELECT  c.category as category_name, c.id
        
        FROM
        ' . $this->table . ' c
           
            
                ORDER BY
                    c.category DESC';

                    // prepare statement
$stmt = $this->conn->prepare($query);

// execute query
$stmt->execute();
    return $stmt;
    }
//Get a Single Category
public function read_single(){
      // Create Query
      $query = 'SELECT c.category as category_name,  c.id
      
      
      FROM
      ' . $this->table . ' c
           
            WHERE
                c.id = ?

            LIMIT 1';

                // prepare statement
                $stmt = $this->conn->prepare($query);
                //Bind Id
                $stmt->bindParam(1, $this->id);
                
                //Execute query
                if($stmt->execute()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row){
                // set properties
                $this->id = $row['id'];
                $this->category_name = $row['category_name'];
                return true;
                }
                else{
                    return false;
                }
            }
            // Print error if something goes wrong
                printf("Error: %S.\n", $stmt->error);
                    return false;

            } 

//Create category
public function create(){
     //Create query
     $query = 'INSERT INTO ' . 
     $this->table . ' (category)
     VALUES(:category)';
     
 
 //prepare statement
$stmt = $this->conn->prepare($query);

//Clean data


$this->category = htmlspecialchars(strip_tags($this->category));


// Bind data


$stmt->bindParam(':category', $this->category);


//Execute Query
if($stmt->execute()){
    return true;
}

// Print error if something goes wrong
printf("Error: %S.\n", $stmt->error);

return false;
    }


//Update category
public function update(){
    //Create query
    $query = 'UPDATE ' . 
    $this->table . '
    SET  
        category = :category
        WHERE
        id = :id';

//prepare statement
$stmt = $this->conn->prepare($query);

//Clean data
$this->id = htmlspecialchars(strip_tags($this->id));
$this->category = htmlspecialchars(strip_tags($this->category));




// Bind data
$stmt->bindParam(':id', $this->id);
$stmt->bindParam(':category', $this->category);



//Execute Query
if($stmt->execute()){
   return true;
}

// Print error if something goes wrong
printf("Error: %S.\n", $stmt->error);

return false;
   }

//Delete Category
public function delete(){
    //Create Query
    $query ='DELETE FROM ' . $this->table . ' WHERE id = :id';

    //prepare statement
$stmt = $this->conn->prepare($query);

//Clean data
$this->id = htmlspecialchars(strip_tags($this->id));

//Bind data
$stmt->bindParam(':id', $this->id);

//Execute statment
if($stmt->execute()){
    
if ($stmt->rowCount() > 0) {
    return true;        
}
    return true;
 }
 
 // Print error if something goes wrong
 printf("Error: %S.\n", $stmt->error);
 
 return false;
    }


}
