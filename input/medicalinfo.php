<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 3:07 PM
 */
require "../config.php";

$emp_id = $height = $weight = $systole = $diastole = $suger_level = $hiv = '';
$emp_id_err = $height_err = $weight_err = $systole_err = $diastole_err = $suger_level_err = $hiv_err = '';

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

  if (empty(trim($_POST['height'])))
  {
      $height_err = "Please enter height.";
  }
  else
  {
      $height = trim($_POST['height']);
  }

  if (empty(trim($_POST['weight'])))
  {
      $weight_err = "Please enter weight.";
  }
  else
  {
      $weight = trim($_POST['weight']);
  }

  if (empty(trim($_POST['systole'])))
  {
      $systole_err = "Please enter systole.";
  }
  else
  {
      $systole = trim($_POST['systole']);
  }

  if (empty(trim($_POST['diastole'])))
  {
      $diastole_err = "Please enter diastole.";
  }
  else
  {
      $diastole = trim($_POST['diastole']);
  }

  if (empty(trim($_POST['sugar'])))
  {
      $suger_level_err = "Please enter sugar level.";
  }
  else
  {
      $suger_level = trim($_POST['sugar']);
  }

  if (empty($_POST['hiv']))
  {
      $hiv_err = "Please select answer.";
  }
  else
  {
      $hiv = $_POST['hiv'];
  }

  if (empty($emp_id_err) && empty($height_err) && empty($weight_err) && empty($systole_err) && empty($diastole_err) && empty($suger_level_err) && empty($hiv_err))
  {
      $sql = oci_parse($conn,"insert into MEDICALINFO (EMP_ID, HEIGHT, WEIGHT, SYSTOLE, DIASTOLE, SUGAR_LEVEL, HIV_POSITIVE) VALUES 
                                                              (:bid,:bheight,:bweight,:bsystole,:bdiastole,:bsugar,:bhiv)");

      if (!$sql)
      {
          echo oci_error($sql);
      }

      oci_bind_by_name($sql,":bid",$emp_id);
      oci_bind_by_name($sql,":bheight",$height);
      oci_bind_by_name($sql,":bweight",$weight);
      oci_bind_by_name($sql,":bsystole",$systole);
      oci_bind_by_name($sql,":bdiastole",$diastole);
      oci_bind_by_name($sql,":bsugar",$suger_level);
      oci_bind_by_name($sql,":bhiv",$hiv);

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
  <title>Medical Checkup Form</title>
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

    <div class="form-group <?php echo (!empty($height_err)) ? 'has-error' : ''; ?>">
      <label>HEIGHT</label>
      <input type="text" name="height"class="form-control input-sm" value="<?php echo $height; ?>">
      <span class="help-block"><?php echo $height_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($weight_err)) ? 'has-error' : ''; ?>">
      <label>WEIGHT</label>
      <input type="text" name="weight"class="form-control input-sm" value="<?php echo $weight; ?>">
      <span class="help-block"><?php echo $weight_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($systole_err)) ? 'has-error' : ''; ?>">
      <label>SYSTOLE</label>
      <input type="text" name="systole"class="form-control input-sm" value="<?php echo $systole; ?>">
      <span class="help-block"><?php echo $systole_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($diastole_err)) ? 'has-error' : ''; ?>">
      <label>DIASTOLE</label>
      <input type="text" name="diastole"class="form-control input-sm" value="<?php echo $diastole; ?>">
      <span class="help-block"><?php echo $diastole_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($suger_level_err)) ? 'has-error' : ''; ?>">
      <label>SUGAR LEVEL</label>
      <input type="text" name="sugar"class="form-control input-sm" value="<?php echo $suger_level; ?>">
      <span class="help-block"><?php echo $suger_level_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($hiv_err)) ? 'has-error' : ''; ?>">
      <label>HIV POSITIVE</label>
      <select name="hiv" class="form-control">

        <option></option>
        <option>YES</option>
        <option>NO</option>

      </select>
      <span class="help-block"><?php echo $hiv_err; ?></span>
    </div>

      <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Submit">
          <input type="reset" class="btn btn-default" value="Reset">
      </div>

  </form>

</div>

</body>
</html>
