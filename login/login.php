<?php


//connet to the database
include "../config.php";

$row1 = 0;

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //error chacking for empty
    if (empty($_POST['username']))
    {
        $username_err = "Please enter username";
    }
    else
    {
        $username = trim($_POST['username']);
    }

    if (empty($_POST['password']))
    {
        $password_err = "Please enter password.";
    }
    else
    {
        $password = trim($_POST['password']);
    }

    $sql = oci_parse($conn,"SELECT * FROM USERS where USER_NAME = '$username'");
    if (!$sql)
    {
        echo "error";
    }

    $rs = oci_execute($sql);
    oci_fetch($sql);
    $row1 = oci_num_rows($sql);

    if ($rs)
    {
        if ($row1 == 1)
        {
            if (password_verify($password,oci_result($sql,'USER_PASSWORD')) || password_verify($password,password_hash(oci_result($sql,'USER_PASSWORD'),PASSWORD_DEFAULT)))
            {
                if (oci_result($sql,'USER_ROLE') == 'ADMIN')
                {
                    session_start();
                    $_SESSION['username'] = $username;
                    // $_SESSION['role'] = oci_result($sql,'USER_ROLE');
                    //header("location: profile.php");
                  header("location: ../admin/index.php");
                }
                else
                {
                    session_start();
                    $_SESSION['username'] = $username;
                       // $_SESSION['role'] = oci_result($sql,'USER_ROLE');
                   // header("location: welcome.php");
                  header("location: ../user/index.php");
                }

            }
            else
            {
                $password_err = "The password you entered was not valid.";
            }
        }
        else
        {
            $username_err = "No account found with that username.";
        }
    }
    else
    {
        echo "Oops! Something went wrong.Please Try again later.";
    }

    oci_free_statement($sql);
    oci_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.min.css">
		<style type="text/css">
			body{ font: 14px sans-serif; }
			.wrapper{ width: 350px; padding: 20px;margin-top: 100px }
		</style>
	</head>
	
	<body>

        <center>

            <div class="wrapper">
                <h2>Login</h2>
                    <p>Please fill in your credentials to login.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                            <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                        <!--<p>Don't have an account? <a href="register.php">Sign up now</a>.</p>-->
                        <p><a href="changePassword.php" class="btn btn-primary">Forget Password</a>.</p>
                    </form>
            </div>
            
        </center>



		
	</body>
</html>
