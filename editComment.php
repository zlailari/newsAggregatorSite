
<!DOCTYPE html>
<?php session_start();
$user_id = $_SESSION['user_id'];
$comment_id = $_GET['id'];
?>
<html>
<head>
    <title>Edit Comment</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mod2.css">  
</head>

<body>
<?php

//allows users to edit their comments, to delete, empty text field
require 'database.php';

$stmt = $mysqli->prepare("select comment, user_id from comments where comment_id=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $comment_id); 
$stmt->execute();

$result = $stmt->get_result();

echo "<div id='main'>";
$row = $result->fetch_assoc();

$comment = $row["comment"];

echo "To delete a story, update with no text. <br/>";
echo "<form action='updateComment.php?id=".$comment_id."' method = 'post'> <input type='text' value='".$comment."' name='updated_comment'/> <input type='submit' value='edit'/> </form>";


$stmt->close();


?>

</body>
</html>

