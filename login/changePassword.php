<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 4/20/2018
 * Time: 10:27 PM
 */

include "../config.php";

$row1 = 0;

$username = $user_pass = $confirm_pass = $answer = $check_answer = "";
$username_err = $user_pass_err = $confirm_pass_err = $answer_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username";
  } else {
    $username = trim($_POST["username"]);

    $sql = oci_parse($conn, "SELECT * FROM USERS where USER_NAME = '$username'");

    if (!$sql) {
      echo "error";
    }

    $rs = oci_execute($sql);
    oci_fetch($sql);
    $row1 = oci_num_rows($sql);

    $check_answer = oci_result($sql,'USER_ANSWER');

    if ($rs) {
      if ($row1 != 1) {
        echo $username_err = "No account found with that username.";
      }
    } else {
      echo "Oops! Something went wrong.Please Try again later.";
    }
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

  $answer = strtoupper(trim($_POST['answer']));

  if (empty(trim($_POST['answer'])))
  {
    $answer_err = "please enter a answer.";
  }
  elseif($answer != $check_answer)
  {
    $answer_err = "Your answer did not match.";
  }
  else
  {
      $answer_err = "";
  }
    if (empty($username_err) && empty($confirm_pass_err) && empty($user_pass_err) && empty($answer_err))
    {
      $sql = oci_parse($conn, "update users set USER_PASSWORD=:bpass where USER_NAME=:bname");

      if (!$sql) {
        echo "error";
      }

      $user_pass = password_hash($user_pass, PASSWORD_DEFAULT);

      oci_bind_by_name($sql,"bname",$username);
      oci_bind_by_name($sql,"bpass",$user_pass);

      $rs = oci_execute($sql);

      if ($rs) {
        header("location: login.php");
      } else {
        echo "Something went wrong. Please try again later.";
      }
    }

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
<div class="wrapper">

    <h2>Reset Form</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>

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
            <label>Answer</label>
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
