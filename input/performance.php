<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/26/2018
 * Time: 9:34 AM
 */

require "../config.php";

$emp_id = $work_efficiency = $remarks = $reviewer = '';
$emp_id_err = $work_efficiency_err = $remarks_err = $reviewer_err = '';

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

  if (empty(trim($_POST['efficiency'])))
  {
    $work_efficiency_err = "Please enter efficiency.";
  }
  else
  {
    $work_efficiency = trim($_POST['efficiency']);
  }

  if (empty(trim($_POST['remarks'])))
  {
    $remarks_err = "Please enter remarks.";
  }
  else
  {
    $remarks = trim($_POST['remarks']);
  }

  if (empty(trim($_POST['rev_name'])))
  {
    $reviewer = "Please enter reviewer name.";
  }
  else
  {
    $reviewer = trim($_POST['rev_name']);
  }

  if (empty($emp_id_err) && empty($remarks_err) && empty($work_efficiency_err))
  {
    $sql = oci_parse($conn,"insert into PERFORM (PER_FORM_NO, WORK_EFFICIENCY, REMARKS) VALUES 
                                                        (PREFORM_PER_FORM_NO_SEQ.nextval,'$work_efficiency','$remarks')");

    if (!$sql)
    {
      echo oci_error($sql);
    }

    $rs = oci_execute($sql);

    if(!$rs)
    {
      echo oci_error($rs);
    }

    $sql = oci_parse($conn,"insert into WASREVIEWED (EMP_ID, PER_FORM_NO, REVIEWER) VALUES ('$emp_id',PREFORM_PER_FORM_NO_SEQ.currval,'$reviewer')");
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
  <title>Performance Form</title>
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

    <div class="form-group <?php echo (!empty($reviewer_err)) ? 'has-error' : ''; ?>">
      <label>REVIEWER NAME</label>
      <input type="text" name="rev_name"class="form-control input-sm" value="<?php echo $reviewer; ?>">
      <span class="help-block"><?php echo $reviewer_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($work_efficiency_err)) ? 'has-error' : ''; ?>">
      <label>WORK FINISHED</label>
      <input type="text" name="efficiency"class="form-control input-sm" value="<?php echo $work_efficiency; ?>">
      <span class="help-block"><?php echo $work_efficiency; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($remarks_err)) ? 'has-error' : ''; ?>">
      <label>REMARKS</label>
      <input type="text" name="remarks"class="form-control input-sm" value="<?php echo $remarks; ?>">
      <span class="help-block"><?php echo $remarks_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>
