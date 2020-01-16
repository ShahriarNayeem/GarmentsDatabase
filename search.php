<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/26/2018
 * Time: 12:25 PM
 */

$emp_id = $search_item = '';
$emp_id_err = $search_item_err = '';

require "config.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST['emp_id']))) {
    $emp_id_err = "Please enter user id.";
  } else {
    $emp_id = trim($_POST['emp_id']);
    $sql = oci_parse($conn, "select * from USERS where USER_NAME = '$emp_id'");
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

  $_SESSION['search'] = $emp_id;

  if (empty($_POST['post']))
  {
      $search_item_err = "Please select an item.";
  }
  else
  {
      $search_item = $_POST['post'];
  }

  if (empty($emp_id_err) && empty($search_item_err))
  {
    if (strtoupper($search_item) == strtoupper("Performance"))
    {
      header("location: search/perform.php");
    }
    elseif (strtoupper($search_item) == strtoupper("PoliceVerify"))
    {
        header("location: search/policeVerify.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Login"))
    {
      header("location: search/login.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Address"))
    {
      header("location: search/address.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Department"))
    {
      header("location: search/department.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Education"))
    {
      header("location: search/education.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Emergency"))
    {
      header("location: search/emergencyContact.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Experience"))
    {
      header("location: search/experience.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Family"))
    {
      header("location: search/family.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Leave"))
    {
      header("location: search/leave.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Medical"))
    {
      header("location: search/medicalinfo.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Nominee"))
    {
      header("location: search/nominee.php");
    }
    elseif (strtoupper($search_item) == strtoupper("PhoneNO"))
    {
      header("location: search/phoneNo.php");
    }
    elseif (strtoupper($search_item) == strtoupper("Personal"))
    {
      header("location: search/viewPersonal.php");
    }
  }
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <style type="text/css">
    body
    {font: 14px sans-serif;}

    .wrapper
    {width: 350px; padding: 20px;}
  </style>
  <title>Search Form</title>
</head>
<body>

<nav class="navbar navbar-inverse">

  <div class="container-fluid">

    <ul class="nav navbar-nav">

      <li><a href="admin/index.php" class="glyphicon glyphicon-home">HOME</a> </li>

    </ul>

    <ul class="nav navbar-nav navbar-right">

      <li><a href="login/logout.php">Logout</a> </li>

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


      <div class="form-group <?php echo (!empty($search_item_err)) ? 'has-error' : ''; ?>">
          <label>SELECT SEARCH ITEM:</label>
          <select name="post" class="form-control">

              <option></option>
              <option>PERFORMANCE</option>
              <option>POLICEVERIFY</option>
              <option>LOGIN</option>
              <option>ADDRESS</option>
              <option>DEPARTMENT</option>
              <option>EDUCATION</option>
              <option>EMERGENCY</option>
              <option>EXPERIENCE</option>
              <option>FAMILY</option>
              <option>LEAVE</option>
              <option>MEDICAL</option>
              <option>NOMINEE</option>
              <option>PHONENO</option>
              <option>PERSONAL</option>

          </select>
          <span class="help-block"><?php echo $search_item_err; ?></span>
      </div>


    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="SEARCH">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>
