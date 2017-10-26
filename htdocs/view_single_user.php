<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<?php
session_start();
include 'includes/dbconnect.php';
$username = $_GET['username'];
?>
<html>
    <head>
        <title>ShareStuff - View User</title>
        <?php
        include 'includes/plugins.php';
        ?>
        <link rel="stylesheet" href="css/flexslider.css" media="screen" />
    </head>
    <body>
        <div class="header">
            <!--header section start-->
            <?php
            include 'includes/header.php';
            ?>
            <!--header section end-->
        </div>
        <div class="banner text-center">
            <div class="container">    
                <h1>Borrow  <span class="segment-heading">    anything online </span> at zero or low cost</h1>
                <p>Come and browse from our vast catalogue of things!</p>
                <a href="post_listing.php">Post Your Listing</a>
            </div>
        </div>
        <!--single-page-->
        <div class="single-page main-grid-border">
            <div class="container">
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="view_all_users.php">All Users</a></li>
                    <?php
                    $result = pg_query($db, "SELECT list_user_by_username('$username')");
                    $exists = pg_num_rows($result);
                    $valid_user = true;
                    if ($exists == 1) {
                        $rows = pg_fetch_all($result);
                        foreach ($rows as $row) {
                            $json = json_decode($row[list_user_by_username]);
                            echo "<li class='active'>$username</li>";
                            echo "</ol>";
                            ?>
                            <div class="product-desc">
                                <div class = "col-md-4 product-view">
                                    <h2><?php echo $username; ?></h2>
                                    <?php
                                    if ($json->username != null) {
                                        ?>
                                        <div class="flexslider">
                                            <ul class="slides">
                                                <li data-thumb="<?php echo $json->photo; ?>">
                                                    <img src="<?php echo $json->photo; ?>" />
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- FlexSlider -->
                                        <script defer src="js/jquery.flexslider.js"></script>
                                        <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

                                        <script>
                                            // Can also be used with $(document).ready()
                                            $(window).load(function () {
                                                $('.flexslider').flexslider({
                                                    animation: "slide",
                                                    controlNav: "thumbnails"
                                                });
                                            });
                                        </script>
                                        <!-- //FlexSlider -->
                                        <p>Name: <?php echo $json->first_name . ' ' . $json->last_name; ?></p>
                                        <p>Email: <?php echo $json->email; ?></p>
                                        <?php
                                    } else {
                                        $valid_user = false;
                                        echo '<p>Error: User Not Found</p>';
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }

                        if ($valid_user) {
                            $listing_result = pg_query($db, "SELECT view_user_listing('$username')");
                            $listing_exists = pg_num_rows($listing_result);
                            echo '<div class="col-md-8 product-details-grid">';
                            echo '<h3 class="rate" style="padding-left: 10%;">All Listings</h3>';
                            echo '<div class="clearfix"></div><br>';
                            echo '<div class="item-list" style="padding-left: 10px;">';
                            if ($listing_exists > 0) {
                                $listing_rows = pg_fetch_all($listing_result);
                                foreach ($listing_rows as $row) {
                                    $json = json_decode($row[view_user_listing]);
                                    echo "<a href='view_single_listing.php?id=$json->f1'>";
                                    ?>
                                    <div class="product-price" style="border-bottom: 1px solid #eee;">
                                        <img src="<?php echo $json->f11; ?>">
                                        <p class="p-listing">
                                            <span class="label label-info" style="padding: .4em .6em;"><?php echo $json->f12; ?></span><br>
                                            <span style="margin-top: 6px; display: inline-block;"><?php echo $json->f2; ?></span>
                                        </p>
                                        <?php
                                        if ($json->f10) {
                                            echo '<span class="label label-success" style="float: right; padding: .6em;">Available</span>';
                                        } else {
                                            echo '<span class="label label-default" style="float: right; padding: .6em;">Not Available</span>';
                                        }
                                        ?>
                                        <h4>
                                            <small style="float: right; margin-top: 8px;">From <?php echo $json->f8; ?> To <?php echo $json->f9; ?></small>
                                        </h4>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                    echo '</a>';
                                }
                            } else {
                                echo '<div class="product-price" style="border-bottom: 1px solid #eee;">';
                                echo '<p class="p-listing">No Listing Found</p>';
                                echo '<div class="clearfix"></div>';
                                echo '</div>';
                            }
                            echo '</div></div>';
                            echo '<div class="clearfix"></div>';
                        }
                        ?>
                    </div>
            </div>
        </div>
        <!--//single-page-->
        <!--footer section start-->
        <?php
        include 'includes/footer.php';
        ?>
        <!--footer section end-->
    </body>
</html>
<?php
include 'includes/dbclose.php';
?>