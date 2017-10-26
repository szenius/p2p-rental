<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
// if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
//     header('Location: index.php');
// }
?>
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
?>
<html>
<head>
    <title>ShareStuff - Register</title>
    <?php
    include 'includes/plugins.php';
    ?>
</head>
<body>
    <!--header section start-->
    <?php
    include 'includes/login/header.php';
    ?>
    <!--header section end-->
    <section>
        <div id="page-wrapper" class="sign-in-wrapper">
            <div class="graphs">
                <div class="sign-up">
                    <?php
                    if (isset($_POST['register'])) {
                        if($_POST['password'] != $_POST['password_confirm']){
                            echo "<span style='color:red;'>Sorry! Password and confirm password fields don't match!</span>";
                        }
                        else{
                            //echo "username ".$_POST['username']."password "."last name + first name ".$_POST['l_name'].$_POST['f_name']." email ".$_POST['username'];
                            $username = $_POST['username'];
                            $l_name = $_POST['l_name'];
                            $f_name = $_POST['f_name'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $result = pg_query($db, "SELECT create_user('$username', '$password', '$f_name', '$l_name', '$email', 'DEFAULT', FALSE)");
                            //pg_query($db, "INSERT into 'user' values($username, $password, $f_name,$l_name,$email,DEFAULT,'FALSE')");
                            if($result == true){
                                $_SESSION['username'] = $username;
                                echo "<span style='color:green;'>Success! User account created!</span>";
                                // header('Location: view_all_listings.php');
                                header( "refresh:1; url=view_all_listings.php" ); 
                            }
                            else{
                                echo "<span style='color:red;'>Sorry! Registration failed!</span>";

                            }


                        }
                    }
                    ?>
                    <form name="register" action="register.php" method="POST" >
                        <h1>Create an account</h1>
                        <p class="creating"></p>
                        <h2>Personal Information</h2>
                        <div class="sign-u">
                            <div class="sign-up1">
                                <h4>Email Address :</h4>
                            </div>
                            <div class="sign-up2">
                                <input type="text" name="email" placeholder="Enter email address" required=" "/>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="sign-u">
                            <div class="sign-up1">
                                <h4>Username :</h4>
                            </div>
                            <div class="sign-up2">
                                <input type="text" name="username" placeholder="Enter username" required=" "/>
                            </div>
                            <div class="clearfix"> </div>
                        </div>

                        <div class="sign-u">
                            <div class="sign-up1">
                                <h4>First Name :</h4>
                            </div>
                            <div class="sign-up2">
                                <input type="text" name="f_name" placeholder="Enter first name" required=" "/>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="sign-u">
                            <div class="sign-up1">
                                <h4>Last Name :</h4>
                            </div>
                            <div class="sign-up2">
                                <input type="text" name="l_name" placeholder="Enter last name" required=" "/>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="sign-u">
                            <div class="sign-up1">
                                <h4>Password :</h4>
                            </div>
                            <div class="sign-up2">
                                <input type="password" name="password" placeholder="Enter password" required=" "/>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="sign-u">
                            <div class="sign-up1">
                                <h4>Confirm Password :</h4>
                            </div>
                            <div class="sign-up2">
                                <input type="password" name="password_confirm" placeholder="Enter password again" required=" "/>
                            </div>
                            <div class="clearfix"> </div>
                        </div> <br/>
                        <p align="center">
                            <input style="width:250px" type="submit" name="register" value="Create Account">
                        </p>
                    </form>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <!--footer section start-->
        <?php
        include 'includes/login/footer.php';
        ?>
        <!--footer section end-->
    </section>
</body>
</html>
<?php
include 'includes/dbclose.php';
?>