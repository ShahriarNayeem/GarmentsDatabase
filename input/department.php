<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 11:16 PM
 */
require "../config.php";

$emp_id = $dept_name = $floor_no = $dept_head = $strength = $section = $section_manager = '';
$emp_id_err = $dept_name_err = $floor_no_err = $dept_head_err = $strength_err = $section_err = $section_manager_err = '';

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

  if (empty(trim($_POST['dept_name'])))
  {
    $dept_name_err = "Please enter department name.";
  }
  else
  {
    $dept_name = trim($_POST['dept_name']);
  }

  if (empty(trim($_POST['floor'])))
  {
    $floor_no_err = "Please enter floor no.";
  }
  else
  {
    $floor_no = trim($_POST['floor']);
  }

  if (empty(trim($_POST['dept_head'])))
  {
    $dept_head_err = "Please enter department head name.";
  }
  else
  {
    $dept_head = trim($_POST['dept_head']);
  }

  if (empty(trim($_POST['strength'])))
  {
    $strength_err = "Please enter department strength.";
  }
  else
  {
    $strength = trim($_POST['strength']);
  }

  $section = trim($_POST['section']);
  $section_manager = trim($_POST['section_mng']);

  if (empty($emp_id_err) && empty($dept_name_err) && empty($floor_no_err) && empty($dept_head_err) && empty($strength_err))
  {
    $sql = oci_parse($conn,"insert into DEPARTMENT (DEPT_NAME, FLOOR_NO, DEPT_HEAD, STRENGTH) VALUES (:bdeptn,:bfloor,:bdepth,:bstrn)");
    if (!$sql)
    {
      echo oci_error($sql);
    }

    oci_bind_by_name($sql,":bdeptn",$dept_name);
    oci_bind_by_name($sql,":bfloor",$floor_no);
    oci_bind_by_name($sql,":bdepth",$dept_head);
    oci_bind_by_name($sql,":bstrn",$strength);

    $rs = oci_execute($sql);
    if (!$rs)
    {
      echo oci_error($rs);
    }

    $sql = oci_parse($conn,"insert into WORKSIN (EMP_ID, DEPT_NAME, SECTION, SECTION_MANAGER) VALUES ('$emp_id','$dept_name','$section','$section_manager')");

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
  <title>DEPARTMENT</title>
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

    <div class="form-group <?php echo (!empty($dept_name_err)) ? 'has-error' : ''; ?>">
      <label>DEPT NAME</label>
      <input type="text" name="dept_name"class="form-control input-sm" value="<?php echo $dept_name; ?>">
      <span class="help-block"><?php echo $dept_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($floor_no_err)) ? 'has-error' : ''; ?>">
      <label>FLOOR NO</label>
      <input type="text" name="floor"class="form-control input-sm" value="<?php echo $floor_no; ?>">
      <span class="help-block"><?php echo $floor_no_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($dept_head_err)) ? 'has-error' : ''; ?>">
      <label>DEPT HEAD</label>
      <input type="text" name="dept_head"class="form-control input-sm" value="<?php echo $dept_head; ?>">
      <span class="help-block"><?php echo $dept_head_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($strength_err)) ? 'has-error' : ''; ?>">
      <label>STRENGTH</label>
      <input type="text" name="strength"class="form-control input-sm" value="<?php echo $strength; ?>">
      <span class="help-block"><?php echo $strength_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($section_err)) ? 'has-error' : ''; ?>">
      <label>SECTION</label>
      <input type="text" name="section"class="form-control input-sm" value="<?php echo $section; ?>">
      <span class="help-block"><?php echo $section_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($section_manager_err)) ? 'has-error' : ''; ?>">
      <label>SECTION MANAGER</label>
      <input type="text" name="section_mng"class="form-control input-sm" value="<?php echo $section; ?>">
      <span class="help-block"><?php echo $section_manager_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

