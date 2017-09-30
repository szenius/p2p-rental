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
        <title>ShareStuff - Borrow & Rent Secondhand Goods</title>
        <?php
        include 'includes/plugins.php';
        ?>
    </head>
    <body>
        <div class="header">
            <!--header section start-->
            <?php
            include 'includes/header.php';
            ?>
            <!--header section end-->
        </div>
        <div class="main-banner banner text-center">
            <div class="container">    
                <h1>Borrow  <span class="segment-heading">    anything online </span> at zero or low cost</h1>
                <p>Come and browse from our vast catalogue of things!</p>
                <a href="post-listing.html">Post Your Listing</a>
            </div>
        </div>
        <!-- content-starts-here -->
        <div class="content">
            <div class="categories">
                <div class="container">
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab1">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-mobile"></i></div>
                                    <h4 class="clrchg">Mobile Devices</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab2">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-laptop"></i></div>
                                    <h4 class="clrchg"> Electronics & Appliances</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab3">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-home"></i></div>
                                    <h4 class="clrchg">Furniture</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab4">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-paw"></i></div>
                                    <h4 class="clrchg">Pets Accessories</h4>
                                </div>
                            </div>
                        </a>
                    </div>	
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab5">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-book"></i></div>
                                    <h4 class="clrchg">Books</h4>
                                </div>
                            </div>
                        </a>
                    </div>	
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab6">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-asterisk"></i></div>
                                    <h4 class="clrchg">Fashion</h4>
                                </div>
                            </div>
                        </a>
                    </div>	
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab7">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-gamepad"></i></div>
                                    <h4 class="clrchg">Kids</h4>
                                </div>
                            </div>
                        </a>
                    </div>	
                    <div class="col-md-3 focus-grid">
                        <a href="categories.html#parentVerticalTab8">
                            <div class="focus-border">
                                <div class="focus-layout">
                                    <div class="focus-image"><i class="fa fa-soccer-ball-o"></i></div>
                                    <h4 class="clrchg">Sports & Hobbies</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="mobile-app">
                <div class="container">
                    <div class="col-md-5 app-left">
                        <a href="mobileapp.html"><img src="images/app.png" alt=""></a>
                    </div>
                    <div class="col-md-7 app-right">
                        <h3>ShareStuff is the <span>Easiest</span> way to borrow or rent out second-hand goods</h3>
                        <p>Sharing is caring. All of us, at some point or another, will have things that we bought and used it for one time. Declutter your home by 
                            lending or renting out your stuff. Likewise, you can rent items that you will only use for a short term.</p>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
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