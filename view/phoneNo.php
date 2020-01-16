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



  <?php

            include '../nav/nav_admin.php';

        ?>



<h1><?php echo " Phone Number of"." ".oci_result($sql,"EMP_NAME") ?></h1>
<br>
<br>
<br>

<?php

$sql = oci_parse($conn,"SELECT EMP_ID,EMP_NAME,PHONE_NO FROM PHONENUMBER join EMPLOYEE using (EMP_ID) where EMP_ID = '$username'");
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
echo "<th>PHONE NUMBER</th>";
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



<?php

include '../nav/nav_footer.php';
?>
