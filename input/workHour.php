<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/26/2018
 * Time: 12:13 AM
 */

require "../config.php";

$emp_id = $start_time = $finish_time = $work_month = '';
$emp_id_err = $start_time_err = $finish_time_err = $work_month_err = '';

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

  if (empty(trim($_POST['star_time'])))
  {
    $start_time_err = "Please enter starting time.";
  }
  else
  {
    $start_time = trim($_POST['star_time']);
  }

  if (empty(trim($_POST['finish_time'])))
  {
    $finish_time_err = "Please enter finishing time.";
  }
  else
  {
    $finish_time = trim($_POST['finish_time']);
  }

  if (empty($_POST['work_month']))
  {
    $work_month_err = "Please select a month.";
  }
  else
  {
    $work_month = $_POST['work_month'];
  }

  if (empty($emp_id_err) && empty($start_time_err) && empty($finish_time_err) && empty($work_month_err))
  {
    $sql = oci_parse($conn,"insert into WORKHOUR (EMP_ID, STARTING_TIME, FINISHING_TIME, WORK_MONTH) VALUES 
                                                          ('$emp_id',to_date('$start_time','dd-mm-yyyy hh:mi'),to_date('$finish_time','dd-mm-yyyy hh:mi'),'$work_month')");
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
  <title>Work Hour</title>
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

    <div class="form-group <?php echo (!empty($start_time_err)) ? 'has-error' : ''; ?>">
      <label>START TIME</label>
      <input type="text" name="star_time"class="form-control input-sm" value="<?php echo $start_time; ?>" placeholder="DD-MM-YYYY HH:MI">
      <span class="help-block"><?php echo $start_time_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($finish_time_err)) ? 'has-error' : ''; ?>">
      <label>FINISH TIME</label>
      <input type="text" name="finish_time"class="form-control input-sm" value="<?php echo $finish_time; ?>" placeholder="DD-MM-YYYY HH:MI">
      <span class="help-block"><?php echo $finish_time_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($work_month_err)) ? 'has-error' : ''; ?>">
      <label>SELECT MONTH:</label>
      <select name="work_month" class="form-control">

        <option></option>
        <option>JANUARY</option>
        <option>FEBRUARY</option>
        <option>MARCH</option>
        <option>APRIL</option>
        <option>MAY</option>
        <option>JUNE</option>
        <option>JULY</option>
        <option>AUGUST</option>
        <option>SEPTEMBER</option>
        <option>OCTOBER</option>
        <option>NOVEMBER</option>
        <option>DECEMBER</option>

      </select>
      <span class="help-block"><?php echo $work_month_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>
