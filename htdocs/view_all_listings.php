<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
?>
<html>
    <head>
        <title>ShareStuff - All Listings</title>
        <?php
        include 'includes/plugins.php';
        ?>
        <script src="js/tabs.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var elem = $('#container ul');
                $('#viewcontrols a').on('click', function (e) {
                    if ($(this).hasClass('gridview')) {
                        elem.fadeOut(1000, function () {
                            $('#container ul').removeClass('list').addClass('grid');
                            $('#viewcontrols').removeClass('view-controls-list').addClass('view-controls-grid');
                            $('#viewcontrols .gridview').addClass('active');
                            $('#viewcontrols .listview').removeClass('active');
                            elem.fadeIn(1000);
                        });
                    } else if ($(this).hasClass('listview')) {
                        elem.fadeOut(1000, function () {
                            $('#container ul').removeClass('grid').addClass('list');
                            $('#viewcontrols').removeClass('view-controls-grid').addClass('view-controls-list');
                            $('#viewcontrols .gridview').removeClass('active');
                            $('#viewcontrols .listview').addClass('active');
                            elem.fadeIn(1000);
                        });
                    }
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
                <a href="post-listing.html">Post Your Listing</a>
            </div>
        </div>

        <!-- Products -->
        <div class="total-ads main-grid-border">
            <div class="container">
                <div class="select-box">
                    <div class="browse-category ads-list">
                        <label>Browse Categories</label>
                        <select class="selectpicker show-tick" data-live-search="true">
                            <option data-tokens="Mobiles">All</option>
                        </select>
                    </div>
                    <div class="search-product ads-list">
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
                <div class="all-categories">
                    <h3> Select your category and find the perfect item</h3>
                    <ul class="all-cat-list">
                        <li><a href="mobiles.html">Mobile Devices <span class="num-of-ads">(5,78,076)</span></a></li>
                    </ul>
                </div>
                <ol class="breadcrumb" style="margin-bottom: 5px;">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">All Listings</li>
                </ol>
                <div class="ads-grid">
                    <div class="ads-display col-md-12">
                        <div class="wrapper">					
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                            <span class="text">All Listings</span>
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
                                                            if ($isAvail == "true") {
                                                                echo "<a href='view_single_listing.php?id=$json->f1'>";
                                                            } else {
                                                                echo "<a href='javascript: void(0)'>";
                                                            }
                                                            ?>
                                                            <li>
                                                                <img src="images/item.jpg" title="" alt="" />
                                                                <section class="list-left">
                                                                    <h4 style="color: #f3c500">Category: <?php echo $json->f12; ?></h4>
                                                                    <h5 class="title"><?php echo $json->f2; ?></h5>
                                                                    <span class="adprice">$<?php echo $json->f3; ?></span>
                                                                    <small>Posted on <?php echo $json->f7; ?></small>
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