<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 4/21/2018
 * Time: 1:24 AM
 */
// Initialize the session
require ("config.php");
session_start();

$username = '';

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

$username = $_SESSION['username'];

$sql = oci_parse($conn,"select * from USERS where USER_NAME = '$username'");

if (!$sql)
{
    echo oci_error($sql);
}

$rs = oci_execute($sql);
if (!$rs)
{
    echo oci_error($rs);
}

oci_fetch($sql);

if (oci_result($sql,'USER_ROLE') == 'ADMIN')
{
  session_start();
  $_SESSION['username'] = $username;
  //header("location: profile.php");
  header("location: admin/index.php");
}
else
{
  session_start();
  $_SESSION['username'] = $username;
  // header("location: welcome.php");
  header("location: user/index.php");
}

?>