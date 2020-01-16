<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/2/2018
 * Time: 5:11 PM
 */
$username = '';
require "../config.php";
session_start();

$username = $_SESSION['search'];

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

$sql = oci_parse($conn,"select EMP_ID,EMP_NAME,OFFICER_ID,OFFICER_NAME,THANA
from EMPLOYEE join WASVERIFIED using (EMP_ID) join POLICEVERIFY using (POL_FORM_NO) where EMP_ID = '$username'");

if (!$sql)
{
  echo "error";
}

$rs = oci_execute($sql);
if (!$rs)
{
  echo oci_error();
}

oci_fetch($sql);

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?></title>
  <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-inverse">

  <div class="container-fluid">

    <ul class="nav navbar-nav">

      <li><a href="../viewForm.php" class="glyphicon glyphicon-home">HOME</a> </li>

    </ul>

    <ul class="nav navbar-nav navbar-right">

      <li><a href="../login/logout.php">Logout</a> </li>

    </ul>

  </div>

</nav>

<div class="container">

  <h1><?php echo " Police Verification Information of"." ".oci_result($sql,"EMP_NAME") ?></h1>
  <p ><span style="font-weight: bold">EMPLOYEE ID: </span> <?php echo oci_result($sql,"EMP_ID")?></p>
  <p ><span style="font-weight: bold">EMPLOYEE NAME: </span> <?php echo oci_result($sql,"EMP_NAME")?></p>
  <p ><span style="font-weight: bold">OFFICER ID: </span> <?php echo oci_result($sql,"OFFICER_ID")?></p>
  <p ><span style="font-weight: bold">OFFICER NAME: </span> <?php echo oci_result($sql,"OFFICER_NAME")?></p>
  <p ><span style="font-weight: bold">THANA: </span> <?php echo oci_result($sql,"THANA")?></p>

</div>


</body>
</html>
