<?php
include 'templates/header_template.php';
?>
        <div class="row container-fluid text-light container">
            <div class="col-lg">
                <h1>Add new post</h1>
                <form action="post/uploadPost.php" method="post" enctype="multipart/form-data">
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
                <a class="nav-link btn btn-info" href="index.php">Back</a>
            </aside>
        </div>
    </body>
</html>
