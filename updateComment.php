<?php
session_start();

require 'database.php';

$comment_id = (int)$_GET['id'];
$comment = $_POST['updated_comment'];
$user_id = $_SESSION['user_id'];

//sets new comment content to the db. if nothing submitted, delete the comment with corresponding id
if($comment=="")
{
	$stmt = $mysqli->prepare("delete from comments where comment_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $comment_id);
	$stmt->execute();
	$stmt->close();
	
}
else
{
	$stmt = $mysqli->prepare("update comments set comment=? where comment_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('si', $comment, $comment_id); 
	$stmt->execute();
	$stmt->close();	
}

header("Location: viewStories.php");


?>
