<?php
/**
 * Created by PhpStorm.
 * User: Shahriar
 * Date: 4/21/2018
 * Time: 1:24 AM
 */
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo htmlspecialchars($_SESSION['username'])?></title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">

        <ul class="nav navbar-top-links navbar-left">
            <!-- /.dropdown -->
            <li>
                <a href="index.php"><i class="fa fa-home fa-fw"></i> HOME</a>
            </li>

        </ul>


        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="../login/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="#"><i class="fa-fw"></i>Personal Information<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/viewPersonal.php">Personal Information</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/phoneNo.php">Phone Number</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/nominee.php">Nominee</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/address.php">Address</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/family.php">Family</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/education.php">Education</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/emergencyContact.php">Emergency Contact</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/medicalinfo.php">Medical</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/experience.php">Previous Experience</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/leave.php">Leave</a>
                            </li>
                        </ul>

                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../view/department.php">Department</a>
                            </li>
                        </ul>
                    </li>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa-fw"></i> Reset<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="changePassandAnswer.php">Password and Answer</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">USER PAGE</h1>
                <h2>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to our site.</h2>
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>