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
$id = $_GET['id'];
?>
<html>
    <head>
        <title>ShareStuff - Repost Listing</title>
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
                <h2 class="head">Repost Listing</h2>
                <div class="post-ad-form">
                    <?php
                    if (isset($_POST['repost_listing'])) {
                        $category = $_POST['category'];
                        $description = $_POST['description'];
                        $price = $_POST['price'];
                        $pickup = $_POST['pickup'];
                        $return = $_POST['return'];
                        $start_date = $_POST['start_date'];
                        $end_date = $_POST['end_date'];
                        $title = $_POST['title'];
                        $curr_user = $_SESSION['username'];
                        if (!isset($_FILES['fileselect']) || $_FILES['fileselect']['error'] == UPLOAD_ERR_NO_FILE) {
                            $result = pg_query($db, "SELECT create_listing('$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', '','$category', '$curr_user')");
                        } else {
                            $filename = 'images/' . $_FILES['fileselect']['name'];
                            $result = pg_query($db, "SELECT create_listing('$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', '$filename','$category', '$curr_user')");
                        }
                        if ($result == true) {
                            header("refresh:1; url=my_account.php");
                            echo "<span style='color:green;'><b>Success in reposting new listing!</b></span><br><br>";
                        } else {
                            echo "<span style='color:red;'><b>Error in reposting new listing!</b></span><br><br>";
                        }
                    }
                    ?>
                    <?php
                    $result = pg_query($db, "SELECT view_listing($id)");
                    $exists = pg_num_rows($result);
                    if ($exists == 1) {
                        $rows = pg_fetch_all($result);
                        foreach ($rows as $row) {
                            $json = json_decode($row[view_listing]);
                            ?>

                            <form name="edit_listing" action="" method="POST">
                                <label>Select Category <span>*</span></label>
                                <select required="" name="category">
                                    <?php
                                    $curr_category = $json->category_name;
                                    $category_result = pg_query($db, "SELECT view_categories();");
                                    $category_exists = pg_num_rows($category_result);
                                    if ($category_exists > 0) {
                                        $category_rows = pg_fetch_all($category_result);
                                        foreach ($category_rows as $row) {
                                            $category_json = json_decode($row[view_categories]);
                                            if ($curr_category == $category_json->f1) {
                                                echo "<option selected>$category_json->f1</option>";
                                            } else {
                                                echo "<option>$category_json->f1</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="clearfix"></div>
                                <label>Listing Title <span>*</span></label>
                                <input type="text" placeholder="Your listing title" required="" name="title" value="<?php echo $json->title; ?>" >
                                <div class="clearfix"></div>
                                <label>Listing Description <span>*</span></label>
                                <textarea required="" name="description"><?php echo $json->description; ?></textarea>
                                <div class="clearfix"></div>
                                <label>Price <span>*</span></label>
                                <input type='number' step="0.01" min="0" style=" padding: 9px 9px 9px 9px; width: 70%; margin-bottom: 20px; border:1px solid #5c9649;" required="" name="price" value="<?php echo $json->price; ?>">
                                <div class="clearfix"></div>
                                <label>Pickup Location <span>*</span></label>
                                <input type='text' required="" name="pickup" value="<?php echo $json->pickup_location; ?>">
                                <div class="clearfix"></div>	
                                <label>Return Location <span>*</span></label>
                                <input type='text' required="" name="return" value="<?php echo $json->return_location; ?>">
                                <div class="clearfix"></div>
                                <label>Start Date <span>*</span></label>
                                <input type='text' name="start_date" required="" class="form-control" value="<?php echo $json->start_date; ?>" id='datetimepicker1'/>
                                <div class="clearfix"></div>		
                                <label>End Date <span>*</span></label>
                                <input type='text' name="end_date" required="" class="form-control" value="<?php echo $json->end_date; ?>" id='datetimepicker2'/>
                                <div class="clearfix"></div>	
                                <div class="upload-ad-photos">
                                    <label>Photos of your listing :</label>	
                                    <div class="photos-upload-view">
                                        <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />

                                        <div>
                                            <input type="file" id="fileselect" name="fileselect" />
                                            <div id="filedrag">or drop files here</div>
                                        </div>

                                        <div id="submitbutton">
                                            <button type="submit">Upload Files</button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <script src="js/filedrag.js"></script>
                                </div>
                                <div class="clearfix"></div>
                                <div style="text-align: center;">
                                    <span style="display: inline;">
                                        <a href="javascript:history.back();" class="btn btn-default" style="width:30%; padding: 10px 0;" role="button">CANCEL</a>
                                        <input type="submit" name="repost_listing" style="width:30%; font-size: 14px; float: none;" value="Repost">
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </form>
                            <?php
                        }
                    }
                    ?>
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