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

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

    	<nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">

            <ul class="nav navbar-top-links navbar-left">
                <!-- /.dropdown -->
                <li>
                    <a href="../admin/index.php"><i class="fa fa-home fa-fw"></i> HOME</a>
                </li>

                <li>
                    <a href="../login/register.php">AddNewUser</a>
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

                            <a href="#"><i class="fa-fw"></i>Update<span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../update/retirement.php">Retirement</a>
                                </li>
                            </ul>

                        </li>


                        <li>

                            <a href="#"><i class="fa-fw"></i>Search<span class="fa arrow"></span></a>

                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../search.php">Search by ID</a>
                                </li>
                            </ul>

                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../search_name.php">Search by NAME</a>
                                </li>
                            </ul>


                        </li>

                        <li>
                            <a href="#"><i class="fa-fw"></i>Personal Information<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../view/viewPersonal.php">Information</a>
                                </li>

                                <li>
                                    <a href="../view/phoneNo.php">Phone Number</a>
                                </li>

                                <li>
                                    <a href="../view/nominee.php">Nominee</a>
                                </li>

                                <li>
                                    <a href="../view/address.php">Address</a>
                                </li>

                                <li>
                                    <a href="../view/family.php">Family</a>
                                </li>

                                
                                <li>
                                    <a href="../view/education.php">Education</a>
                                </li>
                            
                                <li>
                                    <a href="../view/emergencyContact.php">Emergency Contact</a>
                                </li>
                           
                                <li>
                                    <a href="../view/medicalinfo.php">Medical</a>
                                </li>
                        
                                <li>
                                    <a href="../view/experience.php">Previous Experience</a>
                                </li>
                           
                                <li>
                                    <a href="../view/leave.php">Leave</a>
                                </li>
                 
                                <li>
                                    <a href="../view/department.php">Department</a>
                                </li>
                           



                            </ul>

                        </li>

                        <li>
                            <a href="#"><i class="fa-fw"></i>DATA ENTRY<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../input/personal_info.php">Personal Information</a>
                                </li>
                            
                                <li>
                                    <a href="../input/phoneNo.php">Phone NO</a>
                                </li>
                            
                                <li>
                                    <a href="../input/nominee.php">Nominee</a>
                                </li>
                            
                                <li>
                                    <a href="../input/address.php">Contact Address</a>
                                </li>
                            
                                <li>
                                    <a href="../input/family.php">Family Info</a>
                                </li>
                            
                                <li>
                                    <a href="../input/education.php">Education</a>
                                </li>
                            
                                <li>
                                    <a href="../input/emergencyContact.php">Emergency Contact</a>
                                </li>
                            
                                <li>
                                    <a href="../input/workHour.php">Workhour</a>
                                </li>
                            
                                <li>
                                    <a href="../input/medicalinfo.php">Medical Information</a>
                                </li>
                            
                                <li>
                                    <a href="../input/vaccine.php">Vaccination</a>
                                </li>
                            
                                <li>
                                    <a href="../input/experience.php">Previous Experience</a>
                                </li>
                            
                                <li>
                                    <a href="../input/department.php">Department</a>
                                </li>
                            
                                <li>
                                    <a href="../input/leave.php">Leave</a>
                                </li>
                            
                                <li>
                                    <a href="../input/salary.php">Salary</a>
                                </li>
                            
                                <li>
                                    <a href="../input/policeVerification.php">Police verify</a>
                                </li>
                            
                                <li>
                                    <a href="../input/performance.php">Performance</a>
                                </li>
                            </ul>


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


                        <li>
                            <a href="#"><i class="fa-fw"></i> Download<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="../download/down_leave.php">Download leave form</a>
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