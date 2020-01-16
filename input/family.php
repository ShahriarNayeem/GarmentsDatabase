<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 11:09 AM
 */

$emp_id = $father_name = $mother_name = $siblings = $children = '';
$emp_id_err = $father_name_err = $mother_name_err = $siblings_err = $children_err = '';

require "../config.php";

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

  if (empty(trim($_POST['father'])))
  {
    $father_name_err = "Please enter father's name.";
  }
  else
  {
    $father_name = trim($_POST['father']);
  }

  if (empty(trim($_POST['mother'])))
  {
    $mother_name_err = "Please enter mother's name.";
  }
  else
  {
    $mother_name = trim($_POST['mother']);
  }

  if (!preg_match("/^[0-9]*$/",$_POST['sibling']))
  {
      $siblings_err = "Can not contain letter.";
  }
  else
  {
      $siblings = trim($_POST['sibling']);
  }

  if (!preg_match("/^[0-9]*$/",$_POST['children']))
  {
      $children_err = "Can not contain letter.";
  }
  else
  {
      $children = trim($_POST['children']);
  }

  if (empty($emp_id_err) && empty($father_name_err) && empty($mother_name_err) && empty($children_err) && empty($siblings_err))
  {
      $sql = oci_parse($conn,"insert into FAMILY (EMP_ID, FATHER_NAME, MOTHER_NAME, NO_SIBLINGS, NO_CHILDREN) VALUES (:bid,:bfname,:bmname,:bsib,:bchild)");
      if (!$sql)
      {
          echo oci_error($sql);
      }

      oci_bind_by_name($sql,":bid",$emp_id);
      oci_bind_by_name($sql,":bfname",$father_name);
      oci_bind_by_name($sql,":bmname",$mother_name);
      oci_bind_by_name($sql,":bsib",$siblings);
      oci_bind_by_name($sql,":bchild",$children);

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
  <title>Family Information</title>
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

    <div class="form-group <?php echo (!empty($father_name_err)) ? 'has-error' : ''; ?>">
      <label>FATHER NAME</label>
      <input type="text" name="father"class="form-control input-sm" value="<?php echo $father_name; ?>">
      <span class="help-block"><?php echo $father_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($mother_name_err)) ? 'has-error' : ''; ?>">
      <label>MOTHER NAME</label>
      <input type="text" name="mother"class="form-control input-sm" value="<?php echo $mother_name; ?>">
      <span class="help-block"><?php echo $mother_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($siblings_err)) ? 'has-error' : ''; ?>">
      <label>NO OF SIBLINGS</label>
      <input type="text" name="sibling"class="form-control input-sm" value="<?php echo $siblings; ?>">
      <span class="help-block"><?php echo $siblings_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($children_err)) ? 'has-error' : ''; ?>">
      <label>NO OF CHILDREN</label>
      <input type="text" name="children"class="form-control input-sm" value="<?php echo $children; ?>">
      <span class="help-block"><?php echo $children_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

