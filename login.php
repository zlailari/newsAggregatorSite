<?php
// password-based user authentication in our web application.
session_start();
$user = $_POST['user'];
$pass = $_POST['password'];

require 'database.php';
 
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT id, encrypted_password FROM users WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $user);
$stmt->execute();
 
// Bind the results
$stmt->bind_result($user_id, $pwd_hash);
$stmt->fetch();


 // Compare the submitted password to the actual password hash
if(crypt($pass, $pwd_hash)==$pwd_hash){
	// Login succeeded!
	$_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
	$_SESSION['token'] = substr(md5(rand()), 0, 10);
        header("Location: home.php");
}
else{
        header("Location: start.php");
}

?>