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
// 
if($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')){
// s = string, i = int, b = blob | Password will be hashed by password_hash   
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        //Username exist
        echo 'Username is already used. Choose another one.';
    }else{
        if($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
                echo 'You account has added! Congratulation!';
        }else{
            echo 'Could not prepare statement';
        }
    }
    $stmt->close();
}else{
    //Couldn't add new account. Propably is an error in sql staement.
    echo 'Could not prepare statement';
}
if($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')){
    // Email validation.
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        die ('Email is not valid!');
    }
    // checking correct cases
    if(preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0){
        die('Username is not valid');
    }
    // checking length password
    if(strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5){
        die ('You password should be between 5 and 20.');
    }
}




?>