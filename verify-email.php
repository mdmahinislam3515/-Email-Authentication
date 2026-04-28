<?php
session_start();
include('db.php'); 

if(isset($_GET['token']))
{
    $token = $_GET['token'];

    
    $verify_query = "SELECT verify_token, verify_status FROM users WHERE verify_token=? LIMIT 1";
    $stmt = mysqli_prepare($con, $verify_query);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        if($row['verify_status'] == "0")
        {   
            $clicked_token = $row['verify_token'];
            
          
            $update_query = "UPDATE users SET verify_status='1' WHERE verify_token=? LIMIT 1";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, "s", $clicked_token);
            $update_query_run = mysqli_stmt_execute($update_stmt);

            if($update_query_run)
            {
                $_SESSION['status'] = "Your Account has been verified Successfully.!";
                header("Location: login.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Verification Failed.!";
                header("Location: login.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "Email already verified. Please Login";
            header("Location: login.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "This token does not exist.";
        header("Location: login.php");
        exit(0);
    }
}
else
{
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
    exit(0);
}
?>