<!DOCTYPE html>
<html>
    <head>
        <title>entry page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <style>
        #signup{
            width: 60%;
            border-radius: 30px
        }
        #login{
            width: 60%;
            background-color: #fff;
            border: 1px solid #1da1f2;
            color: #1da1f2;
            border-radius: 30px;
        }
        #Login:hover{
            width: 60%;
            background-color: #fff;
            border: 2px solid #1da1f2;
            color: #1da1f2;
            border-radius: 30px;
        }
        .well{
            background-color: #187FAB;
        }
        main {
            margin: 5px;
            padding: 5px;
            background-color: lightgray;
        }
    </style>
    <body>
        <main>
        <div class="row">
            <div class="col-sm-12">
                <div class="well">
                    <center><h1 style="color: white;">InstaBook</h1></center>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 m-6 p-12" style="display: flex; align-items:center; flex-flow: column nowrap; width:100vw">
                <img src="images/logo5.jpg" class="img-rounded" title="InstaBook" width="100px" height="30px">
                <h2><strong>See what's happening in<br>the world right now</strong></h2><br><br>
                <h4><strong>Join the Instabook Today.</strong></h4> 
                <form method="post" action="">
                    <button id="signup" class="btn btn-info btn-lg" name="signup" style="width:300px">Sign up</button><br><br>
                        <?php
                            if(isset($_POST['signup'])){
                                echo "<script>window.open('signup.php','_self')</script>";
                                }
                         ?>
                    <button id="login" class="btn btn-info btn-lg" name="login" style="width:300px">Log in</button><br><br> 
                        <?php
                            if(isset($_POST['login'])){
                                echo "<script>window.open('signin.php','_self')</script>";
                            }
                        ?> 
                </form>
            </div>
        </div>
        </main>
    </body>
</html>
