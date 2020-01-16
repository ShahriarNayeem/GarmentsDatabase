<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 1:46 AM
 */

require "../config.php";

$emp_id = $name = $flat_appr_no = $house_buld_no = $road_no = $area_name = $post_office = $police_station = $district = $phoneNo = '';
$emp_id_err = $name_err = $flat_appr_no_err = $house_buld_no_err = $road_no_err = $area_name_err = $post_office_err = $police_station_err = $district_err = $phoneNo_err = '';

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

  if (empty(trim($_POST['cname']))) {
    $name_err = "Please enter person name.";
  } else {
    $name = strtoupper(trim($_POST['cname']));
  }

  $flat_appr_no = trim($_POST['flat']);
  $house_buld_no = trim($_POST['house']);
  $road_no = trim($_POST['road']);

  if (empty(trim($_POST['area']))) {
    $area_name_err = 'Please enter your area name.';
  } else {
    $area_name = trim($_POST['area']);
  }

  if (empty(trim($_POST['po']))) {
    $post_office_err = "Please enter your post office.";
  } else {
    $post_office = trim($_POST['po']);
  }

  if (empty(trim($_POST['ps']))) {
    $police_station_err = "Please enter your police station.";
  } else {
    $police_station = trim($_POST['ps']);
  }

  if (empty(trim($_POST['district']))) {
    $district_err = "Please enter your district name.";
  } else {
    $district = trim($_POST['district']);
  }

  if (empty(trim($_POST['phone']))) {
    $phoneNo_err = "Please enter phone number.";
  }
  elseif(strlen(trim($_POST['phone'])) != 14){
    $phoneNo_err = "Please check your number.";
  }
  else {
    $phoneNo = trim($_POST['phone']);
  }



  if (empty($emp_id_err) && empty($name_err) && empty($area_name_err) && empty($police_station_err) && empty($post_office_err) && empty($district_err) && empty($phoneNo_err)) {

    $sql = oci_parse($conn, "insert into EMERGENCYCONTACT(EMP_ID, CNAME, CFLAT_APPR_NO, CHOUSE_BULD_NO, CROAD_NO, CAREA_NAME, CPOST_OFFICE, CPOLICE_STATION, CDISTRICT, CPHONE_NO) 
                                                      VALUES 
                                                      (:bid,:bname,:bflat,:bhouse,:broad,:barea,:bpo,:bps,:bdistrict,:bphone)");

    if (!$sql) {
      echo oci_error($sql);
    }

    oci_bind_by_name($sql, ":bid", $emp_id);
    oci_bind_by_name($sql, ":bname", $name);
    oci_bind_by_name($sql, ":bflat", $flat_appr_no);
    oci_bind_by_name($sql, ":bhouse", $house_buld_no);
    oci_bind_by_name($sql, ":broad", $road_no);
    oci_bind_by_name($sql, ":barea", $area_name);
    oci_bind_by_name($sql, ":bpo", $post_office);
    oci_bind_by_name($sql, ":bps", $police_station);
    oci_bind_by_name($sql, ":bdistrict", $district);
    oci_bind_by_name($sql, ":bphone", $phoneNo);

    $rs = oci_execute($sql);

    if ($rs) {
      header("location: ../admin/index.php");
    } else {
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
  <title>User Address Form</title>
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

    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
      <label>NAME</label>
      <input type="text" name="cname"class="form-control input-sm" value="<?php echo $name; ?>">
      <span class="help-block"><?php echo $name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($flat_appr_no_erra)) ? 'has-error' : ''; ?>">
      <label>FLAT NO</label>
      <input type="text" name="flat"class="form-control input-sm" value="<?php echo $flat_appr_no; ?>">
      <span class="help-block"><?php echo $flat_appr_no_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($house_buld_no_err)) ? 'has-error' : ''; ?>">
      <label>HOUSE NO</label>
      <input type="text" name="house"class="form-control input-sm" value="<?php echo $house_buld_no; ?>">
      <span class="help-block"><?php echo $house_buld_no_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($road_no_err)) ? 'has-error' : ''; ?>">
      <label>ROAD NO</label>
      <input type="text" name="road"class="form-control input-sm" value="<?php echo $road_no; ?>">
      <span class="help-block"><?php echo $road_no_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($area_name_err)) ? 'has-error' : ''; ?>">
      <label>AREA NAME</label>
      <input type="text" name="area"class="form-control input-sm" value="<?php echo $area_name; ?>">
      <span class="help-block"><?php echo $area_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($post_office_err)) ? 'has-error' : ''; ?>">
      <label>POST OFFICE</label>
      <input type="text" name="po"class="form-control input-sm" value="<?php echo $post_office; ?>">
      <span class="help-block"><?php echo $post_office_err; ?></span>
    </div>


    <div class="form-group <?php echo (!empty($police_station_err)) ? 'has-error' : ''; ?>">
      <label>POLICE STATION</label>
      <input type="text" name="ps"class="form-control input-sm" value="<?php echo $police_station; ?>">
      <span class="help-block"><?php echo $police_station_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($district)) ? 'has-error' : ''; ?>">
      <label>DISTRICT</label>
      <input type="text" name="district"class="form-control input-sm" value="<?php echo $district; ?>">
      <span class="help-block"><?php echo $district_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($phoneNo_err)) ? 'has-error' : ''; ?>">
      <label>PHONE NUMBER</label>
      <input type="text" name="phone"class="form-control input-sm" value="<?php echo $phoneNo; ?>">
      <span class="help-block"><?php echo $phoneNo_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

