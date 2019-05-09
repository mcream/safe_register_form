<?php
// D A T A B A S E - C O N N E C T 

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

// V A L I D A T I O N

// Checking exist data.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// When all entered data exist, an error will appear.
	die ('Please complete the registration form!');
}
// Checking empty inputs
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	die ('Please complete the registration form');
}

?>