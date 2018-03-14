<?php
require_once 'config.php';

//connect to database
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
$tbl_name = "members";

//Error & succes messages
$emptyEmailErr = "Vennligst skriv din epost!";
$emailFormatErr = "Ugyldig epost format! Venligst skriv en virkelig epost!";
$emptyPasswordErr = "Vennligst skriv et passord!";
$shortPasswordErr = "Passordet må være minst 6 tegn.";
$disMatchPasswordErr = "Passordene er ikke like.";
$agreementErr = "Du må akseptere vilkårene.";
$userExistsErr = "Brukeren eksisterer allerede.";
$faildRegistrarionErr = "Registrering mislyktes, Vennligst prøv igjen!";
$succesRegistrarion_p1 = "Registrering vellykket!";
$succesRegistrarion_p2 = "Ditt brukernavn er: ";

$submitted = false;
$email = $password = $rePassword = "";

//Check for submittion.
if (isset($_POST['submit'])) {
	$submitted = true;
	
    $email = $mysqli->real_escape_string(filter_input(INPUT_POST, 'email', FILTER_DEFAULT));
    $password = $mysqli->real_escape_string(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));
    $rePassword = $mysqli->real_escape_string(filter_input(INPUT_POST, 'repassword', FILTER_DEFAULT));

    //Remove all spaces at the right and the left of the input.
    $email = ltrim($email);
    $email = rtrim($email);
	
	//Skal det være mulig å starte eller slutte passordet med "space"? da fjerner du koden nederst.
    $password = ltrim($password);
    $password = rtrim($password);
    $rePassword = ltrim($rePassword);
    $rePassword = rtrim($rePassword);
}

function userExists(){
	global $tbl_name;
	global $mysqli;
	$exists = true;
	$check = "SELECT * FROM $tbl_name  WHERE username = '$_POST[email]'";
	$rs = mysqli_query($mysqli,$check);
	$data = mysqli_fetch_array($rs, MYSQLI_NUM);
	if($data[0]  == 0) {
    	$exists = false;
	}
	return $exists; 
} 

function saveToDatabase($submittedPassword, $submittedEmail, $database){
	global $tbl_name;
	//$submittedPassword = password("$submittedPassword"); // burk PASSWORD()
	$sql = "INSERT INTO $tbl_name (username, password) VALUES ('$submittedEmail',password('$submittedPassword'))";
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
        echo "<p class=\"error-message\">" . $emptyEmailErr . "</p>";
    } 
	else if ($submitted && !filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<p class=\"error-message\">" . $emailFormatErr . "</p>";
    }
}

function printPasswordError($submittedPassword, $submittedrePassword) {
	global $submitted;
	global $emptyPasswordErr;
	global $shortPasswordErr;
	global $disMatchPasswordErr;
		
    if ($submitted && (strlen($submittedPassword) < 1)) {
        echo "<p class=\"error-message\">" . $emptyPasswordErr . "</p>";
    } 
	else if ($submitted && ((strlen($submittedPassword) < 6) && (strlen($submittedPassword) > 0))) {
        echo "<p class=\"error-message\">" . $shortPasswordErr . "</p>";
    }
    else if($submitted && !isSamePassword($submittedPassword, $submittedrePassword)){
      echo "<p class=\"error-message\">" . $disMatchPasswordErr . "</p>";
    }
}

function printagreementError(){
	global $submitted;
	global $agreementErr;
	if($submitted && !agreedToTermsOfUse()){
		echo "<p class=\"error-message\">" . $agreementErr . "</p><br>";
	}
}

function printSubmittionMessage($submittedEmail, $submittedPassword, $submittedRePassword) {
	global $submitted; 
	global $succesRegistrarion_p1; 
	global $succesRegistrarion_p2; 
	global $faildRegistrarionErr;
	global $userExistsErr;
	global $mysqli;
	
    if ($submitted && isValidForm($submittedEmail,$submittedPassword,$submittedRePassword) && !userExists()) {
        saveToDatabase($submittedPassword, $submittedEmail, $mysqli);
		echo "<p class=\"success-message\">" . $succesRegistrarion_p1 . "<br>" . $succesRegistrarion_p2 . $submittedEmail . "</p>";
    }
	else if($submitted && userExists()){
		echo "<p class=\"error-message\">" . $userExistsErr . "</p>";
	}
}
include 'templates/header_template.php';
?>

        <!--header-->
		<section class="registration-form">
			<h2 class="headinhg">Registrer</h2>
			<form action="signup.php" method="post">
				<!--Prints a message when submitting, telleing the user whether the submittion was succsessfull or faild-->
				<?php 
					printSubmittionMessage($email,$password,$rePassword);
					printEmailError($email);
					printPasswordError($password, $rePassword);
					printagreementError();
				?>
				<label for="email">Epost:</label>
				<input type="text" name="email" id="email" placeholder="Din epost.." class="form-input input-placeholder focus-style" value="<?php if($submitted && !isValidForm($email,$password,$rePassword)){echo $email;}?>">
				
	
				<label for="subject">Passord:</label>
				<input type="password" name="password" id="subject" placeholder="Skriv et passord.." class="form-input input-placeholder focus-style"> 
				

				<label for="subject">Skriv passordet på nytt:</label>
				<input type="password" name="repassword" id="subject" placeholder="Skriv et passord.." class="form-input input-placeholder focus-style"> 
				

				<label for="checkbox">Jeg aksepterer <a href="https://www.google.no/" target="_blank">vilkårene for bruk</a></label>
				<input type="checkbox" id="checkbox" name="checkbox" <?php if($submitted && !isValidForm($email,$password,$rePassword) && agreedToTermsOfUse()){echo "checked=checked";}?>>
				
				<br>
				<br>
				
				<input type="submit" name="submit" value="Registrer" class="submit-button focus-style">
			</form>
		</section>
        <br class="clear"/>

        <!--Footer-->
    </body>
</html>
