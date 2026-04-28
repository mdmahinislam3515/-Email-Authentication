<?php 
session_start(); 

if(isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "YOU ARE ALREADY LOGGED IN";
    header("Location: dashboard.php");
    exit(0);
}

$page_title = "Login"; 
include('includes/header.php'); 
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <?php
                if(isset($_SESSION['status']))
                {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                    <?php
                    unset($_SESSION['status']);
                }
                ?>

                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                           
                            <div class="form-group mb-3">
                                <button type="submit" name="login_now_btn" class="btn btn-primary w-100">Login NOW</button>
                            </div>

                            <div><p><a href="register.php">  Don't have an account? Register here </a></p></div>

                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>