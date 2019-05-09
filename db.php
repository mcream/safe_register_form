<?php 

// Data to connect with database
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'formphp';

// Executing connect to database
$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (mysqli_connect_errno()) {
	// Display error info, when there is an error in the connection.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

?>