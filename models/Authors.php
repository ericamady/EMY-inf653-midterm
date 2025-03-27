<?php

class Authors{
    private $conn;
    private $table = 'authors';

    // Authors properties

    public $id;
    public $author;
    
    
    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;

    }
    // Get Author
    public function read(){
        // Create Query
        $query = 'SELECT  a.author as author_name, a.id
        
        FROM
        ' . $this->table . ' a
           
            
                ORDER BY
                    a.author DESC';

                    // prepare statement
$stmt = $this->conn->prepare($query);

// execute query
$stmt->execute();
    return $stmt;
    }
//Get a Single Author
public function read_single(){
      // Create Query
      $query = 'SELECT a.author as author_name,  a.id
      
      
      FROM
      ' . $this->table . ' a
           
            WHERE
                a.id = ?

            LIMIT 1';

                // prepare statement
                $stmt = $this->conn->prepare($query);
                //Bind Id
                $stmt->bindParam(1, $this->id);
                
                //Execute query
                if($stmt->execute()){
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row){
                        $this->id = $row['id'];
                        $this->author = $row['author_name'];
                        return true;
                        
                    }else{
                        return false;
                    }
                }
                
                // Print error if something goes wrong
                printf("Error: %S.\n", $stmt->error);
                
                return false;
                    }
                              
            

//Create author
public function create(){
     //Create query
     $query = 'INSERT INTO ' . 
     $this->table . ' (author)
     VALUES(:author)';
     
 
 //prepare statement
$stmt = $this->conn->prepare($query);

//Clean data

$this->author = htmlspecialchars(strip_tags($this->author));


// Bind data


$stmt->bindParam(':author', $this->author);


//Execute Query
if($stmt->execute()){
    return true;
}

// Print error if something goes wrong
printf("Error: %S.\n", $stmt->error);

return false;
    }


//Update author
public function update(){
    //Create query
    $query = 'UPDATE ' . 
    $this->table . '
    SET  
        author = :author
        WHERE
        id = :id';

//prepare statement
$stmt = $this->conn->prepare($query);

//Clean data
$this->id = htmlspecialchars(strip_tags($this->id));
$this->author = htmlspecialchars(strip_tags($this->author));




// Bind data
$stmt->bindParam(':id', $this->id);
$stmt->bindParam(':author', $this->author);



//Execute Query
if($stmt->execute()){
   return true;
}

// Print error if something goes wrong
printf("Error: %S.\n", $stmt->error);

return false;
   }

//Delete Post
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
    return true;
 }
 
 // Print error if something goes wrong
 printf("Error: %S.\n", $stmt->error);
 
 return false;
    }


}
