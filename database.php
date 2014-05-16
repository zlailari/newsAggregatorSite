<?php
$mysqli = new mysqli('localhost', 'newsadmin', 'cse330', 'NEWS');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>