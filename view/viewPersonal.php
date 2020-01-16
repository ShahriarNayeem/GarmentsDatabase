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

$sql = oci_parse($conn,"select EMP_ID, EMP_NAME, to_char(EMP_DOB,'dd-MON-yyyy') as DOB, trunc((sysdate - EMP_DOB) / 365.25) AS AGE, DESIGNATION, to_char(JOINING_DATE,'dd-MON-yyyy') as JOINED, EMAIL_ID , RELIGION, MARITAL_STATUS, EMP_NID_NO, BLOOD_GROUP,NATIONALITY from EMPLOYEE where EMP_ID='$username'");

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

        

              <div class="container">

                  <h1><?php echo " Personal information of"." ".oci_result($sql,"EMP_NAME") ?></h1>
                  <p ><span style="font-weight: bold">EMPLOYEE ID: </span> <?php echo oci_result($sql,"EMP_ID")?></p>
                  <p ><span style="font-weight: bold">EMPLOYEE Name: </span> <?php echo oci_result($sql,"EMP_NAME")?></p>
                  <p ><span style="font-weight: bold">DATE Of BIRTH: </span> <?php echo oci_result($sql,"DOB")?></p>
                  <p ><span style="font-weight: bold">AGE: </span> <?php echo oci_result($sql,"AGE")?></p>
                  <p ><span style="font-weight: bold">DESIGNATION: </span> <?php echo oci_result($sql,"DESIGNATION")?></p>
                  <p ><span style="font-weight: bold">JOINED: </span> <?php echo oci_result($sql,"JOINED")?></p>
                  <p ><span style="font-weight: bold">EMAIL: </span> <?php echo oci_result($sql,"EMAIL_ID")?></p>
                  <p ><span style="font-weight: bold">RELIGION: </span> <?php echo oci_result($sql,"RELIGION")?></p>
                  <p ><span style="font-weight: bold">MARITAL STATUS: </span> <?php echo oci_result($sql,"MARITAL_STATUS")?></p>
                  <p ><span style="font-weight: bold">NID NO: </span> <?php echo oci_result($sql,"EMP_NID_NO")?></p>
                  <p ><span style="font-weight: bold">BLOOD GROUP: </span> <?php echo oci_result($sql,"BLOOD_GROUP")?></p>
                  <p ><span style="font-weight: bold">NATIONALITY: </span> <?php echo oci_result($sql,"NATIONALITY")?></p>


              </div>


<?php

include '../nav/nav_footer.php';
?>