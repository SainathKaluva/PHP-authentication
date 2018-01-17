<?php
$error = filter_input(INPUT_GET, 'error', $filter = FILTER_SANITIZE_STRING); //Sanitize input string
 
if (! $error) {
    $error = 'Oops! An unknown error happened.';
}
?>
<!DOCTYPE html>
<html>
    <body>
        <h1>There was a problem</h1>
        <p><?php echo $error; ?></p>  
    </body>
</html>