<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 4/20/2018
 * Time: 8:21 PM
 */

include "../config.php";

$rows = 0;
$username = $password = $confirm_password = $check = $check_user = $user_role = "";
$username_err = $password_err = $confirm_password_err =  $user_role_err = "";

// validate username
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $check = trim($_POST["username"]);
        $srt = "SELECT * from users where USER_NAME = '$check'";

        $sql = oci_parse($conn, $srt);
        if (!$sql) {
            echo "error";
        }

        $rs = oci_execute($sql);

        oci_fetch($sql);
        $rows = oci_num_rows($sql);

        if ($rs) {
                        if ($rows == 1) {
                $username_err = "This username is already taken";
            } else {
                $username = trim($_POST["username"]);
                $check = "";
            }
        } else {
            echo "Oops! Something went wrong.";
        }

        oci_free_statement($sql);

    }


//validate password

    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST['password'])) < 4) {
        $password_err = "Password must have at least 4 character.";
    } else {
        $password = trim($_POST['password']);
    }


//validate confirm_password

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = "Password does not match.";
        }
    }
//validate role
    if (empty($_POST['role']))
    {
        $user_role_err = "please enter user role.";
    }
    else
    {
        $user_role = strtoupper($_POST['role']);
    }

//check input error before inserting

    if (empty($username_err) && empty($user_role_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = oci_parse($conn, "INSERT INTO USERS (USER_NAME, USER_PASSWORD, USER_ROLE) VALUES (:bname,:bpass,:brole)");
        if (!$sql) {
            echo "error";
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        oci_bind_by_name($sql, ":bname", $username);
        oci_bind_by_name($sql, ":bpass", $password);
        oci_bind_by_name($sql, ":brole", $user_role);

        $rs = oci_execute($sql);

        if (!$rs) {
          echo "Something went wrong. PLease try again later.";
        }
        else
        {
            header("location: ../admin/index.php");
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
    <title>SIGN UP</title>
</head>
<body>

<nav class="navbar navbar-inverse">

    <div class="container-fluid">

        <ul class="nav navbar-nav">

            <li><a href="../admin/index.php" class="glyphicon glyphicon-home">HOME</a> </li>

        </ul>

        <ul class="nav navbar-nav navbar-right">

            <li><a href="logout.php">Logout</a> </li>

        </ul>

    </div>

</nav>

<div class="wrapper">

    <h2>Sign Up</h2>
    <p>Please fill this form to create an account.</p>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>


        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>



        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>

        <div class="form-group <?php echo (!empty($user_role_err)) ? 'has-error' : ''; ?>">
            <label>Select User Role:</label>
            <select name="role" class="form-control">

                <option></option>
                <option>USER</option>
                <option>ADMIN</option>

            </select>
            <span class="help-block"><?php echo $user_role_err; ?></span>
        </div>



        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>


<!--        <p>Already have an account? <a href="login.php">Login here</a>.</p>-->
    </form>
</div>

</body>
</html>



