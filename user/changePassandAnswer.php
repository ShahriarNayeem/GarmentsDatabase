<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 4/20/2018
 * Time: 10:27 PM
 */

include "../config.php";


session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}

$row1 = 0;

$username = $user_pass = $confirm_pass = $answer = "";
$user_pass_err = $confirm_pass_err = $answer_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['username'];

    $sql = oci_parse($conn, "SELECT * FROM USERS where USER_NAME = '$username'");

    if (!$sql) {
      echo "error";
    }

    $rs = oci_execute($sql);
    oci_fetch($sql);
    $row1 = oci_num_rows($sql);

    if ($rs) {
      if ($row1 != 1) {
        echo $username_err = "No account found with that username.";
      }
    } else {
      echo "Oops! Something went wrong.Please Try again later.";
    }

  if (empty(trim($_POST['password']))) {
    $user_pass_err = "Please enter a password.";
  } elseif (strlen(trim($_POST['password'])) < 4) {
    $user_pass_err = "Password has to minimum 4 characters.";
  } else {
    $user_pass = trim($_POST['password']);
  }

  if (empty(trim($_POST["confirm_pass"]))) {
    $confirm_pass_err = "Please confirm password.";
  } else {
    $confirm_pass = trim($_POST['confirm_pass']);
    if ($user_pass != $confirm_pass) {
      $confirm_pass_err = "Password does not match.";
    }
  }

  if (empty(trim($_POST['answer'])))
  {
    $answer_err = "please enter a answer.";
  }
  else
  {
    $answer = strtoupper(trim($_POST['answer']));
  }

  if (empty($username_err) && empty($confirm_pass_err) && empty($user_pass_err) && empty($answer_err))
  {
    $sql = oci_parse($conn, "update users set USER_PASSWORD=:bpass, USER_ANSWER=:banswer where USER_NAME=:bname");

    if (!$sql) {
      echo "error";
    }

    $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);

    oci_bind_by_name($sql,"bname",$username);
    oci_bind_by_name($sql,"bpass",$user_pass);
    oci_bind_by_name($sql,"banswer",$answer);

    $rs = oci_execute($sql);

    if ($rs) {
      header("location: ../login/login.php");
    } else {
      echo "Something went wrong. Please try again later.";
    }
  }

  oci_free_statement($sql);
}
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <style type="text/css">
    body{ font: 14px sans-serif; }
    .wrapper{ width: 350px; padding: 20px; }
  </style>
</head>
<body>

<nav class="navbar navbar-inverse">

    <div class="container-fluid">

        <ul class="nav navbar-nav">

            <li><a href="../user/index.php" class="glyphicon glyphicon-home">HOME</a> </li>

        </ul>

        <ul class="nav navbar-nav navbar-right">

            <li><a href="../login/logout.php">Logout</a> </li>

        </ul>

    </div>

</nav>

<div class="wrapper">

  <h2>Password and Answer Reset Form</h2>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="form-group <?php echo (!empty($user_pass_err)) ? 'has-error' : ''; ?>">
      <label>New Password</label>
      <input type="password" name="password"class="form-control">
      <span class="help-block"><?php echo $user_pass_err; ?></span>
    </div>

    <div class="form-group <?php echo (!empty($confirm_pass_err)) ? 'has-error' : ''; ?>">
      <label>Confirm New Password</label>
      <input type="password" name="confirm_pass"class="form-control">
      <span class="help-block"><?php echo $confirm_pass_err; ?></span>
    </div>

    <p><span style="color: #2aabd2;">Security Question : </span> What is your favourite color?</p>

    <div class="form-group <?php echo (!empty($answer_err)) ? 'has-error' : ''; ?>">
      <label>New Answer</label>
      <input type="text" name="answer" class="form-control" value="<?php echo $answer; ?>">
      <span class="help-block"><?php echo $answer_err; ?></span>
    </div>

    <div class="form-group">
      <input type="submit" class="btn btn-primary" value="Submit">
      <input type="reset" class="btn btn-default" value="Reset">
    </div>

  </form>
</div>
</body>
</html>
