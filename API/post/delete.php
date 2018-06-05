<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
//X-Requested-with for cross-site scripting attacks and it also has to do with cores
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instatiate DB & connect

$database = new Database();
$db = $database->connect();

//Instatiate blog post object
//dependecy injection
$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$post->id = $data->id;


// Update Post
if($post->delete()){
  echo json_encode(
      array(
        'message' => 'Post Deleted'
      )
    );
} else{
  echo json_encode(
      array(
        'message' => 'Post Not Deleted'
      )
    );
}
