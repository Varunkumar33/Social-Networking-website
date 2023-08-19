<?php
    session_start();

    include("includes/connection.php");

    if(isset($_POST['login'])){
        $email=htmlentities(mysqli_real_escape_string($con,$_POST['email']));
        $pass=htmlentities(mysqli_real_escape_string($con,$_POST['pass']));

        $select_user = "select * from users where user_email='$email' and user_pass='$pass' and status='verified' ";
        $check_user = mysqli_query($con, $select_user);

        if($check_user == 1){
            $_SESSION['user_email']= $email;
            echo "<script>window.open('home.php', '_self')</script>";
        }
        else{
            echo "<script>alert('Your email or password is incorrect!')</script>";
        }
    }
    
?>