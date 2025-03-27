<?php

class Quotes{
    private $conn;
    private $table = 'quotes';

    // Quotes properties

    public $id;
    public $quote;
    public $author_id;
    public $author;
    public $category_id;
    public $category;
    
    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;

    }
    // Get Quote
    public function read(){
        // Create Query
        $query = 'SELECT q.id, q.quote, a.author as author_name,  c.category as category_name 
        
        FROM
        ' . $this->table . ' q
            LEFT JOIN
                    authors a ON q.author_id = a.id
            LEFT JOIN
                    categories c ON q.category_id = c.id';             

                $filters = [];

                    if(!empty($this->author_id)){
                        $filters[] = ' q.author_id = :author_id';
                }
    
                    if(!empty($this->category_id)){
                        $filters[] = ' q.category_id = :category_id';
                }

                if(!empty($filters)){
                    $query .= ' WHERE '. implode(' AND ', $filters);
                }
                  
                $query .= ' ORDER BY a.author DESC';


                    // prepare statement
$stmt = $this->conn->prepare($query);

//clean filter ids

$this->author_id = htmlspecialchars(strip_tags($this->author_id));
$this->category_id = htmlspecialchars(strip_tags($this->category_id));

//Bind Id



if(!empty($this->author_id)){
$stmt->bindParam(':author_id', $this->author_id);
}

if(!empty($this->category_id)){
    $stmt->bindParam(':category_id', $this->category_id);
}


// execute query
$stmt->execute();
    return $stmt;
    }
//Get Single Quote
public function read_single(){


      // Create Query
      $query = 'SELECT q.id, q.quote, a.author as author_name,  c.category as category_name, q.category_id
      
      
      FROM
      ' . $this->table . ' q
            LEFT JOIN
                  categories c ON q.category_id = c.id
            LEFT JOIN
                  authors a ON q.author_id = a.id
            WHERE
                q.id = ?';
            
                $filters = [];

                    if(!empty($this->author_id)){
                        $filters[] = ' q.author_id = :author_id';
                }
    
                    if(!empty($this->category_id)){
                        $filters[] = ' q.category_id = :category_id';
                }

                if(!empty($filters)){
                    $query .= ' WHERE '. implode(' AND ', $filters);
                }
                  
                $query .= ' ORDER BY a.author DESC';
            $query .= ' LIMIT 1';

           

                // prepare statement
                $stmt = $this->conn->prepare($query);

                //clean filter ids
               
                $this->author_id = htmlspecialchars(strip_tags($this->author_id));
                $this->category_id = htmlspecialchars(strip_tags($this->category_id));
                
                //Bind Id
                $stmt->bindParam(1, $this->id);

                if(!empty($this->author_id)){
                $stmt->bindParam(':author_id', $this->author_id);
                }

                if(!empty($this->category_id)){
                    $stmt->bindParam(':category_id', $this->category_id);
                }
                
                //Execute query
                if($stmt->execute()){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row){
                    // set properties
                $this->id = $row['id'];
                $this->quote = $row['quote'];
                $this->author_name = $row['author_name'];
                $this->category_id = $row['category_id'];
                $this->category_name = $row['category_name'];

                return true;
                } else{
                    return false;
                }
                
            } 
            // Print error if something goes wrong
                printf("Error: %S.\n", $stmt->error);
                return false;

} 

//Create quote
public function create(){



     //Create query
     $query = 'INSERT INTO ' . 
     $this->table . ' (quote, author_id, category_id)
     VALUES(:quote, :author_id, :category_id)';
     
 
 //prepare statement
$stmt = $this->conn->prepare($query);

//Clean data

$this->id = htmlspecialchars(strip_tags($this->id));
$this->quote = htmlspecialchars(strip_tags($this->quote));
$this->author_id = htmlspecialchars(strip_tags($this->author_id));
$this->category_id = htmlspecialchars(strip_tags($this->category_id));


// Bind data

$stmt->bindParam(':quote', $this->quote);
$stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
$stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);

//Execute Query
if($stmt->execute()){
    return true;
}

// Print error if something goes wrong
printf("Error: %S.\n", $stmt->error);

return false;
    }


//Update post
public function update(){
    //Create query
    $query = 'UPDATE ' . 
    $this->table . '
    SET  
        quote = :quote,
        author_id = :author_id,
        category_id = :category_id
        WHERE
        id = :id';

//prepare statement
$stmt = $this->conn->prepare($query);

//Clean data
$this->id = htmlspecialchars(strip_tags($this->id));
$this->quote = htmlspecialchars(strip_tags($this->quote));
$this->author_id = htmlspecialchars(strip_tags($this->author_id));
$this->category_id = htmlspecialchars(strip_tags($this->category_id));



// Bind data
$stmt->bindParam(':quote', $this->quote);
$stmt->bindParam(':author_id', $this->author_id);
$stmt->bindParam(':category_id', $this->category_id);
$stmt->bindParam(':id', $this->id);

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
