<?php
class Database{
  //DB Params
  private $host = 'localhost';
  private $db_name = 'myblog';
  private $username = 'root';
  private $password = 'root';
  private $conn;
  //DB Conncetion
  public function connect(){
    $this->conn = null;
    try{
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOexception $e){
      echo 'Connection Error: ' . $e->getMessage();
    }
    return $this->conn;
  }




}


?>
