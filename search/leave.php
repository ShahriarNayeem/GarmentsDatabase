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

$sql = oci_parse($conn,"select EMP_NAME from EMPLOYEE where EMP_ID='$username'");

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

<h1><?php echo " Leave Status of"." ".oci_result($sql,"EMP_NAME") ?></h1>
<br>
<br>
<br>

<?php

$sql = oci_parse($conn,"SELECT EMP_ID,EMP_NAME,to_char(LEAVE_FROM,'dd-mon-yyyy'),to_char(LEAVE_TO,'dd-mon-yyyy'),trunc((LEAVE_TO - LEAVE_FROM)),REASON FROM EMPLOYEE join HASTAKEN using (EMP_ID) join LEAVE using (LEAVE_ID) where EMP_ID = '$username'");
if(! $sql )
{
  echo "error";
}
$rs = oci_execute($sql);
if(!$rs)
{
  exit("Error in sql");
}

echo "<table border = 1><tr>";
echo "<th>EMPLOYEE ID</th>";
echo "<th>EMPLOYEE NAME</th>";
echo "<th>LEAVE STARTS</th>";
echo "<th>LEAVE ENDS</th>";
echo "<th>TOTAL DAYS</th>";
echo "<th>REASON</th>";
while ($row = oci_fetch_array($sql,OCI_ASSOC+OCI_RETURN_NULLS))
{
  echo "<tr> \n";
  foreach ($row as $item)
  {
    print "<td>";
    print $item;
    print "</td>";
  }
  echo "</tr>\n";
}
oci_close($conn);
echo "</table>";
?>
</body>
</html>