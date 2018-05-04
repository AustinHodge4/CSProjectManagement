<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   if (isset($_COOKIE['showToast'])) {
        unset($_COOKIE['showToast']);
        setcookie('showToast', '', time() - 3600, '/');
    }
   //echo 'You have cleaned session';
   header("location: index.php");

?>