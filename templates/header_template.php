<?php

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['loggedin']) && ($_SESSION['loggedin'] == true)) {
    $uname = $_SESSION['email'];
    echo '<!DOCTYPE html>
<html lang="no">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/registrationStyle.css">
        <title>NTNUIRL</title>
        <script src="js/jquery-1.11.1.min.js" ></script>
    </head>
    <body>
        <header class="header">
            <section class="brand">
                <a href="/">
                  <!-- <img src="img/placeholder100x100.png" alt="placeholder"> -->
                    <h2 >Brandname</h2>
                </a>
            </section>

            <nav class="mainNav">
                <ul>
                    <li class="hoverNav"><p>Good day ' . $uname . '</li>
                    <li class="hoverNav"><a href="/logout.php">Log Out</a></li>
                </ul>
            </nav>
        </header>
        <aside class="aside">
            <nav>
                <ul>
                    <li class="hoverNav"><a href="upload.php">Upload</a></li>
                    <li class="hoverNav"><a href="about.php">About</a></li>
                    <li class="hoverNav"><a href="rules.php">Rules</a></li>
                    <li class="hoverNav"><a href="termofservice.php">Terms of Service</a></li>
                </ul>
            </nav>
        </aside>';
} else {
    echo '<!DOCTYPE html>
<html lang="no">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/registrationStyle.css">
        <title>NTNUIRL</title>
        <script src="js/jquery-1.11.1.min.js" ></script>
    </head>
    <body>
        <header class="header">
            <section class="brand">
                <a href="/">
                  <!-- <img src="img/placeholder100x100.png" alt="placeholder"> -->
                    <h2 >Brandname</h2>
                </a>
            </section>

            <nav class="mainNav">
                <ul>
                    <li class="hoverNav"><a href="login.php">Log in</a></li>
                    <li class="hoverNav"><a href="signup.php">Sign up</a></li>
                </ul>
            </nav>
        </header>
        <aside class="aside">
            <nav>
                <ul>
                    <li class="hoverNav"><a href="upload.php">Upload</a></li>
                    <li class="hoverNav"><a href="about.php">About</a></li>
                    <li class="hoverNav"><a href="rules.php">Rules</a></li>
                    <li class="hoverNav"><a href="termofservice.php">Terms of Service</a></li>
                </ul>
            </nav>
        </aside>';
}