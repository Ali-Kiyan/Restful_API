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



    // Get Single Post
    public function read_single(){
      //Create Query
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
               WHERE p.id = ?
               LIMIT 0,1';
      //Prepare statement
      $stmt = $this->conn->prepare($query);
      //Bind ID
      // PDO has positional and named parameters
      $stmt->bindParam(1, $this->id);
      //Execute Query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set Properties
      $this->title = $row['title'];
      $this->body = $row['body'];
      $this->author = $row['author'];
      $this->category_id = $row['category_id'];
      $this->category_id = $row['category_id'];
      $this->category_name = $row['category_name'];


    }

    //Create Post
    public function create(){
      // Create Query
      // Using name parameters
      $query  = 'INSERT INTO '. $this->table . '
      SET
         title = :title,
         body = :body,
         author = :author,
         category_id = :category_id';
      // Prepate statement
      $stmt = $this->conn->prepare($query);
      //Clean Data (security measures)
      $this->title  = htmlspecialchars(strip_tags($this->title));
      $this->body  = htmlspecialchars(strip_tags($this->body));
      $this->author  = htmlspecialchars(strip_tags($this->author));
      $this->category_id  = htmlspecialchars(strip_tags($this->category_id));

      // Binding data
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);

      // Execute Query
      if($stmt->execute()){
        return true;
      }
      // print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }

    //Update Post
    public function update(){
      // Update Query
      // Using name parameters
      $query  = 'UPDATE '. $this->table . '
      SET
         title = :title,
         body = :body,
         author = :author,
         category_id = :category_id
      WHERE id = :id';
      // Prepate statement
      $stmt = $this->conn->prepare($query);
      //Clean Data (security measures)
      $stmt->title  = htmlspecialchars(strip_tags($this->title));
      $stmt->body  = htmlspecialchars(strip_tags($this->body));
      $stmt->author  = htmlspecialchars(strip_tags($this->author));
      $stmt->category_id  = htmlspecialchars(strip_tags($this->category_id));
      $stmt->id  = htmlspecialchars(strip_tags($this->id));

      // Binding data
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':id', $this->id);

      // Execute Query
      if($stmt->execute()){
        return       $stmt;
      }
      // print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }
    // Delete Post
    public function delete(){
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

      //Prepare statement

      $stmt = $this->conn->prepare($query);
      // Clean the data

      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind the data

      $stmt->bindParam(':id', $this->id);

      // Execute Query
      if($stmt->execute()){
        return true;
      }
      // print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }




}

?>
