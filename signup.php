<?php
$email = "";
$password = "";
$rePassword = "";

//Check for submittion.
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['repassword'];

    //Remove all spaces at the right and the left of the input.
    $email = ltrim($email);
    $email = rtrim($email);
    $password = ltrim($password);
    $password = rtrim($password);
    $rePassword = ltrim($rePassword);
    $rePassword = rtrim($rePassword);
}

function agreedToTermsOfUse(){
	$agreedToTermsOfUse = false;
	if(isset($_POST['checkbox'])){
		$agreedToTermsOfUse = true;
	}
	return $agreedToTermsOfUse;
}


/**
*Retun true if the submitted email is valid, false otherwise.
*
*@param $submittedEmail the email the user submits
*@return return where the submitted email is valid or not
*/
function isValidEmail($submittedEmail) {
    $isValid = false;
    if ((strlen($submittedEmail) > 0) && filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        $isValid = true;
    }
    return $isValid;
}

function isValidPassword($submittedPassword) {
    $isValid = false;
    if ((strlen($submittedPassword) >= 6)) {
        $isValid = true;
    }
    return $isValid;
}

function isSamePassword($submittedPassword, $submittedRePassword){
    $isSame = false;
    if($submittedPassword == $submittedRePassword){
        $isSame = true;
    }
    return $isSame;
}

function printEmailError($submittedEmail) {
    $errorMessage = "";
    if (isset($_POST['submit']) && (strlen($submittedEmail) < 1)) {
        $errorMessage = "Please enter your Email!";
    } else if (isset($_POST['submit']) && !filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Ivalid Email! Please enter your real Email!";
    }
    echo $errorMessage;
}

function printPasswordError($submittedPassword, $submittedrePassword) {
    $errorMessage = "";
    if (isset($_POST['submit']) && (strlen($submittedPassword) < 1)) {
        $errorMessage = "Please enter a password!";
    } else if (isset($_POST['submit']) && ((strlen($submittedPassword) < 6) && (strlen($submittedPassword) > 0))) {
        $errorMessage = "Password must be atleast 6 characters";
    }
    else if(isset($_POST['submit']) && !isSamePassword($submittedPassword, $submittedrePassword)){
      $errorMessage = "Passwords does not match";
    }
    echo $errorMessage;
}

function printagreementError(){
	$errorMessage = "";
	if(isset($_POST['submit']) && !agreedToTermsOfUse()){
		$errorMessage = "You must agree to the terms of use";
	}
	echo $errorMessage;
}

function printSubmittionMessage($submittedEmail, $submittedPassword, $submittedRePassword) {
    $submittionMessage = "";
    if (isset($_POST['submit']) && isValidEmail($submittedEmail) && isValidPassword($submittedPassword) && isSamePassword($submittedPassword, $submittedRePassword) && agreedToTermsOfUse()) {
        $submittionMessage = "<p>Successfully registered!</p>" . "<p>Your login username is: " . $submittedEmail . "</p>" . "<br><br>";
    } else if ((isset($_POST['submit'])) && (!isValidEmail($submittedEmail) || !isValidPassword($submittedPassword) || !isSamePassword($submittedPassword, $submittedRePassword) || !agreedToTermsOfUse())) {
        $submittionMessage = "<p>Faild to submit message, please try again!</p><br><br>";
    }
    echo $submittionMessage;
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
            <span class="error-message"> * <?php printEmailError($email)?> </span>
            <br>
            <label for="subject">Password:</label>
            <br>
            <input type="password" name="password" id="subject" placeholder="Enter the subject.."> 
            <span class="error-message"> * <?php printPasswordError($password, $rePassword) ?> </span>
            <br>
            <label for="subject">Retype password:</label>
            <br>
            <input type="password" name="repassword" id="subject" placeholder="Enter the subject.."> 
            <span class="error-message"> * <?php printPasswordError($password, $rePassword) ?> </span>
            <br>
			<br>
			<label for="checkbox">I agree to the <a href="https://www.google.no/" target="_blank">terms of use</a></label>
			<input type="checkbox" id="checkbox" name="checkbox">
			<span class="error-message">  <?php printagreementError() ?> </span>
			<br>
			<br>
            <input type="submit" name="submit" value="Registrer">
        </form>
        <br class="clear"/>

        <!--Footer-->
    </body>
</html>
