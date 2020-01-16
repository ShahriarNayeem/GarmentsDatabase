<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 5/1/2018
 * Time: 10:37 PM
 */

include "../config.php";

$rows = 0;
$emp_id = $emp_name = $emp_dob = $designation = $joining_date = $email_id = $religion = $marital_status = $nid_no = $blood_group = $nationality = "";
$emp_id_err = $emp_name_err = $emp_dob_err = $designation_err = $joining_date_err = $email_id_err = $religion_err = $marital_status_err = $nid_no_err = $blood_group_err = $nationality_err = "";

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST['emp_id'])))
    {
        $emp_id_err = "Please enter id.";
    }
    else
    {
        $emp_id = trim($_POST['emp_id']);
        $sql = oci_parse($conn,"select * from EMPLOYEE where EMP_ID = '$emp_id'");
        if (!$sql)
        {
            echo "error";
        }

        $rs = oci_execute($sql);
        oci_fetch($sql);

        $rows = oci_num_rows($sql);

        if ($rs)
        {
          if ($rows == 1)
          {
            $emp_id_err = "ID is already taken.";
          }
          else
          {
            $emp_id = trim($_POST['emp_id']);
          }
        }
        else
        {
            echo "Something went wrong.Please try again later.";
        }

        oci_free_statement($sql);
    }

    //validate name

    if (empty(trim($_POST['emp_name'])))
    {
        $emp_name_err = "Please enter your name.";
    }
    else
    {
        $emp_name = trim($_POST['emp_name']);
    }

    //validate dob

    if (empty(trim($_POST['emp_dob'])))
    {

        $emp_dob_err = "Please enter date of birth.";
    }
    else
    {
        $emp_dob = trim($_POST['emp_dob']);
    }

    // validate designation

    if (empty(trim($_POST['designation'])))
    {
        $designation_err = "Please enter designation.";
    }
    else
    {
        $designation = trim($_POST['designation']);
    }

    // validate joining date

    if (empty(trim($_POST['joining_date'])))
    {
        $joining_date_err = "Please enter your joining date.";
    }
    else
    {
        $joining_date = trim($_POST['joining_date']);
    }

    //validate email

    if (!filter_var(trim($_POST['email_id']),FILTER_VALIDATE_EMAIL))
    {
        $email_id_err = "Invalid email format.";
    }
    else
    {
        $email_id = $_POST['email_id'];
    }

    //validate religion

    if (empty($_POST['religion']))
    {
        $religion_err = "Please enter your religion.";
    }
    else
    {
        $religion = $_POST['religion'];
    }

    //validate marital status

    if (empty($_POST['marital_status']))
    {
        $marital_status_err = "Please enter your marital status.";
    }
    else
    {
        $marital_status = $_POST['marital_status'];
    }

    // validate nid

    if (!preg_match("/^[0-9]*$/",$_POST['nid_no']))
    {
        $nid_no_err = "Can not contain letter.";
    }
    else
    {
        $nid_no = $_POST['nid_no'];
    }

    //validate blood group

    if (empty(trim($_POST['blood_group'])))
    {
        $blood_group_err = "Please enter your blood group.";
    }
    else
    {
        $blood_group = trim($_POST['blood_group']);
    }

    //validate nationality

    if (empty(trim($_POST['nationality'])))
    {
        $nationality_err = "Please enter your nationality.";
    }
    else
    {
        $nationality = $_POST['nationality'];
    }

    // sql insert

    if (empty($emp_id_err) && empty($emp_name_err) && empty($emp_dob_err) && empty($designation_err) && empty($joining_date_err) && empty($email_id_err) && empty($religion_err) && empty($marital_status_err) && empty($nid_no_err) && empty($blood_group_err) && empty($nationality_err))
    {
        $sql = oci_parse($conn,"insert into EMPLOYEE(EMP_ID, EMP_NAME, EMP_DOB, DESIGNATION, JOINING_DATE, EMAIL_ID, RELIGION, MARITAL_STATUS, EMP_NID_NO, BLOOD_GROUP, NATIONALITY) 
                                                    values (:bid,:bname,to_date('$emp_dob','DD-MM-YYYY'),:bdesig,to_date('$joining_date','DD-MM-YYYY'),:bemail,:breligion,:bstatus,:bnid,:bblood,:bnation)");
        if (!$sql)
        {
            echo "error";
        }

        oci_bind_by_name($sql,":bid",$emp_id);
        oci_bind_by_name($sql,":bname",$emp_name);
        oci_bind_by_name($sql,":bdesig",$designation);
        oci_bind_by_name($sql,":bemail",$email_id);
        oci_bind_by_name($sql,":breligion",$religion);
        oci_bind_by_name($sql,":bstatus",$marital_status);
        oci_bind_by_name($sql,":bnid",$nid_no);
        oci_bind_by_name($sql,":bblood",$blood_group);
        oci_bind_by_name($sql,":bnation",$nationality);

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
    <title>Personal Info</title>
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

            <div class="form-group <?php echo (!empty($emp_name_err)) ? 'has-error' : ''; ?>">
                <label>NAME</label>
                <input type="text" name="emp_name"class="form-control input-sm" value="<?php echo $emp_name; ?>">
                <span class="help-block"><?php echo $emp_name_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($emp_dob_err)) ? 'has-error' : ''; ?>">
                <label>DATE OF BIRTH</label>
                <input type="text" name="emp_dob"class="form-control input-sm" value="<?php echo $emp_dob; ?>" placeholder="DD-MM-YYYY">
                <span class="help-block"><?php echo $emp_dob_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($designation_err)) ? 'has-error' : ''; ?>">
                <label>DESIGNATION</label>
                <input type="text" name="designation"class="form-control input-sm" value="<?php echo $designation; ?>">
                <span class="help-block"><?php echo $designation_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($joining_date_err)) ? 'has-error' : ''; ?>">
                <label>JOINING DATE</label>
                <input type="text" name="joining_date"class="form-control input-sm" value="<?php echo $joining_date; ?>" placeholder="DD-MM-YYYY">
                <span class="help-block"><?php echo $joining_date_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($email_id_err)) ? 'has-error' : ''; ?>">
                <label>EMAIL</label>
                <input type="text" name="email_id"class="form-control input-sm" value="<?php echo $email_id; ?>">
                <span class="help-block"><?php echo $email_id_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($religion_err)) ? 'has-error' : ''; ?>">
                <label>RELIGION</label>
                <input type="text" name="religion"class="form-control input-sm" value="<?php echo $religion; ?>">
                <span class="help-block"><?php echo $religion_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($marital_status_err)) ? 'has-error' : ''; ?>">
                <label>MARITAL STATUS</label>
                <input type="text" name="marital_status"class="form-control input-sm" value="<?php echo $marital_status; ?>">
                <span class="help-block"><?php echo $marital_status_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($nid_no_err)) ? 'has-error' : ''; ?>">
                <label>NID NO</label>
                <input type="text" name="nid_no"class="form-control input-sm" value="<?php echo $nid_no; ?>">
                <span class="help-block"><?php echo $nid_no_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($blood_group_err)) ? 'has-error' : ''; ?>">
                <label>BLOOD GROUP</label>
                <input type="text" name="blood_group"class="form-control input-sm" value="<?php echo $blood_group; ?>">
                <span class="help-block"><?php echo $blood_group_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($nationality_err)) ? 'has-error' : ''; ?>">
                <label>NATIONALITY</label>
                <input type="text" name="nationality"class="form-control input-sm" value="<?php echo $nationality; ?>">
                <span class="help-block"><?php echo $nationality_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>

        </form>

    </div>
</div>

</body>
</html>
