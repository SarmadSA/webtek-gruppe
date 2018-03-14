<?php
require_once('config.php');

if (empty($_GET["id"])) {
    header("Location: index.php");
}

include'templates/header_template.php';

$id = $_GET["id"];
$link = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT * FROM posts WHERE id = $id";

if ($result = mysqli_query($link, $query)) {

    /* fetch associative array */
    while ($row = mysqli_fetch_assoc($result)) {
        $heading = $row['header'];
        $name = $row['author'];
        $img = $row['img'];
        $rate = $row['rating'];
        echo "<article><h2>$heading</h2><img src=post/$img><p>Uploaded by $name</p><p>Rating: $rate</p></article>";
    }

    /* free result set */
    mysqli_free_result($result);
}
$link->close();

?>
            <aside>
                <a class="nav-link btn btn-info" href="index.php">Back</a>
            </aside>
<?php
include 'templates/footer_template.php';