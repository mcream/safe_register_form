<?php
// D A T A B A S E - C O N N E C T 

require_once('db.php');

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
        if($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activated) VALUES (?, ?, ?, ?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            // Id generator
            $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
            $stmt->execute();
                //Configuartion of PHP mail sender
               $from = 'localhost';
               $subject = 'Account activated';
               $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
               $activate_link = 'http://localhost/Application/Register/accept.php?email=' . $_POST['email'] . '&code=' . $uniqid;
                $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
                mail($_POST['email'], $subject, $message, $headers);
                echo 'Please check your email to activate your account!';
        
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