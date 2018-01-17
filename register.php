<?php
include_once 'int/reg.process.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Marton Intl.</title>
    </head>
    <body>
        <h1>Register with us</h1>
         <form action="int/reg.process.php" method="post">
            First Name: <br><input type="text" name="firstname" required><?php echo $firstname_err;?><br><br>
            Last Name: <br><input type="text" name="lastname" required><?php echo $lastname_err;?><br><br>
            E-mail: <br><input type="email" name="email" required><?php echo $email_err;?><br><br>
            Password: <br><input type="password" name="password" required><?php echo $password_err;?><br><br>
            <input type="submit" name="submit" value=" Register ">
            <?php
                if (!empty($error_msg)) {
                echo $error_msg;
                }
            ?>  
        </form>
        <p><a href="index.php">Go back to login page</a>.</p>
    </body>
</html>