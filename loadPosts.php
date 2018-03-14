<?php

if (isset($_POST["posts"])) {
    $click = $_POST["posts"];
} else {
    $click = 0;
}

if ((isset($_POST["sort"])) && ($_POST["sort"] !== "")) {
    //$curdate = date("Y/m/d", strtotime("-1 months"));
    //$sort = $_POST["sort"] + "AND upload_date BETWEEN ";
    $sort = $_POST["sort"];
} else {
    $sort = "upload_date";
}

require_once('config.php');
$link = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT * FROM `posts` ORDER BY $sort DESC LIMIT 5 OFFSET $click";


if ($result = mysqli_query($link, $query)) {
    if (mysqli_num_rows($result) > 0) {
        /* fetch associative array */
        while ($row = mysqli_fetch_assoc($result)) {
            $heading = $row['header'];
            $name = $row['author'];
            $img = $row['img'];
            $rate = $row['rating'];
            $comm = $row['comments'];
            $id = $row['id'];
            echo "<section class='postSection'><h2 class='heading'>$heading</h2>"
            . "<img class='img' src=post/$img >"
            . "<p class='author'>Uploaded by $name</p><nav class='postNav'><ul>"
            . "<li class='hoverNav'><p class='rating'>Rating: $rate</p></li>"
            . "<li class='hoverNav'><a href='post.php?id=$id' class='comments'>Comments: $comm</a></li></ul></nav></section>";
        }
        /* free result set */
        mysqli_free_result($result);
    } else {
        echo "You reached the end! <br />";
    }
}
$link->close();
