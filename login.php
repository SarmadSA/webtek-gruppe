<?php
require_once 'config.php';

$tbl_name = "members"; // Table name 

// Connect to server and select databse.
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

//Check for submittion.
if (filter_input(INPUT_POST, 'email', FILTER_DEFAULT) !== null) {
    $email = $mysqli->real_escape_string(filter_input(INPUT_POST, 'email', FILTER_DEFAULT));
    $password = $mysqli->real_escape_string(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));

//Remove all spaces at the right and the left of the input.
    $email = ltrim($email);
    $email = rtrim($email);
    $password = ltrim($password);
    $password = rtrim($password);
    
    echo "<script type='text/javascript'>alert('$email');</script>";
        

    $query = "SELECT * FROM $tbl_name WHERE username = '$email' AND password = password('$password')";
    $mysqli_result = $mysqli->query($query);

// Mysql_num_row is counting table row
    $count = $mysqli_result->num_rows;


// If result matched $username and $password, table row must be 1 row
    if ($count == 1) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header('Location: /webtek/post/uploadPost.php');
    } else {
        $message = "Username and/or Password incorrect.\\nTry again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo '<script>window.location="../webtek/login.php"</script>';
    }
}
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="no">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css">
    <title>Welcome</title>
  </head>
  <body>
    <header class="header">
        <section class="brand">
          <a href="????">
            <!-- <img src="img/placeholder100x100.png" alt="placeholder"> -->
            <h2 >Brandname</h2>
          </a>
        </section>
        <nav class="mainNav">
          <ul>
            <li class="hoverNav"><a href="???">Log in</a></li>
            <li class="hoverNav"><a href="???">Sign up</a></li>
          </ul>
        </nav>
    </header>
     <aside class="aside">
       <nav>
         <ul>
           <li class="hoverNav"><a href="???">About</a></li>
           <li class="hoverNav"><a href="???">Contact</a></li>
           <li class="hoverNav"><a href="???">Rules</a></li>
           <li class="hoverNav"><a href="???">Help</a></li>
           <li class="hoverNav"><a href="???">Terms of Service</a></li>
         </ul>
       </nav>
     </aside>


        <form action="login.php" method="post">
            <!--Prints a message when submitting, telleing the user whether the submittion was succsessfull or faild-->
            <?php /* printSubmittionMessage($email,$password,$rePassword); */ ?>
            <label for="email">E-mail:</label>
            <br>
            <input type="text" name="email" id="email" placeholder="Your email..">
            <span class="error-message"> <?php /* printEmailError($email) */ ?> </span>
            <br>
            <label for="subject">Password:</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Enter the subject.."> 
            <span class="error-message"> <?php /* printPasswordError($password, $rePassword) */ ?> </span>
            <br>
            <br>
            <input type="submit" name="submit" value="logg inn">
        </form>
        <br class="clear"/>

        <!--Footer-->
    </body>
</html>
