<?php
// This is a *good* example of how you can implement password-based user authentication in your web application.
 
require 'database.php';

$username = $_POST["user"];
$pass = $_POST['password'];

$hashed_pass = crypt($pass);


// Connect to the database

$stmt = $mysqli->prepare("insert into users (username, encrypted_password) values(?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
// save to database
$stmt->bind_param('ss', $username, $hashed_pass);
 
$stmt->execute();
 
$stmt->close();

header("Location: start.php");

?>