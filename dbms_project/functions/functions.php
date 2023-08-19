<?php
$con = mysqli_connect("localhost","root","","socialmedia") or die("Connection was not established");

 
function insertPost(){
    if(isset($_POST['sub'])){
        global $con; // global keyword makes variables of global scope
        global $user_id;
        $content = htmlentities($_POST['content']);
        $upload_image = $_FILES['upload_image']['name']; //name of image uploaded is stored in a variable
        $image_tmp = $_FILES['upload_image']['tmp_name']; //path of the image uploaded is stored in a variable
        $random_number = rand(1,100);
        if(strlen($content)>250){ // to check lenght of text
            echo "<script> alert('Please use 250 or less than 250 words!') </script>";
            echo "<script> window.open('home.php','_self')</script>";
        }
        else
        {
                if(strlen($upload_image) >= 1 && strlen($content) >=1){ // if both image and text are given by user
                move_uploaded_file($image_tmp,"imagepost/$upload_image.$random_number");
                $insert = "insert into posts (user_id,post_content,upload_image,post_date) values('$user_id','$content','$upload_image.$random_number'
                ,NOW())";
                $run = mysqli_query($con,$insert);
                    if($run){
                        echo "<script> alert('Your Post Uploaded a moment ago!') </script>";
                        echo "<script> window.open('home.php','_self')</script>";
                        $update = "update users set posts = 'yes' where user_id = '$user_id'";
                        $run_update = mysqli_query($con,$update);
                    }
                 exit();
                }
                else
                {
                    if($upload_image== '' && $content == ''){ // if both image and text are not given by user
                        echo "<script> alert('Error occured while uploading!') </script>";
                        echo "<script> window.open('home.php','_self')</script>";
                    }
                    else{
                        if($content == ''){ //if user gives text
                            move_uploaded_file($image_tmp,"imagepost/$upload_image.$random_number"); 
                            $insert = "insert into posts (user_id,post_content,upload_image,post_date) values('$user_id','No','$upload_image.$random_number',
                            ,NOW())";
                            $run = mysqli_query($con,$insert);
                            if($run){
                                    echo "<script> alert('Your Post Uploaded a moment ago!') </script>";
                                    echo "<script> window.open('home.php','_self')</script>";
                                    $update = "update users set posts = 'yes' where user_id = '$user_id'";
                                    $run_update = mysqli_query($con,$update);
                            }
                            exit();
                        }
                        else{ // if user gives image
                            $insert = "insert into posts (user_id,post_content,post_date) values('$user_id','$content',NOW())";
                            $run = mysqli_query($con,$insert);
                            if($run){
                                echo "<script> alert('Your Post Uploaded a moment ago!') </script>";
                                echo "<script> window.open('home.php','_self')</script>";
                                $update = "update users set posts = 'yes' where user_id = '$user_id'";
                                $run_update = mysqli_query($con,$update);
                            } 
                        } // if only text part is given by user to post (else part brace)
                    } // if both image and text is not provided by user  to post(else part brace)
                } // if both image and text is provided by user to post (else part brace)
        } // lenght check else brace
    } // isset check if brace
}  //function brace 

