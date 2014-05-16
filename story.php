
<!DOCTYPE html>
<?php session_start();
$username = $_SESSION['username'];
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
// display the story and its comments
require 'database.php';

$stmt = $mysqli->prepare("select story_id, content, user_id, users.username from stories join users on (users.id = stories.user_id and story_id=?)");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $story_id); 
$stmt->execute();

$result = $stmt->get_result();

echo "<div id='main'>";
$row = $result->fetch_assoc();
printf("\t<div>%s %s %s\n",
        htmlspecialchars( $row["content"]),
        " <em> by: </em> ",
        htmlspecialchars( $row["username"]));

    echo "Comments: <ol>\n";
    $stmt2 = $mysqli->prepare("select comment_id, comment, user_id, users.username from comments join users on (users.id = comments.user_id and story_id = ?)");
    $current_story_id = $row['story_id'];
    $stmt2->bind_param('i', $current_story_id);
    $stmt2->execute();
    $result2 = $stmt2 -> get_result();
    while($entry = $result2->fetch_assoc()){
        printf("%s %s %s\n",
        htmlspecialchars( $entry["comment"]),
        "<em> by: </em> ",
        htmlspecialchars( $entry["username"])   
        );
	echo "<br/>";
    }
    $stmt2 -> close();
    echo"</div><hr/>";   
    if(isset($_SESSION['user_id'])){
        echo "<form action='addComment.php?id=".$story_id."' method='post'>
	<textarea cols='55' rows='10' name='comment'> </textarea>
	<input type='submit' value='comment'/>	
	</form>";    
    }	

echo "</div>";

$stmt->close();

echo "<a href='viewStories.php'> Back to Stories </a>";

?>

</body>

</html>
