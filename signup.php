<?php

//CHECK IF USER IS ALREADY REGISTERED BEFORE SENDING TO DATABASE.

//connect to database
$db = mysqli_connect('localhost', 'root', '', 'registration');

//Error & succes messages
$emptyEmailErr = "Vennligst skriv din epost!";
$emailFormatErr = "Ugyldig epost format! Venligst skriv en virkelig epost!";
$emptyPasswordErr = "Vennligst skriv et passord!";
$shortPasswordErr = "Passordet må være minst 6 tegn.";
$disMatchPasswordErr = "Passordene er ikke like.";
$agreementErr = "Du må akseptere vilkårene.";
$faildRegistrarionErr = "Registrering mislyktes, Vennligst prøv igjen!";
$succesRegistrarionErr_p1 = "Registrering vellykket!";
$succesRegistrarionErr_p2 = "Ditt innloggins brukernavn er: ";


$submitted = false;
$email = $password = $rePassword = "";

//Check for submittion.
if (isset($_POST['submit'])) {
	$submitted = true;
	
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePassword = $_POST['repassword'];

    //Remove all spaces at the right and the left of the input.
    $email = ltrim($email);
    $email = rtrim($email);
	
	//Skal det være mulig å starte eller slutte passordet med "space"? da fjerner du koden nederst.
    $password = ltrim($password);
    $password = rtrim($password);
    $rePassword = ltrim($rePassword);
    $rePassword = rtrim($rePassword);
	
	//Save to database if the form is valid.
	if(isValidForm($email,$password,$rePassword)){
		saveToDatabase($password, $email, $db);
	}
	
}

function saveToDatabase($submittedPassword, $submittedEmail, $database){
	$submittedPassword = md5($submittedPassword);
	$sql = "INSERT INTO users(email, password) VALUES ('$submittedEmail','$submittedPassword')";
	mysqli_query($database, $sql);	
}

function isValidForm($submittedEmail,$submittedPassword,$submittedRePassword){
	$isValid = false;
	if(isValidEmail($submittedEmail) && isValidPassword($submittedPassword) && isSamePassword($submittedPassword, $submittedRePassword) && agreedToTermsOfUse()){
		$isValid = true;
	}
	return $isValid;
}

function agreedToTermsOfUse(){
	$agreedToTermsOfUse = false;
	if(isset($_POST['checkbox'])){
		$agreedToTermsOfUse = true;
	}
	return $agreedToTermsOfUse;
}

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
	global $submitted;	
	global $emptyEmailErr;	
	global $emailFormatErr;	
	
    if ($submitted && (strlen($submittedEmail) < 1)) {
        echo $emptyEmailErr;
    } 
	else if ($submitted && !filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        echo $emailFormatErr;
    }
}

function printPasswordError($submittedPassword, $submittedrePassword) {
	global $submitted;
	global $emptyPasswordErr;
	global $shortPasswordErr;
	global $disMatchPasswordErr;
		
    if ($submitted && (strlen($submittedPassword) < 1)) {
        echo $emptyPasswordErr;
    } 
	else if ($submitted && ((strlen($submittedPassword) < 6) && (strlen($submittedPassword) > 0))) {
        echo $shortPasswordErr;
    }
    else if($submitted && !isSamePassword($submittedPassword, $submittedrePassword)){
      echo $disMatchPasswordErr;
    }
}

function printagreementError(){
	global $submitted;
	global $agreementErr;
	if($submitted && !agreedToTermsOfUse()){
		echo $agreementErr;
	}
}

function printSubmittionMessage($submittedEmail, $submittedPassword, $submittedRePassword) {
	global $submitted; 
	global $succesRegistrarionErr_p1; 
	global $succesRegistrarionErr_p2; 
	global $faildRegistrarionErr;
	
    if ($submitted && isValidForm($submittedEmail,$submittedPassword,$submittedRePassword)) {
        echo "<p>" . $succesRegistrarionErr_p1 . "<br>" . $succesRegistrarionErr_p2 . $submittedEmail . "</p>" . "<br><br>";
    } 
	else if ($submitted && !isValidForm($submittedEmail,$submittedPassword,$submittedRePassword)) {
        echo "<p>" . $faildRegistrarionErr . "</p><br><br>";
    }
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
            <label for="email">Epost:</label>
            <br>
            <input type="text" name="email" id="email" placeholder="Din epost.." value="<?php if($submitted && !isValidForm($email,$password,$rePassword)){echo $email;}?>">
            <span class="error-message"> * <?php printEmailError($email)?> </span>
            <br>
            <label for="subject">Passord:</label>
            <br>
            <input type="password" name="password" id="subject" placeholder="Skriv et passord.."> 
            <span class="error-message"> * <?php printPasswordError($password, $rePassword) ?> </span>
            <br>
            <label for="subject">Skriv passordet på nytt:</label>
            <br>
            <input type="password" name="repassword" id="subject" placeholder="Skriv et passord.."> 
            <span class="error-message"> * <?php printPasswordError($password, $rePassword) ?> </span>
            <br>
			<br>
			<label for="checkbox">Jeg aksepterer <a href="https://www.google.no/" target="_blank">vilkårene for bruk</a></label>
			<input type="checkbox" id="checkbox" name="checkbox">
			<span class="error-message">  <?php printagreementError();?> </span>
			<br>
			<br>
            <input type="submit" name="submit" value="Registrer">
        </form>
        <br class="clear"/>

        <!--Footer-->
    </body>
</html>
