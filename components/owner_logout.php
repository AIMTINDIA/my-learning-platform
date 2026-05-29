<?php

   include 'connect.php';

   setcookie('owner_id', '', time() - 1, '/');

   header('location:../admin/owner/login.php');

?>