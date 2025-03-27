<?php
class Database{
    // DB params
    private $conn;
    private $host;
    private $dbname;
    private $username;
    private $password;
  

public function __construct(){
$this->username = getenv('USERNAME');
$this->password = getenv('PASSWORD');
$this->dbname = getenv('DBNAME');
$this->host = getenv('HOST');



}



    // DB Connect
    public function connect(){
       if ($this->conn){ 
        return $this->conn;
       }else{

        $dsn = "pgsql:host={$this->host}; dbname={$this->dbname};";

        try{
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        
        } catch(PDOException $e){
            echo 'Connection error:' . $e->getMessage();

            }
        }
}
}

        
        

