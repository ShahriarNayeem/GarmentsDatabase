<?php

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ../login/login.php");
  exit;
}
?>

    

        <!-- Navigation -->
        <!-- nav -->

        <?php

            include '../nav/nav_admin.php';

        ?>

       
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ADMIN PAGE</h1>
                    <h2>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to our site.</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        
<?php

include '../nav/nav_footer.php';
?>