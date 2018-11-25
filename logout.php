<?php
/**
 * Created by PhpStorm.
 * User: Saef
 * Date: 08-Mar-16
 * Time: 3:49 PM
 */

session_start();


// remove all session variables
session_unset();

// destroy the session
session_destroy();
header("location:index.php");

?>

