<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
?>
<html>
    <head>
        <title>ShareStuff - Login</title>
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
                    <div class="sign-in-form">
                        <div class="sign-in-form-top">
                            <h1>Welcome to ShareStuff</h1>
                        </div>
                        <div class="signin">
                            <?php
                            if (isset($_POST['login'])) {
                                //should use stored procedure, using pg_query now for demo
                                $result = pg_query($db, "SELECT username FROM admin WHERE username = '$_POST[user]' AND password = '$_POST[password]' UNION SELECT username FROM member WHERE username = '$_POST[user]' AND password = '$_POST[password]'");
                                $exists = pg_num_rows($result);

                                if ($exists == 1) { //legitimate user
                                    $row = pg_fetch_assoc($result);
                                    $_SESSION['username'] = $row['username'];
                                    $result2 = pg_query($db, "SELECT * FROM admin WHERE username = '$_POST[user]' AND password = '$_POST[password]'");
                                    if (pg_num_rows($result2) > 0) { //is admin
                                        $_SESSION['is_admin'] = true;
                                    } else {
                                        $_SESSION['is_admin'] = false;
                                    }
                                    header('Location: index.php');
                                    die();
                                } else {
                                    echo "<span style='color:red;'>Opps! You have entered an invalid username/password!</span>";
                                }
                            }
                            ?>
                            <form name="login" action="login.php" method="POST">
                                <div class="log-input">
                                    <div class="log-input-center">
                                        <input type="text" name="user" class="user" value="Your Username" onfocus="this.value = '';" onblur="if (this.value == '') {
                                                    this.value = 'Your Email';
                                                }"/>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                                <div class="log-input">
                                    <div class="log-input-center">
                                        <input type="password" name="password" class="lock" value="password" onfocus="this.value = '';" onblur="if (this.value == '') {
                                                    this.value = 'Email address:';
                                                }"/>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                                <input type="submit" name="login" value="Log In" />
                            </form>
                            <br/>
                            <p style="text-align: center;">
                                <a href="#">Forgot Password?</a><br />
                                <a href="register.html">Register Now!</a>
                            </p>
                            <div class="clearfix"> </div>
                        </div>
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