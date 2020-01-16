<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/20/2018
 * Time: 11:37 PM
 */
require "../config.php";

$rows = 0;
$emp_id = $retirement = $cause = "";
$emp_id_err = $retirement_err = $cause_err = "";

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST['emp_id']))) {
    $emp_id_err = "Please enter id.";
  } else {
    $emp_id = trim($_POST['emp_id']);
    $sql = oci_parse($conn, "select * from EMPLOYEE where EMP_ID = '$emp_id'");
    if (!$sql) {
      echo "error";
    }

    $rs = oci_execute($sql);
    oci_fetch($sql);

    $rows = oci_num_rows($sql);

    if ($rs) {
      if ($rows == 1) {
        $emp_id = trim($_POST['emp_id']);
      } else {
        $emp_id_err = "No account found with that ID.";
      }
    } else {
      echo "Something went wrong.Please try again later.";
    }

    oci_free_statement($sql);
  }

  if (empty($_POST['retire']))
  {
    $retirement_err = "Please enter date.";
  }
  else
  {
    $retirement = $_POST['retire'];
  }

  if (empty(trim($_POST['cause']))) {
    $cause_err = "Please enter cause.";
  }
  else
  {
    $cause = trim($_POST['cause']);
  }

  $sql = oci_parse($conn,"update EMPLOYEE set DATE_OF_RETIREMENT = to_date('$retirement','DD-MM-YYYY') , RETIREMENT_CAUSE = '$cause' where EMP_ID = '$emp_id'");
  if (!$sql)
  {
    echo oci_error($sql);
  }

  $rs = oci_execute($sql);

  if ($rs)
  {
    header("location: ../admin/index.php");
  }
  else
  {
    echo "Something went wrong. PLease try again later.";
  }

}
oci_close($conn);

?>




<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <style type="text/css">
    body
    {font: 14px sans-serif;}

    .wrapper
    {width: 350px; padding: 20px;}
  </style>
  <title>Retirement Form</title>
</head>
<body>

<nav class="navbar navbar-inverse">

  <div class="container-fluid">

    <ul class="nav navbar-nav">

      <li><a href="../admin/index.php" class="glyphicon glyphicon-home">HOME</a> </li>

    </ul>

    <ul class="nav navbar-nav navbar-right">

      <li><a href="../login/logout.php">Logout</a> </li>

    </ul>

  </div>

</nav>

<div class="wrapper">

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="form-group <?php echo (!empty($emp_id_err)) ? 'has-error' : ''; ?>">
      <label>ID</label>
      <input type="text" name="emp_id"class="form-control input-sm" value="<?php echo $emp_id; ?>">
      <span class="help-block"><?php echo $emp_id_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($retirement_err)) ? 'has-error' : ''; ?>">
      <label>Retirement Date</label>
      <input type="text" name="retire"class="form-control input-sm" value="<?php echo $retirement; ?>" placeholder="DD-MM-YYYY">
      <span class="help-block"><?php echo $retirement_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($cause_err)) ? 'has-error' : ''; ?>">
      <label>Retirement Cause</label>
      <input type="text" name="cause"class="form-control input-sm" value="<?php echo $cause; ?>">
      <span class="help-block"><?php echo $cause_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>
