
<!DOCTYPE html>
<?php session_start();
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
?>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="mod2.css">  
</head>

<body>
    <h1> Welcome, you can:</h1> <br/> <hr/>
 <table> <tr>  
 <td><form action="viewStories.php" method="POST">
 <input type="submit" value="View Stories"/>
 </form></td>

 <!-- provides user with options for posting -->

 <td><form action="logout.php" method="POST">
 <input type="submit" value="Logout"/>
 </form></td>
 </tr>
 </table>
 OR Post Stories: <br/>
 <form action="postStory.php?mode=text" method="POST">
 Title: <input type="text" name="title"/> <br/>
 <textarea cols="55" rows= "10" name="story"> </textarea>
 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
 <input type="submit" value="Post Story"/>
 </form>
 <form action="postStory.php?mode=url" method="POST">
 Post with a link <br/> Title: <input type="text" name="title"/> <br/>
 <textarea cols="55" rows= "2" name="story"> </textarea>
 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
 <input type="submit" value="Post Story"/>
 </form>
  <form action="postStory.php?mode=youtube" method="POST">
 Post with a youtube video <br/> Title: <input type="text" name="title"/> <br/>
 <textarea cols="55" rows= "2" name="story"> </textarea>
 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
 <input type="submit" value="Post Story"/>
 </form>



</body>
</html>