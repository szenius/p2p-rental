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
$category = $_GET['category'];
?>
<html>
    <head>
        <title>ShareStuff - All Listings</title>
        <?php
        include 'includes/plugins.php';
        ?>
        <script src="js/tabs.js"></script>
        <script src="js/bootstrap-datetimepicker.min.js"></script>
        <script src="js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker({
                    format: "yyyy-mm-dd",
                    startView: 'month',
                    minView: 'month',
                    autoclose: true
                });
                $('#datetimepicker2').datetimepicker({
                    format: "yyyy-mm-dd",
                    startView: 'month',
                    minView: 'month',
                    autoclose: true
                });
            });
        </script>
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

        <!-- Products -->
        <div class="total-ads main-grid-border">
            <div class="container">
                <form id="filter" action="view_all_listings.php" method="POST">
                    <div class="select-box">
                        <div class="browse-category ads-list" style="width: 30%;">
                            <label>Browse categories</label>
                            <select class="selectpicker show-tick" style="width: 80%;">
                                <option data-tokens="All">All</option>
                            </select>
                        </div>
                        <div class="search-product ads-list" style="width: 40%;">
                            <label>Available period</label>
                            <div>
                                <div class='input-group date' id='datetimepicker1' style="width: 35%; float: left;">
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                To
                                <div class='input-group date' id='datetimepicker2' style="width: 35%; float: right; margin-right: 25%;">
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="search-product ads-list" style="width: 30%;">
                            <label>Search for a specific item</label>
                            <div class="search">
                                <div id="custom-search-input">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-lg" placeholder="Item Name" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="button">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="index.php">Home</a></li>
                    <?php
                    if ($category != null) {
                        echo '<li><a href="view_all_listings.php">All Listings</a></li>';
                        echo '<li class="active">' . $category . '</li>';
                    } else {
                        echo '<li class="active">All Listings</li>';
                    }
                    ?>
                </ol>
                <div class="ads-grid">
                    <div class="ads-display col-md-12">
                        <div class="wrapper">					
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                            <?php
                                            if ($category != null) {
                                                echo '<span class="text">' . $category . '</span>';
                                            } else {
                                                echo '<span class="text">All Listings</span>';
                                            }
                                            ?>
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
                                                <div class="sort">
                                                    <div class="sort-by">
                                                        <label>Sort By : </label>
                                                        <select>
                                                            <option value="">Most Recent</option>
                                                            <option value="">Price: Rs Low to High</option>
                                                            <option value="">Price: Rs High to Low</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <ul class="list">
                                                    <?php
                                                    $result = pg_query($db, "SELECT view_all_listing('all')");
                                                    $exists = pg_num_rows($result);
                                                    if ($exists > 0) {
                                                        $rows = pg_fetch_all($result);
                                                        foreach ($rows as $row) {
                                                            $json = json_decode($row[view_all_listing]);

                                                            $isAvail = $json->f10;
                                                            echo "<a href='view_single_listing.php?id=$json->f1'>";
                                                            ?>
                                                            <li>
                                                                <img src="<?php echo $json->f11; ?>" title="" alt="" />
                                                                <section class="list-left">
                                                                    <h4 style="color: #f3c500">Category: <?php echo $json->f12; ?></h4>
                                                                    <h5 class="title"><?php echo $json->f2; ?></h5>
                                                                    <span class="adprice">$<?php echo $json->f3; ?></span>
                                                                    <small>Posted on <?php echo $json->f7; ?> by <?php echo $json->f13; ?></small>
                                                                </section>
                                                                <section class="list-right">
                                                                    <h3>
                                                                        <?php
                                                                        $isAvail = $json->f10;
                                                                        if ($isAvail == "true") {
                                                                            echo "<span class='label label-success'>Available</span>";
                                                                        } else {
                                                                            echo "<span class='label label-default'>Not Available</span>";
                                                                        }
                                                                        ?>
                                                                    </h3>
                                                                    <span class="date">From <?php echo $json->f8; ?> To <?php echo $json->f9; ?></span>
                                                                </section>
                                                                <div class="clearfix"></div>
                                                            </li> 
                                                            <?php
                                                            echo "</a>";
                                                        }
                                                    }
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
        <!-- // Products -->
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