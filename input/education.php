<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 1:06 PM
 */

require "../config.php";
$emp_id = $deg_name = $group_name = $institution = $grade = $pass_year = '';
$emp_id_err = $deg_name_err = $group_name_err = $institution_err = $grade_err = $pass_year_err = '';

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

  if (empty(trim($_POST['degree'])))
  {
      $deg_name_err = "Please enter degree name.";
  }
  else
  {
      $deg_name = trim($_POST['degree']);
  }

  if (empty(trim($_POST['group'])))
  {
      $group_name_err = "Please enter group.";
  }
  else
  {
      $group_name = trim($_POST['group']);
  }

  if (empty(trim($_POST['institution'])))
  {
      $institution_err = "Please enter institution name.";
  }
  else
  {
      $institution = trim($_POST['institution']);
  }

  if (empty(trim($_POST['grade'])))
  {
      $grade_err = "Please enter your grade.";
  }
  else
  {
      $grade = trim($_POST['grade']);
  }

  if (empty(trim($_POST['year'])))
  {
      $pass_year_err = "Please enter pass year.";
  }
  else
  {
      $pass_year = trim($_POST['year']);
  }

  if (empty($emp_id_err) && empty($deg_name_err) && empty($group_name_err) && empty($pass_year_err) && empty($grade_err) && empty($institution_err))
  {
      $sql = oci_parse($conn,"insert into EDUCATION (EMP_ID, DEG_NAME, GROUP_NAME, INSTITUTION, GRADE, PASS_YEAR) VALUES (:bid,:bdeg,:bgroup,:binst,:bgrade,:bpass)");
      if (!$sql)
      {
          echo oci_error($sql);
      }

      oci_bind_by_name($sql,":bid",$emp_id);
      oci_bind_by_name($sql,":bdeg",$deg_name);
      oci_bind_by_name($sql,":bgroup",$group_name);
      oci_bind_by_name($sql,":binst",$institution);
      oci_bind_by_name($sql,":bgrade",$grade);
      oci_bind_by_name($sql,":bpass",$pass_year);

      $rs = oci_execute($sql);

      if ($rs)
      {
          header("location: education.php");
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
  <title>Education</title>
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

    <div class="form-group <?php echo (!empty($deg_name_err)) ? 'has-error' : ''; ?>">
      <label>DEGREE NAME</label>
      <input type="text" name="degree"class="form-control input-sm" value="<?php echo $deg_name; ?>">
      <span class="help-block"><?php echo $deg_name_err; ?></span>
    </div>

      <div class="form-group <?php echo (!empty($group_name_err)) ? 'has-error' : ''; ?>">
          <label>GROUP NAME</label>
          <input type="text" name="group"class="form-control input-sm" value="<?php echo $group_name; ?>">
          <span class="help-block"><?php echo $group_name_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($institution_err)) ? 'has-error' : ''; ?>">
          <label>INSTITUTION NAME</label>
          <input type="text" name="institution"class="form-control input-sm" value="<?php echo $institution; ?>">
          <span class="help-block"><?php echo $institution_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($grade_err)) ? 'has-error' : ''; ?>">
          <label>GRADE</label>
          <input type="text" name="grade"class="form-control input-sm" value="<?php echo $grade; ?>">
          <span class="help-block"><?php echo $grade_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($pass_year_err)) ? 'has-error' : ''; ?>">
          <label>PASS YEAR</label>
          <input type="text" name="year"class="form-control input-sm" value="<?php echo $pass_year; ?>">
          <span class="help-block"><?php echo $pass_year_err; ?></span>
      </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

