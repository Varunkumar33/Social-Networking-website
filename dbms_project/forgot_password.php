<!DOCTYPE html>
<html>
    <head>
        <title>Forgotten password</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <style>
        body{
            overflow-x: hidden;
        }
        .main-content{
            width: 50%;
            height: 40%;
            margin: 10px auto;
            background-color: #fff;
            border: 2px solid #e6e6e6;
            padding: 40px 50px;
        }
        .header{
            border: 0px solid #000;
            margin-bottom: 5px;
        }
        .well{
            background-color: #187FAB;
        }
        #signup{
            width: 60%;
            border-radius: 30px;
        }
    </style>
    <body>
        <div class= "row">
            <div class="col-sm-12">
                <div class="well">
                    <center><h1 style="color: white;"><strong>Instabook</strong></h1></center>
                </div>
            </div>
        </div>   
        <div class="row">
            <div class="col-sm-12">
                <div class="main-content">
                    <div class="header">
                        <h3 style="text-aling: center;"><strong>Forgot Password</strong></h3>
                    </div>
                    <div class="l_pass">
                        <form action="" method="post">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user "></i></span>
                                <input type="email" id="email" class="form-control" placeholder="enter your email" name="email" required>
                            </div><br>
                            <hr>
                            <pre class="text">Enter your Bestfriend name down below</pre>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil "></i></span>
                                <input type="text" id="msg" class="form-control" placeholder="someone" name="recovery_account" required>
                            </div><br>
                            <a href="signin.php" style="text-decoration: none;float: right; color: #187FAB;" data-toggle="tooltip" title="Signin">Back to Signin?</a><br><br>
                            <center><button class="btn btn-info btn-lg" id="signup" name="submit">Submit</button></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    session_start();

    include("includes/connection.php");

    if(isset($_POST['submit'])){
        $email=htmlentities(mysqli_real_escape_string($con,$_POST['email']));
        $recovery_account=htmlentities(mysqli_real_escape_string($con,$_POST['recovery_account']));
        $select_user = "select * from users where user_email='$email' and recovery_account='$recovery_account' ";
        $check_user = mysqli_query($con, $select_user);
        $total = mysqli_num_rows($check_user);

        if($total==1){
            $_SESSION['user_email']= $email;
            echo "<script>window.open('change_password.php', '_self')</script>";
        }
        else{
            echo "<script>alert('Your email or Bestfriend name is incorrect!')</script>";
        }
    }
    
?>