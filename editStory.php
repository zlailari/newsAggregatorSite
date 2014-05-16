
<!DOCTYPE html>
<?php session_start();
$user_id = $_SESSION['user_id'];
$story_id = (int)$_GET['id'];
?>
<html>
<head>
    <title>Stories</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mod2.css">  
</head>

<body>
<?php
//allows users to edit stories, to delete, empty text field
require 'database.php';
$stmt = $mysqli->prepare("select content, user_id from stories where story_id=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $story_id); 
$stmt->execute();

$result = $stmt->get_result();

echo "<div id='main'>";
$row = $result->fetch_assoc();

$story = $row["content"];
echo "To delete a story, update with no text. <br/>";
echo "<form action='updateStory.php?id=".$story_id."' method = 'post'> <input type='text' value='".$story."' name='updated_story'/> <input type='submit' value='edit'/> </form>";

$stmt->close();


?>

</body>
</html>

