<!DOCTYPE html>
<?php
    session_start();
    include("includes/header.php");

    if(!isset($_SESSION['user_email'])){ 
        header("location: index.php");
    }
?>
<html>
<head>
<title>View Your Post</title>
<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type= "text/css" href="style/home_style2.css">
</head>
<body>
 <?php
     if(isset($_GET['post_id'])){
        global $con;

        $get_id = $_GET['post_id'];
        $get_posts = "select * from posts where post_id='$get_id'";
        $run_posts = mysqli_query($con, $get_posts);
        $row_posts = mysqli_fetch_array($run_posts);
        $post_id = $row_posts['post_id'];
        $posted_user_id = $row_posts['user_id'];
     }
     $user = $_SESSION['user_email'];
     $get_user= "select * from users where user_email='$user'";
     $run_user = mysqli_query($con, $get_user);
     $row = mysqli_fetch_array($run_user);

     $user_id= $row['user_id'];

     $get_posted_user= "select * from users where user_id= '$posted_user_id' AND posts='yes' ";
     $run_posted_user = mysqli_query($con, $get_posted_user);
     $row_posted_user = mysqli_fetch_array($run_posted_user);
     $posted_user_fname = $row_posted_user['f_name'];
     $posted_user_lname = $row_posted_user['l_name'];

     $get_likes_count = "SELECT * from likes where post_id = '$post_id'";
     $run_likes_count = mysqli_query($con, $get_likes_count);
     $total = mysqli_num_rows($run_likes_count);
   
     $ins_query = "INSERT into likes (`user_id`,`post_id`) values ('$user_id','$post_id')";
     $run_ins_query = mysqli_query($con, $ins_query);
     if($run_ins_query){
        echo " <script> alert('You liked a post posted by $posted_user_fname $posted_user_lname') </script> ";
        echo "<script>window.open('home.php', '_self')</script>";
     }
     else{
        echo " <script> alert('A user can like a post only once  $total') </script> ";
        echo "<script>window.open('home.php', '_self')</script>";
     }
    // echo "<script> alert('$post_id, $user_id') </script>";
    // echo "<script>window.open('home.php', '_self')</script>";
 ?>
</body>
</html>
