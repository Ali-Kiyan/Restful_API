<?php
class Post{
  // DB
  private $conn;
  private $table = 'posts';
  //post properties
  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  // Constructor with DB

  public function __construct($db){
    $this->conn = $db;

  }
   // get posts
   public function read(){
    //CREATE QUERY
    $query = 'SELECT
             c.name AS category_name,
             p.id,
             p.category_id,
             p.title,
             p.body,
             p.author,
             p.created_at
            FROM
            ' . $this->table . ' p
            LEFT JOIN
            categories c ON p.category_id = c.id
            ORDER BY p.created_at DESC';
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query

    $stmt->execute();

    return $stmt;
    }
}

?>
