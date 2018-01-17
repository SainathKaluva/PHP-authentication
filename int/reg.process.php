<?php
include_once 'config.php'; //For Database connection

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
}