<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/25/2018
 * Time: 12:48 AM
 */
$emp_id = $nom_name = $nom_nid = $relation =  $nom_phone = $nom_rank = '';
$emp_id_err = $nom_name_err = $nom_nid_err = $relation_err =  $nom_phone_err = $nom_rank_err = '';

require "../config.php";

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST['emp_id']))) {
    $emp_id_err = "Please enter user id.";
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
// validate name
  if (empty(trim($_POST['nom_name'])))
  {
    $nom_name_err = "Please enter nominee name.";
  }
  else
  {
    $nom_name = trim($_POST['nom_name']);
  }
 //validate nid

  if (!preg_match("/^[0-9]*$/",$_POST['nom_nid']))
  {
    $nom_nid_err = "Can not contain letter.";
  }
  else
  {
    $nom_nid = $_POST['nom_nid'];
  }
  //validate relation

  if (empty(trim($_POST['relation'])))
  {
    $relation_err = "Please enter nominee relation.";
  }
  else
  {
    $relation = trim($_POST['relation']);
  }

  //validate phone number
  if (empty($_POST['nom_phone']))
  {
    $nom_phone_err = "Please enter nominee phone no.";
  }
  else {
    if (strlen(trim($_POST['nom_phone'])) > 14) {
      $nom_phone_err = "Please check your Phone Number.";
    } else {
      $nom_phone = trim($_POST['nom_phone']);
    }
  }
//validate rank
  if (empty(trim($_POST['nom_rank'])))
  {
    $nom_rank_err = "Please enter nominee rank.";
  }
  else
  {
    $nom_rank = trim($_POST['nom_rank']);
  }

  if (empty($emp_id_err) && empty($nom_rank_err) && empty($nom_phone_err) && empty($nom_nid_err) && empty($relation_err) && empty($nom_name_err))
  {
    $sql = oci_parse($conn,"insert into NOMINEE (EMP_ID, NOM_NID_NO, NOM_NAME, RELATION, NOM_PHONE_NO, NOM_RANK) VALUES (:bid,:bnid,:bname,:brelation,:bphone,:brank)");
    if (!$sql)
    {
      echo oci_error($sql);
    }

    oci_bind_by_name($sql,":bid",$emp_id);
    oci_bind_by_name($sql,":bnid",$nom_nid);
    oci_bind_by_name($sql,":bname",$nom_name);
    oci_bind_by_name($sql,":brelation",$relation);
    oci_bind_by_name($sql,":bphone",$nom_phone);
    oci_bind_by_name($sql,":brank",$nom_rank);

    $rs = oci_execute($sql);
    if ($rs) {
      header("location: nominee.php");
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
  <title>USER Nominee Form</title>
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

    <div class="form-group <?php echo (!empty($nom_name_err)) ? 'has-error' : ''; ?>">
      <label>NOMINEE NAME</label>
      <input type="text" name="nom_name"class="form-control input-sm" value="<?php echo $nom_name; ?>">
      <span class="help-block"><?php echo $nom_name_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($nom_nid_err)) ? 'has-error' : ''; ?>">
      <label>NOMINEE NID</label>
      <input type="text" name="nom_nid"class="form-control input-sm" value="<?php echo $nom_nid; ?>">
      <span class="help-block"><?php echo $nom_nid_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($relation_err)) ? 'has-error' : ''; ?>">
      <label>NOMINEE RELATION</label>
      <input type="text" name="relation"class="form-control input-sm" value="<?php echo $relation; ?>">
      <span class="help-block"><?php echo $relation_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($nom_phone_err)) ? 'has-error' : ''; ?>">
      <label>PHONE NUMBER</label>
      <input type="text" name="nom_phone"class="form-control input-sm" value="<?php echo $nom_phone; ?>" placeholder="+880xxxxxxxxxx">
      <span class="help-block"><?php echo $nom_phone_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($nom_rank_err)) ? 'has-error' : ''; ?>">
      <label>RANK</label>
      <input type="text" name="nom_rank"class="form-control input-sm" value="<?php echo $nom_rank; ?>">
      <span class="help-block"><?php echo $nom_rank_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="ADD">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>

</div>

</body>
</html>

