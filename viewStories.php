
<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['user_id']))
{
    $username = $_SESSION['username'];
    $user_id = (int)$_SESSION['user_id'];
}
else
{
    $username = 'guest';
    $user_id = -1;
}
?>
<html>
<head>
    <title>Stories</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mod2.css">  
</head>

<body>
    <h3> Sort stories: </h3> <br/>
<ul>
<li><a href="viewStories.php?sort=posted"> by date </a></li>
<li><a href="viewStories.php?sort=user_id"> by user </a></li>
<li><a href="viewStories.php?sort=story"> by stories </a></li>
</ul>

    
<?php
require 'database.php';

// identify sort type and assign to local variable
if(isset($_GET['sort']))
{
    $sort = $_GET['sort'];
}
else
{
    $sort = 'posted';
}
    
if($sort == 'posted') {
    $stmt = $mysqli->prepare("select story_id, title, type, content, user_id, users.username from stories join users on (users.id = stories.user_id) order by posted ASC");
}

else if($sort == 'user_id')
{
    $stmt = $mysqli->prepare("select story_id, title, type, content, user_id, users.username from stories join users on (users.id = stories.user_id) order by user_id ASC");
}

else if($sort == 'story')
{
    $stmt = $mysqli->prepare("select story_id, title, type, content, user_id, users.username from stories join users on (users.id = stories.user_id) order by content ASC");
}


if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();

$result = $stmt->get_result();
//displays all stories and comments
echo "<div id='main'>";
while($row = $result->fetch_assoc()){
// three types of posts: t-> text, u-> url, y-> youtube    
    if ($row['type'] == 't')
    {
	$title = $row['title'];
	$story_id = $row['story_id'];
	$link = "<a href='story.php?id=".$story_id."'>".$title."</a>";
    }
    else if ($row['type'] == 'u')
    {
	$title = $row['title'];
	$url = $row['content'];
	$link = "<a href='".$url."'>".$title."</a>";
    }
    
    else if ($row['type'] == 'y')
    {
	$youtube_id = $row['content'];
	$link = "<iframe width='560' height='315' src='http://www.youtube.com/embed/".$youtube_id."?rel=0' frameborder='0' allowfullscreen></iframe>";
    }
    
    echo $link;
    
    printf("\t<div>%s %s\n",
        " <em> by: </em>",
        htmlspecialchars( $row["username"])
    );
    $current_story_id = $row["story_id"];
    if(isset($_SESSION['user_id'])){
        echo "<a href = 'story.php?id=".$current_story_id."'> Comment </a>";    
    }
    if($row['user_id'] == $user_id)
    {
	$story_id = $row["story_id"];
	echo " or <a href='editStory.php?id=".$current_story_id."'> edit </a>";
    }
    echo "<br/>";
    echo "<strong> Comments: </strong> <ol>\n";
    $stmt2 = $mysqli->prepare("select comment_id, comment, user_id, users.username from comments join users on (users.id = comments.user_id and story_id = ?)");
    if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
    echo "<br/>";
    $stmt2->bind_param('i', $current_story_id);
    $stmt2->execute();
    $result2 = $stmt2 -> get_result();

    while($entry = $result2->fetch_assoc()){
        printf("%s %s %s\n",
        htmlspecialchars( $entry["comment"]),
        " by: ",
        htmlspecialchars( $entry["username"])   
        );
	echo "  ";
	if($entry['user_id'] == $user_id)
	{
	    $comment_id = $entry["comment_id"];
	    echo "<a href='editComment.php?id=".$comment_id."'> edit </a>";
	}
	echo "<br/>";
    }
    $stmt2 -> close();
    echo"</div><hr/>";
}
echo "</div>";

$stmt->close();

if(isset($_SESSION['user_id']))
{
    echo "<a href='home.php'> home </a>";
}
else
{
    echo "<a href='start.php'> Go to the start page and become a registered user! </a>";
}
?>

</body>
</html>