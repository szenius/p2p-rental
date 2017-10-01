<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
$id = $_GET['id'];
?>
<html>
    <head>
        <title>ShareStuff: Single Listing</title>
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
                <a href="post-listing.html">Post Your Listing</a>
            </div>
        </div>
        <!--single-page-->
        <div class="single-page main-grid-border">
            <div class="container">
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="view_all_listings.php">All Listings</a></li>
                    <?php
                    $result = pg_query($db, "SELECT view_listing($id)");
                    $exists = pg_num_rows($result);
                    if ($exists == 1) {
                        $rows = pg_fetch_all($result);
                        foreach ($rows as $row) {
                            $json = json_decode($row[view_listing]);
                            echo "<li class='active'>$json->category_name</li>";
                            echo "</ol>";
                            ?>
                            <div class="product-desc">
                                <div class = "col-md-6 product-view">
                                    <h2><?php echo $json->title; ?></h2>
                                    <p>Listing ID: <?php echo $id; ?></p>
                                    <small>Posted at <?php echo $json->post_date; ?></small>
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
                                    <div class="product-details">
                                        <p><strong>Description :</strong> <?php echo $json->description; ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6 product-details-grid">
                                    <div class="item-price">
                                        <div class="product-price">
                                            <p class="p-price">Price</p>
                                            <h3 class="rate">$ <?php echo $json->price; ?></h3>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="condition">
                                            <p class="p-price">Owned By</p>
                                            <h4><?php echo $json->owner; ?></h4>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="itemtype">
                                            <p class="p-price">Rental Period</p>
                                            <h4><?php echo $json->start_date; ?> to <?php echo $json->end_date; ?></h4>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="interested text-center">
                                        <h4>Interested in this Listing? </h4><p></p>
                                        <input type='number' steps='.01' placeholder="Enter bidding price">
                                        <p><a class='btn btn-default'><b>Bid Now!</b></a></p>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="clearfix"></div>
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