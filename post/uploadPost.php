<?php
$target_dir = "./uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "<script>
setTimeout(function () {
   window.location.href= '../upload.php';
}, 5000); </script>";

// if everything is ok, try to upload file
} else {
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $newfilename)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

        require_once('../config.php');

// Database connection                                   
        $mysqli = mysqli_init();
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
        $mysqli->real_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

        $head = filter_input(INPUT_POST, 'heading');
        $img = "uploads/" . $newfilename;
        $uname = $_SESSION['email'];

        $result = $mysqli->query("INSERT INTO `posts`(`header`, `img`, `author`) VALUES ('$head', '$img', '$uname')");
        if ($result) {
            $sql = "SELECT * FROM `posts` ORDER BY `id` DESC LIMIT 1";
            $result = $mysqli->query($sql);
            while ($row = mysqli_fetch_row($result)) {
                echo '<script>window.location="../post.php?id=' . $row[0] . '"</script>';
            }
        } else {
            echo "Error";
        }
        $mysqli->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


