<!DOCTYPE html>
<html>
    <head>
        <title>Marton Intl.</title>
    </head>
    <body>
        <h1>Marton Intl.</h1>
		<h2>Login Form</h2>
        
		<form action="int/login.process.php" method="post">                      
            Email: <input type="text" name="email" />
            Password: <input type="password" name="password" id="password"/>
            <input type="submit" value=" Login " name="submit" />
            <p><a href="guestprofile.php">Continue as guest</a></p>
            <p><a href="register.php"> Register </a></p>
            <?php
                if (isset($_GET['error'])) {
                echo '<p>Error: Login Failed</p>';
            }
            ?>
            </form>      
    </body>
</html>