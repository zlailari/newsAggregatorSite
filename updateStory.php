<?php
session_start();

require 'database.php';

$story_id = (int)$_GET['id'];
$story = $_POST['updated_story'];
$user_id = $_SESSION['user_id'];

//sets new story content to the db. if nothing submitted, delete the story with corresponding id

if($story=="")
{
	$stmt = $mysqli->prepare("delete from stories where story_id = ?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('i', $story_id);
	$stmt->execute();
	$stmt->close();
	
}
else
{
    $stmt = $mysqli->prepare("update stories set content=? where story_id=?");
    if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $story, $story_id); 
    $stmt->execute();
    $stmt->close();	
}

header("Location: viewStories.php");


?>
