<?php 

// Data to connect with database
$db_host = 'localhost'; //Host name (e.g - 127.0.0.1)
$db_user = 'root'; // Username of database
$db_password = ''; //Password of database
$db_name = 'formphp'; // Database name

// Executing connect to database
$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (mysqli_connect_errno()) {
	// Display error info, when there is an error in the connection.
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

?>