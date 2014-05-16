<?php
session_start();

require 'database.php';

$story_id = (int)$_GET['id'];
$comment = $_POST['comment'];
$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("insert into comments (comment, story_id, user_id) values(?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sii', $comment, $story_id, $user_id);
 
$stmt->execute();
 
$stmt->close();

header("Location: viewStories.php");


?>