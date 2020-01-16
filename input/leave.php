<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/26/2018
 * Time: 12:48 AM
 */
require "../config.php";
$emp_id = $leave_from = $leave_to = $reason = '';
$emp_id_err = $leave_from_err = $leave_to_err = $reason_err = '';

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

  if (empty(trim($_POST['l_start'])))
  {
    $leave_from_err = "Please enter start date.";
  }
  else
  {
    $leave_from = trim($_POST['l_start']);
  }

  if (empty(trim($_POST['l_ends'])))
  {
    $leave_to_err = "Please enter end date.";
  }
  else
  {
    $leave_to = trim($_POST['l_ends']);
  }

  if (empty(trim($_POST['reason'])))
  {
    $reason_err = "Please enter reason.";
  }
  else
  {
    $reason = trim($_POST['reason']);
  }

  if (empty($emp_id_err) && empty($leave_from_err) && empty($leave_to_err) && empty($reason_err))
  {
    $sql = oci_parse($conn,"insert into LEAVE (LEAVE_ID, LEAVE_FROM, LEAVE_TO, REASON) VALUES 
                                                      (LEAVE_LEAVE_ID_SEQ.nextval,to_date('$leave_from','dd-mm-yyyy'),to_date('$leave_to','dd-mm-yyyy'),'$reason')");

    if (!$sql)
    {
      echo oci_error($sql);
    }

    $rs = oci_execute($sql);

    if (!$rs)
    {
      echo oci_error($rs);
    }

    $sql = oci_parse($conn,"insert into HASTAKEN (EMP_ID, LEAVE_ID) VALUES ('$emp_id',LEAVE_LEAVE_ID_SEQ.currval)");
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
    oci_free_statement($sql);
  }
  oci_close($conn);
}

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
  <title>Leave Form</title>
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
      <label>EMPLOYEE ID</label>
      <input type="text" name="emp_id"class="form-control input-sm" value="<?php echo $emp_id; ?>">
      <span class="help-block"><?php echo $emp_id_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($leave_from_err)) ? 'has-error' : ''; ?>">
      <label>LEAVE START</label>
      <input type="text" name="l_start"class="form-control input-sm" value="<?php echo $leave_from; ?>" placeholder="DD-MM-YYYY">
      <span class="help-block"><?php echo $leave_from_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($leave_to_err)) ? 'has-error' : ''; ?>">
      <label>LEAVE ENDS</label>
      <input type="text" name="l_ends"class="form-control input-sm" value="<?php echo $leave_to; ?>" placeholder="DD-MM-YYYY">
      <span class="help-block"><?php echo $leave_to_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($reason_err)) ? 'has-error' : ''; ?>">
      <label>REASON</label>
      <input type="text" name="reason"class="form-control input-sm" value="<?php echo $reason; ?>">
      <span class="help-block"><?php echo $reason_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

