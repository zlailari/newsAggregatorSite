<?php
session_start();

require 'database.php';

if($_SESSION['token'] !== $_POST['token'])
{
    die("CSRF detected!!");
}

$story = $_POST['story'];
$title = $_POST['title'];
$user_id = (int)$_SESSION['user_id'];

$mode = $_GET['mode'];



$stmt = $mysqli->prepare("insert into stories (title, content, type, user_id) values(?,?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
// three types of posts: t-> text, u-> url, y-> youtube    
if ($mode == 'url')
{
    $type = 'u';
}
else if ($mode == 'text')
{
    $type = 't';
}
else if ($mode == 'youtube')
{
    $type = 'y';
    preg_match(
        '/[\\?\\&]v=([^\\?\\&]+)/',
        $story,
        $matches
    );
    $story = $matches[1];
    // $matches[1] should contain the youtube id
}
else{ $type = 't';}

$stmt->bind_param('sssi', $title, $story, $type, $user_id);
 
$stmt->execute();
 
$stmt->close();

header("Location: viewStories.php");

?>
