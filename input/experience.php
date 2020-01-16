<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 10:13 PM
 */

require "../config.php";
$emp_id = $company_name = $position = $start_date = $resg_date = '';
$emp_id_err = $company_name_err = $position_err = $start_date_err = $resg_date_err = '';

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

  if (empty(trim($_POST['company'])))
  {
    $company_name_err = 'Please enter company name.';
  }
  else
  {
    $company_name = trim($_POST['company']);
  }

  if (empty(trim($_POST['start'])))
  {
    $start_date_err = "Please enter starting date.";
  }
  else
  {
    $start_date = trim($_POST['start']);
  }

  if (empty(trim($_POST['resignation'])))
  {
    $resg_date_err = "Please enter resignation date.";
  }
  else
  {
    $resg_date = trim($_POST['resignation']);
  }

  if (empty(trim($_POST['position'])))
  {
    $position_err = "Please enter designation.";
  }
  else
  {
    $position = trim($_POST['position']);
  }

  if (empty($emp_id_err) && empty($start_date_err) && empty($company_name_err) && empty($resg_date_err) && empty($position_err))
  {
    $sql = oci_parse($conn,"insert into PREVIOUSEXPERIENCE (COMPANY_NAME, POSITION, STARTING_DATE, RESIGNATION_DATE) VALUES 
                                                                    (:bcompany,:bposition,to_date('$start_date','dd-mm-yyyy'),to_date('$resg_date','dd-mm-yyyy'))");

    if (!$sql)
    {
      echo oci_error($sql);
    }

    oci_bind_by_name($sql,":bcompany",$company_name);
    oci_bind_by_name($sql,":bposition",$position);

    $rs = oci_execute($sql);

    if (!$rs)
    {
      echo oci_error($rs);
    }

    $sql = oci_parse($conn,"insert into WASWORKING (EMP_ID, COMPANY_NAME) VALUES (:bid,:bcompany)");

    if (!$sql)
    {
      echo oci_error($sql);
    }

    oci_bind_by_name($sql,":bcompany",$company_name);
    oci_bind_by_name($sql,":bid",$emp_id);

    $rs = oci_execute($sql);

    if ($rs)
    {
      header("location: ../admin/index.php");
    }
    else
    {
      echo "Something went wrong.Please try again later.";
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
  <title>Previous Experience</title>
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

    <div class="form-group <?php echo (!empty($company_name_err)) ? 'has-error' : ''; ?>">
      <label>COMPANY NAME</label>
      <input type="text" name="company"class="form-control input-sm" value="<?php echo $company_name; ?>">
      <span class="help-block"><?php echo $company_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
      <label>DESIGNATION</label>
      <input type="text" name="position"class="form-control input-sm" value="<?php echo $position; ?>">
      <span class="help-block"><?php echo $position_err; ?></span>
    </div>


    <div class="form-group <?php echo (!empty($start_date_err)) ? 'has-error' : ''; ?>">
      <label>STARTING DATE</label>
      <input type="text" name="start"class="form-control input-sm" value="<?php echo $start_date; ?>" placeholder="DD-MM-YYYY">
      <span class="help-block"><?php echo $start_date_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($resg_date_err)) ? 'has-error' : ''; ?>">
      <label>RESIGNATION DATE</label>
      <input type="text" name="resignation"class="form-control input-sm" value="<?php echo $resg_date; ?>" placeholder="DD-MM-YYYY">
      <span class="help-block"><?php echo $resg_date_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

