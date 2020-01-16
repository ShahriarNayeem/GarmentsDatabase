<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/26/2018
 * Time: 9:05 AM
 */

require "../config.php";

$emp_id = $officer_name = $officer_id = $thana = '';
$emp_id_err = $officer_name_err = $officer_id_err = $thana_err = '';

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

  if (empty(trim($_POST['off_name'])))
  {
    $officer_name_err = "Please enter officer name.";
  }
  else
  {
    $officer_name = trim($_POST['off_name']);
  }

  if (empty(trim($_POST['off_id'])))
  {
    $officer_id_err = "Please enter officer name.";
  }
  else
  {
    $officer_id = trim($_POST['off_id']);
  }

  if (empty(trim($_POST['thana'])))
  {
    $thana_err = "Please enter officer name.";
  }
  else
  {
    $thana = trim($_POST['thana']);
  }

  if (empty($emp_id_err) && empty($officer_id_err) && empty($officer_name_err) && empty($thana_err))
  {
    $sql = oci_parse($conn,"insert into POLICEVERIFY (POL_FORM_NO, OFFICER_NAME, OFFICER_ID, THANA) VALUES 
                                                             (POLICEVERIFY_POL_FORM_NO_SEQ.nextval,'$officer_name','$officer_id','$thana')");

    if (!$sql)
    {
      echo oci_error($sql);
    }

    $rs = oci_execute($sql);

    if (!$rs)
    {
      echo oci_error($rs);
    }

    $sql = oci_parse($conn,"insert into WASVERIFIED (EMP_ID, POL_FORM_NO) VALUES ('$emp_id',POLICEVERIFY_POL_FORM_NO_SEQ.currval)");
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
  <title>Police Verification</title>
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

    <div class="form-group <?php echo (!empty($officer_name_err)) ? 'has-error' : ''; ?>">
      <label>OFFICER NAME</label>
      <input type="text" name="off_name"class="form-control input-sm" value="<?php echo $officer_name; ?>">
      <span class="help-block"><?php echo $officer_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($officer_id_err)) ? 'has-error' : ''; ?>">
      <label>OFFICER ID</label>
      <input type="text" name="off_id"class="form-control input-sm" value="<?php echo $officer_id; ?>">
      <span class="help-block"><?php echo $officer_id_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($thana_err)) ? 'has-error' : ''; ?>">
      <label>THANA</label>
      <input type="text" name="thana"class="form-control input-sm" value="<?php echo $thana; ?>">
      <span class="help-block"><?php echo $thana_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>
