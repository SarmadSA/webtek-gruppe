<?php
require_once 'config.php';

// Connect to server and select databse.
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
//$mysqli->real_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
$mysqli->real_connect('localhost', 'root', '', 'webtek');
//Check for submittion.
if (filter_input(INPUT_POST, 'email', FILTER_DEFAULT) !== null) {
    $email = $mysqli->real_escape_string(filter_input(INPUT_POST, 'username', FILTER_DEFAULT));
    $password = $mysqli->real_escape_string(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));

//Remove all spaces at the right and the left of the input.
    $email = ltrim($email);
    $email = rtrim($email);
    $password = ltrim($password);
    $password = rtrim($password);

    $query = "SELECT * FROM members WHERE username = '$email' AND password = password('$password')";
    $mysqli_result = $mysqli->query($query);


// Mysql_num_row is counting table row
    $count = $mysqli_result->num_rows;


// If result matched $username and $password, table row must be 1 row
    if ($count == 1) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $email;
        header('Location: uploadPost.php');
    } else {
        $message = "Username and/or Password incorrect.\\nTry again.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        echo '<script>window.location="../webtek/login.php"</script>';
    }
}
$mysqli->close();