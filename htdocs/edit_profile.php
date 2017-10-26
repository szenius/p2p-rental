<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();

?>
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
$curr_user = $_SESSION['username'];
//echo "my current username ".$_SESSION['username'];
$curr_user = $_GET['username'];
?>
<html>
<head>
    <title>ShareStuff - Edit Profile</title>
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
                    if (isset($_POST['edit_profile'])) {
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
                            $result = pg_query($db, "SELECT update_user('$username', '$password', '$f_name', '$l_name', '$email', 'DEFAULT')");
                            if($result == true){
                               echo "<span style='color:green;'><b>Success in updating profile!</b></span>";
                                //header('Location: index.php');
                                header( "refresh:1; url=my_account.php" ); 
                           }
                           else{
                            echo "<span style='color:red;'><b>Sorry! Edit profile failed!</b></span>";

                        }
                             //header('Location: index.php');
                    }
                }
                if(isset($_POST['delete_profile'])){
                        //delete stored proc here
                    $result = pg_query($db, "SELECT delete_user('$curr_user')");
                    if($result == true){
                        echo "<span style='color:green;'>Success in deleting user!</span>";
                        //redircet to index? or 
                        if($_SESSION['is_admin'] = false){
                            $_SESSION['username'] = NULL;
                        }
                        header('Location: index.php');
                    }
                    else{
                        echo "<span style='color:red;'>Error in deleting user!</span>";
                    }
                }
                ?>
                <?php
                $result = pg_query($db, "SELECT list_user_by_username('$curr_user')");
                $exists = pg_num_rows($result);
                if ($exists == 1) {
                    $rows = pg_fetch_all($result);
                    foreach ($rows as $row) {
                        $json = json_decode($row[list_user_by_username]);
                        ?>
                        <form name="edit_profile" action="" method="POST" >
                            <h1>Edit Your Profile</h1>
                            <p class="creating"></p>
                            <h2>Personal Information</h2>
                            <div class="sign-u">
                                <div class="sign-up1">
                                    <h4>Email Address :</h4>
                                </div>
                                <div class="sign-up2">
                                    <input type="text" name="email" value="<?php echo $json->email; ?>" required=" "/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="sign-u">
                                <div class="sign-up1">
                                    <h4>Username :</h4>
                                </div>
                                <div class="sign-up2">
                                    <input type="text" name="username" value="<?php echo $json->username; ?>" required=" "/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>

                            <div class="sign-u">
                                <div class="sign-up1">
                                    <h4>First Name :</h4>
                                </div>
                                <div class="sign-up2">
                                    <input type="text" name="f_name" value="<?php echo $json->first_name; ?>" required=" "/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="sign-u">
                                <div class="sign-up1">
                                    <h4>Last Name :</h4>
                                </div>
                                <div class="sign-up2">
                                    <input type="text" name="l_name" value="<?php echo $json->last_name; ?>" required=" "/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="sign-u">
                                <div class="sign-up1">
                                    <h4>Password :</h4>
                                </div>
                                <div class="sign-up2">
                                    <input type="password" name="password" value="<?php echo $json->password; ?>"required=""/>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="sign-u">
                                <div class="sign-up1">
                                    <h4>Confirm Password :</h4>
                                </div>
                                <div class="sign-up2">
                                    <input type="password" name="password_confirm" value="<?php echo $json->password; ?>"required=""/>
                                </div>
                                <div class="clearfix"> </div>
                            </div> <br/>
                            <p align="center">
                                <input style="width:250px" type="submit" name="edit_profile" value="Edit Profile"> &nbsp;
                                <input style="width:250px; background-color:#d31b0e" type="submit" name="delete_profile" value="Delete Account">
                            </p>
                        </form>
                        <?php
                    }
                }
                ?>
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