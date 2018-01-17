<?php
include_once 'config.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: ../profile.php');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // If wrong POST variables are received.
   header('Location: ../error.php?error=invalid login request')
}

function login($email, $password, $mysqli) {
    if($stmt = $mysqli->prepare("SELECT acc_id, email, password FROM accounts WHERE email = ?")) {
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($acc_id, $email, $db_password);
        $stmt->fetch();

        if($stmt->num_rows == 1) {
            if(bruteforce_check($acc_id, $mysqli) == true) { //Chekcing for bruteforce trials
                return false; //No for logging in
            } else {
                if(password_verify($password, $db_password)) { //This function verifies the password hashes.
                    return true; //Ok for logging in
                } else {
                    $now = time(); //Recording the time of brute force attempt.
                    $mysqli->query("INSERT INTO login_trials(acc_id, time) VALUES ('$acc_id','$now')"); //Storing the trials in DB 
                    return false; //No for logging in
                }
            }
        }else {
            return false; //No for logging in
        }
    }
}

function bruteforce_check($acc_id, $mysqli) {
    $now = time();
    $valid_trials = $now - (1*60*60); //Valid number of trials in one hour.
    if($stmt = $mysqli->prepare("SELECT time FROM login_trials WHERE acc_id=? AND time > '$valid_trials'")) {
        $stmt->bind_param('i',$acc_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 5) {  //If the trials are more than 5, then the account is temporarily blocked.
            return true; 
        } else {
            return false;
        }
    }
}