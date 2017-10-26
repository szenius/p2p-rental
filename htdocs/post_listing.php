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
?>
<html>
<head>
	<title>ShareStuff - Post Listing</title>
	<?php
	include 'includes/plugins.php';
	?>
</head>
<script>
  $(document).ready(function () {
    $('#datetimepicker1').datetimepicker({
		format: 'dd MM yyyy',
		minView: 2,
		startView: 2
    });
        $('#datetimepicker2').datetimepicker({
		format: 'dd MM yyyy',
		minView: 2,
		startView: 2    
	});
  });
</script>
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
					$category = $_POST['category'];
					$description = $_POST['description'];
					$price = $_POST['price'];
					$pickup = $_POST['pickup'];
					$return = $_POST['return'];
					$start_date = $_POST['start_date'];
					$end_date = $_POST['end_date'];
					$title = $_POST['title'];
					$curr_user = $_SESSION['username'];
					if(!isset($_FILES['fileselect']) || $_FILES['fileselect']['error'] == UPLOAD_ERR_NO_FILE) {
						//echo "<b>NO FILE ATTACHED</b>";
						$result = pg_query($db, "SELECT create_listing('$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', '','$category', '$curr_user')");
   					}
   					else{
   						$filename='images/'.$_FILES['fileselect']['name'];
						//echo $filename;
						$result = pg_query($db, "SELECT create_listing('$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', '$filename','$category', '$curr_user')");
   					}
					if($result == true){
						echo "<span style='color:green;'><b>Success in creating new listing!</b></span>";
						header( "refresh:1; url=my_account.php" ); 					
					}
					else{
						echo "<span style='color:red;'><b>Error in creating new listing!</b></span>";
					}

				}
				?>
				<form name="post_listing" action="post_listing.php" method="POST" enctype="multipart/form-data">
					<label>Select Category <span>*</span></label>
					<select required="" name="category">
						<!-- <option>Select Category</option> -->
						<option>Mobile Devices</option>
						<option>Electronics & Appliances</option>
						<option>Furniture</option>
						<option>Pet Accessories</option>
						<option>Books</option>
						<option>Fashion</option>
						<option>Kids</option>
						<option>Sports & Hobbies</option>
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