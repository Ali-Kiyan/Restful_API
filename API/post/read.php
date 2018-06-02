<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instatiate DB & connect

$database = new Database();
$db = $database->connect();

//Instatiate blog post object
//dependecy injection
$post = new Post($db);
$result = $post->read();
//Get Row Count
$num = $result->rowCount();
//Check if any posts
if($num>0){
  //Post array
  $post_arr = array();
  $posts_arr['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    $post_item = array(
      'id' => $id,
      'title' => $title,
      'body' => html_entity_decode($body),
      'author' => $author,
      'category_id' => $category_id,
      'category_name' => $category_name
    );
    // Push to "data"
    array_push($posts_arr['data'], $post_item);
  }
    //Turn to JSON & output
    echo json_encode($posts_arr);
} else{
  // No Posts
  echo json_encode(
    array('message' => 'No Posts Found')
  );
}


?>