function get_posts(){
    global $con;
    $per_page = 4;

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{
        $page=1;
    }

    $start_from= ($page-1)* $per_page;

    $get_posts= "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";

    $run_posts = mysqli_query($con, $get_posts);

    while($row_posts = mysqli_fetch_array($run_posts)){
        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $content = substr($row_posts['post_content'],0,40);
        $upload_image=$row_posts['upload_image'];
        $post_date=$row_posts['post_date'];

        $user="select * from users where user_id= '$user_id' AND posts='yes' ";
        $run_user=mysqli_query($con, $user);
        $row_user=mysqli_fetch_array($run_user);

        $user_name=$row_user['user_name'];
        $user_image=$row_user['user_image'];

        //now displaying posts from databases

        $get_likes_count = " select * from likes where post_id = '$post_id'";
        $run_likes_count = mysqli_query($con, $get_likes_count);
        $row_likes_count = mysqli_fetch_array($run_likes_count);
        $total = mysqli_num_rows($run_likes_count);

        $liked_user_id = $row_likes_count['user_id'];

        $get_liked_user= "select * from users where user_id= '$liked_user_id' AND posts='yes' ";
        $run_liked_user = mysqli_query($con, $get_liked_user);
        $row_liked_user = mysqli_fetch_array($run_liked_user);
        $liked_user_fname = $row_liked_user['f_name'];
        $liked_user_lname = $row_liked_user['l_name'];
        $total =$total-1;

        if($content=="No" && strlen($upload_image) >= 1){
            echo "
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6'>
                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                        <h4 style='color:black;'>Uploaded a post on <strong>$post_date</strong></h4>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'>
                        <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                    </div>
                </div><br>
                <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'><i class='fa fa-comment'></i>
                Comment</button></a>
                <a href='like.php?post_id=$post_id'><button class='btn btn-info' style = 'float:left;'>
                <i class='fa fa-thumbs-up'></i>Like</button></a>";
                if($total>0){
                    echo "<h4 style = 'float:left; margin-left:10px;'> Liked by $liked_user_fname $liked_user_lname and $total others. </h4><br>";
                }
                else if($total==0){
                   echo "<h4 style = 'float:left; margin-left:10px;'> Liked by $liked_user_fname $liked_user_lname. </h4><br>";
                }
                else{
                    echo "<h4 style = 'float:left; margin-left:10px;'>  Yet to be liked by someone. </h4><br>";
                }
            echo"
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }

        else if(strlen($content)>= 1 && strlen($upload_image)>= 1){
            echo "
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6'>
                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                        <h4 style='color:black;'>Uploaded a post on <strong>$post_date</strong></h4>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'>
                        <p>$content</p>
                        <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                    </div>
                </div><br>
                <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'><i class='fa fa-comment'></i>
                Comment</button></a>
                <a href='like.php?post_id=$post_id'><button class='btn btn-info' style = 'float:left'>
                <i class='fa fa-thumbs-up'></i>Like</button></a>";
                if($total>0){
                    echo "<h4 style = 'float:left; margin-left:10px;'> Liked by $liked_user_fname $liked_user_lname and $total others. </h4><br>";
                }
                else if($total==0){
                   echo "<h4 style = 'float:left; margin-left:10px;'> Liked by $liked_user_fname $liked_user_lname. </h4><br>";
                }
                else{
                    echo "<h4 style = 'float:left; margin-left:10px;'>  Yet to be liked by someone. </h4><br>";
                }
            echo"
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }

        else{
            echo "
            <div class='row'>
                <div class='col-sm-3'>
                </div>
                <div id='posts' class='col-sm-6'>
                <div class='row'>
                    <div class='col-sm-2'>
                        <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                    </div>
                    <div class='col-sm-6'>
                        <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                        <h4 style='color:black;'>Uploaded a post on <strong>$post_date</strong></h4>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'>
                    <h3><p>$content</p></h3>
                    </div>
                </div><br>
                <a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'><i class='fa fa-comment'></i>
                Comment</button></a>
                <a href='like.php?post_id=$post_id'><button class='btn btn-info' style = 'float:left;'>
                <i class='fa fa-thumbs-up'></i>Like</button></a>";
                if($total>0){
                    echo "<h4 style = 'float:left; margin-left:10px;'> Liked by $liked_user_fname $liked_user_lname and $total others. </h4><br>";
                }
                else if($total==0){
                   echo "<h4 style = 'float:left; margin-left:10px;'> Liked by $liked_user_fname $liked_user_lname. </h4><br>";
                }
                else{
                    echo "<h4 style = 'float:left; margin-left:10px;'>  Yet to be liked by someone. </h4><br>";
                }
            echo"
                </div>
                <div class='col-sm-3'>
                </div>
            </div><br><br>
            ";
        }
    }

    include("pagination.php");
}

    function single_post(){

        if(isset($_GET['post_id'])){
            global $con;

            $get_id = $_GET['post_id'];
            $get_posts = "select * from posts where post_id='$get_id'";
            $run_posts = mysqli_query($con, $get_posts);
            $row_posts = mysqli_fetch_array($run_posts);
            $post_id = $row_posts['post_id'];
            $user_id = $row_posts['user_id'];
            $content = $row_posts['post_content'];
            $upload_image = $row_posts['upload_image'];
            $post_date = $row_posts['post_date'];

            $user = "select * from users where user_id='$user_id' AND posts='yes'";

            $run_user = mysqli_query($con, $user);
            $row_user = mysqli_fetch_array($run_user);

            $user_name = $row_user['user_name'];
            $user_image = $row_user['user_image'];

            $user_com = $_SESSION['user_email'];

            $get_com = "select * from users where user_email='$user_com'";

            $run_com = mysqli_query($con, $get_com);
            $row_com = mysqli_fetch_array($run_com);

            $user_com_id = $row_com['user_id'];
            $user_com_name = $row_com['user_name'];

            if(isset($_GET['post_id'])){
                $post_id = $_GET['post_id'];
            }

            $get_posts = "select post_id from posts where post_id='$post_id' ";
            $run_user = mysqli_query($con, $get_posts);

            $post_id = $_GET['post_id'];
            $post = $_GET['post_id'];
            $get_user = "select * from posts where post_id='$post'";
            $run_user= mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);

            $p_id = $row['post_id'];

            if($p_id != $post_id){
                echo "<script>alert('ERROR')</script>";
                 echo "<script>window.open('home.php','_self')</script>";
            }
            else{
                if($content=="No" && strlen($upload_image) >= 1){
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'> Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                            </div>
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
        
                else if(strlen($content)>= 1 && strlen($upload_image)>= 1){
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'> Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <p>$content</p>
                                <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                            </div>
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
        
                else{
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black';>Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                            <h3><p>$content</p></h3>
                            </div>
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }//else condition ending

                include("comments.php");

                echo "
                <div class='row'>
                    <div class='col-md-6 col-md-offset-3'>
                        <div class='panel panle-info' style='border: 2px solid #e6e6e6'>
                            <div class='panel-body'>
                                <form action='' class='form-inline' method='post'>
                                <textarea placeholder='Write Your comment here!'  name='comment' class='pb-cmnt-textarea'></textarea>
                                <button class='btn btn-info pull-right' name='reply'>Comment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                ";

            if(isset($_POST['reply'])){
                $comment = htmlentities($_POST['comment']);

                if($comment == ""){
                    echo "<script>alert('Enter your comment!')</script>";
                    echo "<script>window.open('single.php?post_id=$post_id','_self')</script>";
                }
                else{
                    $q="select count(*) from comments group by user_id having count(user_id)>1";
                    $res=mysqli_query($con, $q);
                    if(mysqli_num_rows($res)>1){
                        echo "<script>alert('only one comment limited!')</script>";
                    echo "<script>window.open('single.php?post_id=$post_id','_self')</script>";
                    }
                    else{
                        $insert = "insert into comments (post_id,user_id,comment, comment_author,date) values ('$post_id','$user_id','$comment','$user_com_name',NOW())";

                    $run = mysqli_query($con, $insert);
                    echo "<script>alert('Your comment added!')</script>";
                    echo "<script>window.open('single.php?post_id=$post_id','_self')</script>";
                    }


                    
                }
            }
                
            }
        }
    }

    function user_posts(){
        global $con;
        if(isset($_GET['u_id'])){
            $u_id  = $_GET['u_id'];
        }
        $get_posts= "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";
        $run_posts = mysqli_query($con, $get_posts);
        while($row_posts = mysqli_fetch_array($run_posts)){

            $post_id = $row_posts['post_id'];
            $user_id = $row_posts['user_id'];
            $content = $row_posts['post_content'];
            $upload_image= $row_posts['upload_image'];
            $post_date = $row_posts['post_date'];

            $user = "select * from users where user_id='$user_id' AND posts='yes'";
            $run_user = mysqli_query($con, $user);
            $row_user = mysqli_fetch_array($run_user);

            $user_name = $row_user['user_name'];
            $user_image= $row_user['user_image'];

            if(isset($_GET['u_id'])){
                $u_id = $_GET['u_id'];
            }
            $getuser = "select user_email from users where user_id='$u_id'";
            $run_user = mysqli_query($con, $getuser);
            $row = mysqli_fetch_array($run_user);

            $user_email = $row['user_email'];

            $user = $_SESSION['user_email'];
            $get_user= "select * from users where user_email='$user'";
            $run_user = mysqli_query($con, $get_user);
            $row = mysqli_fetch_array($run_user);

            $user_id= $row['user_id'];
            $u_email = $row['user_email'];

            

            if($u_email != $user_email){
                echo "<script>window.open('my_post.php?u_id=$user_id','_self')</script>";
            }else{
                $get_likes_count = "SELECT * from likes where post_id = '$post_id'";
                $run_likes_count = mysqli_query($con, $get_likes_count);
                $row_likes_count = mysqli_fetch_array($run_likes_count);
                $total = mysqli_num_rows($run_likes_count);
                $liked_user_id = $row_likes_count['user_id'];
                $get_liked_user= "select * from users where user_id= '$liked_user_id' AND posts='yes' ";
                $run_liked_user = mysqli_query($con, $get_liked_user);
                $row_liked_user = mysqli_fetch_array($run_liked_user);
                $liked_user_fname = $row_liked_user['f_name'];
                $liked_user_lname = $row_liked_user['l_name'];
                $total =$total-1;
        
                if($content=="No" && strlen($upload_image) >= 1){
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'>Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                            </div><br>
                            <a href='like.php?post_id=$post_id'><button class='btn btn-info' style = 'float:left; margin-top: 15px;'>
                            <i class='fa fa-thumbs-up'></i>Like</button></a><br>";
                            if($total>0){
                                echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'> Liked by $liked_user_fname $liked_user_lname and $total others. </h4><br>";
                            }
                            else if($total==0){
                               echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'> Liked by $liked_user_fname $liked_user_lname. </h4><br>";
                            }
                            else{
                                echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'>  Yet to be liked by someone. </h4><br>";
                            }
                        echo"
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
        
                else if(strlen($content)>= 1 && strlen($upload_image)>= 1){
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'>Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <p>$content</p>
                                <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                            </div><br>
                            <a href='like.php?post_id=$post_id'><button class='btn btn-info' style = 'float:left; margin-top: 15px;'>
                            <i class='fa fa-thumbs-up'></i>Like</button></a>";
                            if($total>0){
                                echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'> Liked by $liked_user_fname $liked_user_lname and $total others. </h4><br>";
                            }
                            else if($total==0){
                               echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'> Liked by $liked_user_fname $liked_user_lname . </h4><br>";
                            }
                            else{
                                echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'>  Yet to be liked by someone. </h4><br>";
                            }
                        echo"
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
        
                else{
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'>Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                            <h3><p>$content</p></h3>
                            </div>
                        </div><br>
                        <a href='like.php?post_id=$post_id'><button class='btn btn-info' style = 'float:left; margin-top: 15px;'>
                        <i class='fa fa-thumbs-up'></i>Like</button></a><br>";
                        if($total>0){
                            echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'> Liked by $liked_user_fname $liked_user_lname and $total others. </h4><br>";
                        }
                        else if($total==0){
                           echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'> Liked by $liked_user_fname $liked_user_lname. </h4><br>";
                        }
                        else{
                            echo "<h4 style = 'float:left; margin-left:10px;margin-top:22px;'>  Yet to be liked by someone. </h4><br>";
                        }
                    echo"
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
            }

        }
    }

    function results(){
        global $con;

        if(isset($_GET['search'])){
            $search_query = htmlentities($_GET['user_query']);
        }

        $get_posts = "select * from posts where post_content like '%$search_query%' or upload_image like '%$search_query%'";
        $run_posts = mysqli_query($con, $get_posts);
        $qs = mysqli_num_rows($run_posts);
        
        if($qs>0||$qs==1){
            while($row_posts = mysqli_fetch_array($run_posts)){

                $post_id = $row_posts['post_id'];
                $user_id = $row_posts['user_id'];
                $content = $row_posts['post_content'];
                $upload_image = $row_posts['upload_image'];
                $post_date = $row_posts['post_date'];
    
                $user = "select * from users where user_id = '$user_id' AND posts='yes'";
                $run_user = mysqli_query($con, $user);
                $row_user= mysqli_fetch_array($run_user);
    
                $user_name = $row_user['user_name'];
                $first_name = $row_user['f_name'];
                $last_name = $row_user['l_name'];
                $user_image = $row_user['user_image'];
    
                if($content=="No" && strlen($upload_image) >= 1){
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'> Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                            </div>
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
        
                else if(strlen($content)>= 1 && strlen($upload_image)>= 1){
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'> Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <p>$content</p>
                                <img id='posts-img' src='imagepost/$upload_image' style='height: 350px;'>
                            </div>
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
        
                else{
                    echo "
                    <div class='row'>
                        <div class='col-sm-3'>
                        </div>
                        <div id='posts' class='col-sm-6'>
                        <div class='row'>
                            <div class='col-sm-2'>
                                <p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
                            </div>
                            <div class='col-sm-6'>
                                <h3><a style='text-decoration:none; cursor:pointer; color:#3897f0' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                                <h4 style='color:black;'> Uploaded a post on <strong>$post_date</strong></h4>
                            </div>
                            <div class='col-sm-4'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-sm-12'>
                            <h3><p>$content</p></h3>
                            </div>
                        </div><br>
                        </div>
                        <div class='col-sm-3'>
                        </div>
                    </div><br><br>
                    ";
                }
    
            }
        }
        else{
            echo "<br><br><center><h3> Sorry! No Results found.</h3></center>";
        }
       
    }
     
    function search_user(){
        global $con;

        if(isset($_GET['search_user_btn'])){
            $search_query= htmlentities($_GET['search_user']); 
            $get_user = "select * from users where f_name like '%$search_query%' or l_name like '%$search_query%' or user_name like '%$search_query%'";
        }
        else{
            $get_user = "select * from users";
        }

        $run_user = mysqli_query($con,$get_user);
        $us = mysqli_num_rows($run_user);

       if($us==1||$us>0){
            while($row_user=mysqli_fetch_array($run_user)){
                $user_id = $row_user['user_id'];
                $f_name = $row_user['f_name'];
                $l_name = $row_user['l_name'];
                $username = $row_user['user_name'];
                $user_image = $row_user['user_image'];

                echo "
                <div class='row'>
                    <div class='col-sm-3'>
                    </div>
                    <div class='col-sm-6'>
                        <div class='row' id='find_people'>
                            <div class='col-sm-4'>
                                <a href='user_profile.php?u_id=$user_id'>
                                <img src='users/$user_image' width='150px' height='140px' title='$username' style='float:left;,margin:1px'/>
                                </a>
                            </div><br><br>
                            <div class='col-sm-6'>
                                <a style='text-decoration:none; cursor:pointer; color: #3897f0;' href='user_profile.php?u_id=$user_id'><strong>
                                <h2>$f_name $l_name</h2></strong>
                                </a>
                            </div>
                            <div class='col-sm-3'>
                            </div>
                        </div>
                    </div>
                    <div class='col-sm-4'>
                    </div>
                </div><br>
                ";
            }
       }
        else{
            echo "<br><br><center><h3> Sorry! No Results found.</h3></center>";
        }
    }
?>

