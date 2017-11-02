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
$id = $_GET['id'];

if (isset($_POST['accept']) || isset($_POST['delete']) || isset($_POST['bidAmt'])) {
    header("refresh:2;url=view_single_listing.php?id=$id");
}
?>
<html>
    <head>
        <title>ShareStuff - View Listing</title>
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
                    <li><a href="view_all_listings.php?category=All">All Listings</a></li>
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
                                    <h2>
                                        <?php
                                        if ($_SESSION['is_admin']) {
                                            ?>
                                            <a href="edit_listing.php?id=<?php echo $id; ?>"><span class="glyphicon glyphicon-pencil"></span></a> &nbsp
                                            <?php
                                        }
                                        echo $json->title;
                                        ?>
                                    </h2>
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
                                        <p><strong>Status :</strong> 
                                            <?php
                                            if ($json->is_avail) {
                                                echo "Available";
                                            } else {
                                                echo "Not Available";
                                            }
                                            ?>
                                        </p>
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
                                        <div class="condition">
                                            <p class="p-price">Highest Bid</p>
                                            <?php
                                            $bid_result = pg_query($db, "SELECT query_highest_bid($id)");
                                            $bid_exists = pg_num_rows($bid_result);
                                            if ($bid_exists == 1) {
                                                $bid_rows = pg_fetch_all($bid_result);
                                                foreach ($bid_rows as $row) {
                                                    $bid_json = json_decode($row[query_highest_bid]);
                                                    if ($bid_json->amount == null) {
                                                        echo '<h4>-</h4>';
                                                    } else {
                                                        echo '<h4>$' . $bid_json->amount . '</h4>';
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $startDate = DateTime::createFromFormat('Y-m-d', $json->start_date)->format('Y-m-d');
                                $endDate = DateTime::createFromFormat('Y-m-d', $json->end_date)->format('Y-m-d');
                                date_default_timezone_set('Asia/Singapore');
                                $today = date('Y-m-d');
                                if ($_SESSION['is_admin'] || $_SESSION['username'] == $json->owner) {
                                    ?>
                                    <div class="col-md-5" style="margin: 20px 0px 0px 50px; float: right; width: 43%;">
                                        <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                            <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                                <li role="presentation" class="active">
                                                    <a href="#" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                                        <span class="text">All Bids</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div id="myTabContent" class="tab-content">
                                                <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                                                    <div>
                                                        <div class="clearfix"></div>
                                                        <?php
                                                        if (isset($_POST['delete'])) {
                                                            $bidId = $_POST['bidId'];
                                                            $delete_result = pg_query($db, "SELECT delete_bid($bidId);");
                                                            $delete_rows = pg_fetch_all($delete_result);
                                                            foreach ($delete_rows as $row) {
                                                                if ($row[delete_bid] == "t") {
                                                                    echo "<p style='color: green;'>Bid Deleted Successfully!</p>";
                                                                } else {
                                                                    echo "<p style='color: red;'>Bid Deletion Failed!</p>";
                                                                }
                                                            }
                                                        }

                                                        if (isset($_POST['accept'])) {
                                                            $bidId = $_POST['bidId'];
                                                            $accept_result = pg_query($db, "SELECT winning_bid($bidId);");
                                                            $accept_rows = pg_fetch_all($accept_result);
                                                            foreach ($accept_rows as $row) {
                                                                if ($row[winning_bid] == "t") {
                                                                    echo "<p style='color: green;'>Bid Accepted Successfully!</p>";
                                                                } else {
                                                                    echo "<p style='color: red;'>Bid Acceptance Failed!</p>";
                                                                }
                                                            }
                                                        }
                                                        
                                                        if ($_SESSION['username'] == $json->owner && !$json->is_avail) {
                                                            echo "<p style='color: red;'>You're not allow to accept any bids as the item is not available now.</p>";
                                                        }
                                                        ?>
                                                        <table class="table" style="width: 100%">
                                                            <tr>
                                                                <th style="width: 40%; color: black"><h5>Username</h5></th>
                                                                <th style="width: 15%; color: black"><h5>Bid</h5></th>
                                                                <th style="width: 15%; color: black"><h5>Status</h5></th>
                                                                <th style="width: 15%; color: black"><h5>Action</h5></th>
                                                            </tr>
                                                            <?php
                                                            $all_bids_result = pg_query($db, "SELECT view_all_bids($id);");
                                                            $all_bids_exists = pg_num_rows($all_bids_result);
                                                            if ($all_bids_exists > 0) {
                                                                $all_bids_rows = pg_fetch_all($all_bids_result);
                                                                foreach ($all_bids_rows as $row) {
                                                                    $bjson = json_decode($row[view_all_bids]);
                                                                    ?>
                                                                    <tr>
                                                                        <td><h5><?php echo $bjson->f5 . ' on ' . $bjson->f3; ?></h5></td>
                                                                        <td><h5>$<?php echo $bjson->f2; ?></h5></td>
                                                                        <td><h5><?php echo $bjson->f4; ?></h5></td>
                                                                        <?php
                                                                        if ($_SESSION['is_admin']) {
                                                                            ?>
                                                                            <td>
                                                                                <form name="deleteBid" action="" method="POST">
                                                                                    <input type="hidden" name="delete" value="delete">
                                                                                    <input type="hidden" name="bidId" value="<?php echo $bjson->f1; ?>">
                                                                                    <input type="submit" class="btn btn-danger" value="Delete">
                                                                                </form>
                                                                            </td>
                                                                            <?php
                                                                        } else if ($_SESSION['username'] == $json->owner) {
                                                                            if ($json->is_avail) {
                                                                                ?>
                                                                                <td>
                                                                                    <form name="acceptBid" action="" method="POST">
                                                                                        <input type="hidden" name="accept" value="accept">
                                                                                        <input type="hidden" name="bidId" value="<?php echo $bjson->f1; ?>">
                                                                                        <input type="submit" class="btn btn-success" value="Accept">
                                                                                    </form>
                                                                                </td>
                                                                                <?php
                                                                            } else {
                                                                                echo '<td></td>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td><h5>No bids found.</h5></td>
                                                                    <td><h5></h5></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else
                                if ($json->is_avail && $endDate >= $today) {
                                    ?>
                                    <div class="col-md-6 product-details-grid">
                                        <div class="interested text-center">
                                            <h4>Interested in this Listing? </h4><p></p>
                                            <form name="submitBid" action="" method="POST">
                                                <input name="bidAmt" type="number" step="0.01" min="0" placeholder="Enter bidding price">
                                                <br>Bid as: <?php echo $_SESSION['username']; ?>
                                                <p><input type="submit" class='btn btn-default' value="Bid Now!"></p>
                                            </form>
                                            <?php
                                            if (isset($_POST['bidAmt'])) {
                                                $bidAmt = $_POST['bidAmt'];
                                                $bidder = $_SESSION['username'];
                                                $create_result = pg_query($db, "SELECT create_bid($bidAmt,'$bidder',$id);");
                                                $create_rows = pg_fetch_all($create_result);
                                                foreach ($create_rows as $row) {
                                                    if ($row[create_bid] == "t") {
                                                        echo "<p style='color: green;'>Bid Submitted Successfully!</p>";
                                                    } else {
                                                        echo "<p style='color: red;'>Bid Submission Failed!</p>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-6 product-details-grid">
                                        <div class="interested text-center" style="background:gray">
                                            <h4>Item is not available for bidding now</h4>
                                        </div>
                                    </div>
                                    <?php
                                }
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