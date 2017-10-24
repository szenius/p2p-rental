<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
/* if(!$_SESSION['is_admin']){
  header('Location: index.php');
  } */
?>
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
?>
<html>
    <head>
        <title>ShareStuff - All Users</title>
        <?php
        include 'includes/plugins.php';
        ?>
    </head>
    <body>
        <!--header section start-->
        <?php
        include 'includes/header.php';
        ?>
        <!--header section end-->

        <div class="banner text-center">
            <div class="container">    
                <h1>Borrow  <span class="segment-heading">    anything online </span> at zero or low cost</h1>
                <p>Come and browse from our vast catalogue of things!</p>
                <a href="#">Post Your Listing</a>
            </div>
        </div>

        <!-- Content section starts -->
        <div class="total-ads main-grid-border">
            <div class="container">
                <br>
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">All Users</li>
                </ol>
                <div class="ads-grid">
                    <div class="ads-display col-md-12">
                        <div class="wrapper">                   
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                            <span class="text">All Users</span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                                        <div>
                                            <div id="container">
                                                <div class="view-controls-list" id="viewcontrols">
                                                    <label>View :</label>
                                                    <a class="listview active"><i class="glyphicon glyphicon-th-list"></i></a>
                                                </div>
                                                <div class="clearfix"></div>

                                                <ul class="list">
                                                    <?php
                                                    $results = pg_query($db, 'SELECT list_users()');
                                                    $rows = pg_fetch_all($results);
                                                    foreach ($rows as $row) {
                                                        $json = json_decode($row['list_users']);
                                                        $image = $json->f5;
                                                        $username = $json->f1;
                                                        $name = $json->f2 . $json->f3;
                                                        $email = $json->f4;
                                                        echo "<a href='view_single_user.php?username=$username'>";
                                                        echo '<li><img src="' . $image . '" title="" alt="" /><section class="list-left"><h5 class="title">' . $username . '</h5><br>
                                                    <h4>Name: ' . $name . '</h4><br><h4>Email: ' . $email . '</h4></section><div class="clearfix"></div></li> ';
                                                    }
                                                    echo "</a>";
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>  
        </div>
        <!-- // Content section ends -->
        <!--footer section start-->
        <?php
        include 'includes/footer.php';
        ?>
        <!--footer section end-->
    </section>
</body>
</html>
<?php
include 'includes/dbclose.php';
?>