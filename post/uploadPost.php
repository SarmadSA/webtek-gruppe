<?php
session_start();
require_once('../logintest.php');
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
        <div class="row container-fluid text-light container">
            <div class="col-lg">
                <h1>Add new post</h1>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    Select image to upload: (max size 1Mb)<br>
                    <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
                    Set name:<br>
                    <textarea maxlength="45" name="heading" cols="30" rows="2"></textarea><br><br>
                    <input class="button btn btn-success" type="submit" value="Post" name="submit">
                </form>
            </div>
        </div>
        <div class="row col-sm container-fluid">
            <aside>
                <a class="nav-link btn btn-info" href="index">Back</a>
            </aside>
        </div>
    </body>
</html>