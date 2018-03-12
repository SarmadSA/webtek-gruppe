<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
   
} else {
     echo '<script>window.location="/"</script>';
}