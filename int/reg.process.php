<?php
include_once 'config.php'; //For Database connection
$error_msg = '';
$firstname_err = $lastname_err = $email_err = $password_err = '';
$firstname = $lastname = $email = $password = '';

//Register Form Validation
if(isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'])) { //Checks for values from HTTP post method.
	if (preg_match("/^[a-zA-Z ]*$/",$_POST['firstname'])) {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING); //Performing string sanitization before storing value.
    } else {
    	$firstname_err = "Only letters and white spaces are allowed";
    }
    if (preg_match("/^[a-zA-Z ]*$/", $_POST['lastname'])) {
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING); //Performing string sanitization before storing value.
    } else {
    	$lastname_err = "Only letters and white spaces are allowed"; 
    }
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); //Performing validation and sanitization before storing email.
    } else {
    	$email_err = "Invalid email format"; 
    }
    if (preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $_POST['password'])) {
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); //Performing string validation and sanitization before storing password.
    } else {
    	$password_err = "Password must be atleast 8 characters long. Password must contain atleast one lowercase, uppercase and a number.";
    }

    //Check if the email already exists in database
    $stmt = $mysqli->prepare("SELECT acc_id FROM accounts WHERE email =?");
    if($stmt) {
    	$stmt->bind_param('s', $email);
   	    $stmt->execute();
   	    $stmt->store_result();
   	    if($stmt->num_rows == 1) {
   		   $error_msg .= '<p>This Email is already registered</p>';
   		   $stmt->close();
        }
    } else {
    	$error_msg .= '<p> Error in Database </p>';
    	$stmt->close();
    }
    //Insert values into database
    if(empty($error_msg)) {
    	$password = password_hash($password, PASSWORD_BCRYPT); //Hashing Passwords
    	$stmt = $mysqli->prepare("INSERT INTO accounts (firstname, lastname, email, password)VALUES (?, ?, ?, ?)");
    	if ($stmt) {
            $stmt->bind_param('ssss', $firstname, $lastname, $email, $password);
            if (! $stmt->execute()) {
           	    $error_msg .= '<p>Failed to store input data</p>';
   	   	    }
	   }
       header('Location: ../reg.done.php');
    }
}

