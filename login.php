<?php
$email = "";
$password = "";

//Check for submittion.
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Remove all spaces at the right and the left of the input.
    $email = ltrim($email);
    $email = rtrim($email);
    $password = ltrim($password);
    $password = rtrim($password);
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>

    <body>
        <!--header-->


        <form action="signup.php" method="post">
            <!--Prints a message when submitting, telleing the user whether the submittion was succsessfull or faild-->
             <?php printSubmittionMessage($email,$password,$rePassword);?>
            <label for="email">E-mail:</label>
            <br>
            <input type="text" name="email" id="email" placeholder="Your email..">
            <span class="error-message"> <?php printEmailError($email)?> </span>
            <br>
            <label for="subject">Password:</label>
            <br>
            <input type="password" name="repassword" id="subject" placeholder="Enter the subject.."> 
            <span class="error-message"> <?php printPasswordError($password, $rePassword) ?> </span>
            <br>
            <br>
            <input type="submit" name="submit" value="logg inn">
        </form>
        <br class="clear"/>

        <!--Footer-->
    </body>
</html>
