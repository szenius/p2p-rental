<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
// if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
// 	header('Location: index.php');
// }
?>
<!DOCTYPE html>
<?php
include 'includes/dbconnect.php';
// if (isset($_POST['post_listing'])){
//     header("refresh:1;url=my_account.php");
//}
?>
<html>
<head>
    <title>ShareStuff - Post Listing</title>
    <?php
    include 'includes/plugins.php';
    ?>
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
    function delayRefreshPage(mileSeconds) {
        window.setTimeout(refreshPage, mileSeconds);
    }
    function refreshPage() {
     window.location.href= 'my_account.php';
    }
    </script>
</head>
<!-- Content starts here -->
<body>
    <!--header section start-->
    <?php
    include 'includes/header.php';
    ?>
    <!--header section end-->
    <div class="submit-ad main-grid-border">
        <div class="container">
            <h2 class="head">Post a Listing</h2>
            <div class="post-ad-form">
                <?php
                if (isset($_POST['post_listing'])) {
                        //echo "category ".$_POST['category']." \ndescription ".$_POST['description']."\n".$_POST['price']."\n".$_POST['pickup']."\n".$_POST['return']."\n".$_POST['start_date']."\n".$_POST['end_date'];
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];
                    if($end_date < $start_date){
                        echo "<span style='color:red;'><b>Error, end date must be after start date!</b></span><br><br>";
                    }
                    else{
                        $category = $_POST['category'];
                        $description = $_POST['description'];
                        $price = $_POST['price'];
                        $pickup = $_POST['pickup'];
                        $return = $_POST['return'];
                        $title = $_POST['title'];
                        $curr_user = $_SESSION['username'];
                    //echo $curr_user;
                        if (!isset($_FILES['fileselect']) || $_FILES['fileselect']['error'] == UPLOAD_ERR_NO_FILE) {
                            $result = pg_query($db, "SELECT create_listing('$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', 'DEFAULT','$category', '$curr_user')");
                        } else {
                            $filename = 'images/' . $_FILES['fileselect']['name'];
                            //echo $filename;
                            $result = pg_query($db, "SELECT create_listing('$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', '$filename','$category', '$curr_user')");
                        }
                        if ($result == true) {
                            echo "<span style='color:green;'><b>Success in creating new listing!</b></span><br><br>";
                            //header("refresh:1; url=my_account.php");
                            echo "<script> delayRefreshPage(1000); </script>";
                        } else {
                            echo "<span style='color:red;'><b>Error in creating new listing!</b></span><br><br>";
                        }
                    }
                }
                ?>
                <form name="post_listing" action="post_listing.php" method="POST" enctype="multipart/form-data">
                    <label>Select Category <span>*</span></label>
                    <select required="" name="category">
                        <?php
                        $category_result = pg_query($db, "SELECT view_categories();");
                        $category_exists = pg_num_rows($category_result);
                        if ($category_exists > 0) {
                            $category_rows = pg_fetch_all($category_result);
                            foreach ($category_rows as $row) {
                                $category_json = json_decode($row[view_categories]);
                                echo "<option>$category_json->f1</option>";
                            }
                        }
                        ?>
                    </select>
                    <div class="clearfix"></div>
                    <label>Listing Title <span>*</span></label>
                    <input type="text" placeholder="Your listing title" required="" name="title">
                    <div class="clearfix"></div>
                    <label>Listing Description <span>*</span></label>
                    <textarea required="" name="description" placeholder="Write a few lines about your product"></textarea>
                    <div class="clearfix"></div>
                    <label>Price <span>*</span></label>
                    <input type='number' step="0.01" min="0" style=" padding: 9px 9px 9px 9px; width: 70%; margin-bottom: 20px; border:1px solid #3cc149;" required="" name="price" placeholder="Input a price $0.00 or more">
                    <div class="clearfix"></div>
                    <label>Pickup Location <span>*</span></label>
                    <input type='text' required="" name="pickup" placeholder="Your preferred pick-up address">
                    <div class="clearfix"></div>	
                    <label>Return Location <span>*</span></label>
                    <input type='text' required="" name="return" placeholder="Your preferred return address">
                    <div class="clearfix"></div>
                    <label>Start Date <span>*</span></label>
                    <input type='text' name="start_date" required="" class="form-control" placeholder="Start Date" id='datetimepicker1'/>
                    <div class="clearfix"></div>		
                    <label>End Date <span>*</span></label>
                    <input type='text' name="end_date" required="" class="form-control" placeholder="End Date" id='datetimepicker2'/>
                    <div class="clearfix"></div>	
                    <div class="upload-ad-photos">
                        <label>Photo of your listing :</label>	
                        <div class="photos-upload-view">
                            <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />

                            <div>
                                <input type="file" id="fileselect" name="fileselect" />
                                <div id="filedrag"></div>
                            </div>

                            <div id="submitbutton">
                                <button type="submit">Upload Files</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <script src="js/filedrag.js"></script>
                    </div>
                    <div class="clearfix"></div>	
                    <p text-align="center">
                        <input type="submit" name="post_listing" value="Post!">
                    </p>					
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>	
    </div>
    <!-- Content ends here -->
    <!--footer section start-->		
    <?php
    include 'includes/login/footer.php';
    ?>

    <!--footer section end-->
</body>
</html>
<?php
include 'includes/dbclose.php';
?>