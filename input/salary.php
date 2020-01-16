<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/26/2018
 * Time: 8:05 AM
 */

require "../config.php";

$emp_id = $acct_no = $class = $basic = $bonus = $sal_month = $paid_status = $payPerhour = '';
$emp_id_err = $acct_no_err = $class_err = $basic_err = $bonus_err = $sal_month_err = $paid_status_err = $payPerhour_err = '';

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

  if (empty(trim($_POST['acct_no'])))
  {
    $acct_no_err = "Please enter account no.";
  }
  else
  {
    $acct_no = trim($_POST['acct_no']);
  }

  if (empty(trim($_POST['class'])))
  {
    $class_err = "Please enter salary class.";
  }
  else
  {
    $class = trim($_POST['class']);
  }

  if (empty(trim($_POST['basic'])))
  {
    $basic_err = "Please enter basic salary.";
  }
  else
  {
    $basic = trim($_POST['basic']);
  }

  $bonus = trim($_POST['bonus']);

  if (empty($_POST['sal_month']))
  {
    $sal_month_err = "Please select salary month.";
  }
  else
  {
    $sal_month = $_POST['sal_month'];
  }

  if (empty(trim($_POST['paid'])))
  {
    $paid_status_err = "Please enter amount paid.";
  }
  else
  {
    $paid_status = trim($_POST['paid']);
  }

  if (empty(trim($_POST['pay_per'])))
  {
    $payPerhour_err = "Please enter payperhour.";
  }
  else
  {
    $payPerhour = trim($_POST['pay_per']);
  }

  if (empty($emp_id_err) && empty($class_err) && empty($acct_no_err) && empty($basic_err) && empty($sal_month_err) && empty($paid_status_err) && empty($payPerhour_err))
  {
    $sql = oci_parse($conn,"insert into SALARY (SALARY_ID, ACCT_NO, CLASS, BASIC, BONUS, SAL_MONTH, PAID_STATUS, PAYPERHOUR) VALUES 
                                                        (SALARY_SALARY_ID_SEQ.nextval,'$acct_no','$class','$basic','$bonus','$sal_month','$paid_status','$payPerhour')");

    if (!$sql)
    {
      echo oci_error($sql);
    }

    $rs = oci_execute($sql);

    if (!$rs)
    {
      echo oci_error($rs);
    }

    $sql = oci_parse($conn,"insert into HASSALARY (EMP_ID, SALARY_ID) VALUES ('$emp_id',SALARY_SALARY_ID_SEQ.currval)");
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
  <title>Salary Form</title>
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

    <div class="form-group <?php echo (!empty($acct_no_err)) ? 'has-error' : ''; ?>">
      <label>ACCOUNT NO</label>
      <input type="text" name="acct_no"class="form-control input-sm" value="<?php echo $acct_no; ?>">
      <span class="help-block"><?php echo $acct_no_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($class_err)) ? 'has-error' : ''; ?>">
      <label>CLASS</label>
      <input type="text" name="class"class="form-control input-sm" value="<?php echo $class; ?>">
      <span class="help-block"><?php echo $class_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($basic_err)) ? 'has-error' : ''; ?>">
      <label>BASIC</label>
      <input type="text" name="basic"class="form-control input-sm" value="<?php echo $basic; ?>">
      <span class="help-block"><?php echo $basic_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($bonus_err)) ? 'has-error' : ''; ?>">
      <label>BONUS</label>
      <input type="text" name="bonus"class="form-control input-sm" value="<?php echo $bonus; ?>">
      <span class="help-block"><?php echo $bonus_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($sal_month_err)) ? 'has-error' : ''; ?>">
      <label>SELECT MONTH:</label>
      <select name="sal_month" class="form-control">

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
      <span class="help-block"><?php echo $sal_month_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($paid_status_err)) ? 'has-error' : ''; ?>">
      <label>PAID AMOUNT</label>
      <input type="text" name="paid"class="form-control input-sm" value="<?php echo $paid_status; ?>">
      <span class="help-block"><?php echo $paid_status_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($payPerhour_err)) ? 'has-error' : ''; ?>">
      <label>PAYPERHOUR</label>
      <input type="text" name="pay_per"class="form-control input-sm" value="<?php echo $payPerhour; ?>">
      <span class="help-block"><?php echo $payPerhour_err; ?></span>
    </div>


    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>
