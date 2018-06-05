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

// Get the id from the URL

$post->id = isset($_GET['id']) ? $_GET['id'] : die();
// GET post
$post->read_single();
//Create array
$post_arr = array(
  'id' => $post->id,
  'title' => $post->title,
  'body' => $post->body,
  'author' => $post->author,
  'category_id' => $post->category_id,
  'category_name' => $post->category_name
);

// Generate JSON
print_r(json_encode($post_arr));
?>
