<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 4/21/2018
 * Time: 1:34 AM
 */
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>