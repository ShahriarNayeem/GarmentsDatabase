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

$username = $_SESSION['username'];

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

$sql = oci_parse($conn,"select EMP_ID,EMP_NAME,COMPANY_NAME,to_char(STARTING_DATE,'dd-mon-yyyy') as Joined,to_char(RESIGNATION_DATE,'dd-mon-yyyy') as Retired,trunc((RESIGNATION_DATE - STARTING_DATE) / 365.25) as SERVED,POSITION
from EMPLOYEE join WASWORKING using (EMP_ID) join PREVIOUSEXPERIENCE using (COMPANY_NAME) where EMP_ID = '$username'");

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

  <h1><?php echo " Previous Experience of"." ".oci_result($sql,"EMP_NAME") ?></h1>
  <p ><span style="font-weight: bold">EMPLOYEE ID: </span> <?php echo oci_result($sql,"EMP_ID")?></p>
  <p ><span style="font-weight: bold">EMPLOYEE NAME: </span> <?php echo oci_result($sql,"EMP_NAME")?></p>
  <p ><span style="font-weight: bold">COMPANY NAME: </span> <?php echo oci_result($sql,"COMPANY_NAME")?></p>
  <p ><span style="font-weight: bold">POSITION: </span> <?php echo oci_result($sql,"POSITION")?></p>
  <p ><span style="font-weight: bold">JOINED: </span> <?php echo oci_result($sql,"JOINED")?></p>
  <p ><span style="font-weight: bold">RETIRED: </span> <?php echo oci_result($sql,"RETIRED")?></p>
  <p ><span style="font-weight: bold">SERVED(in year): </span> <?php echo oci_result($sql,"SERVED")." year approx" ?></p>
</div>


</body>
</html>
