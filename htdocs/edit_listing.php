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
//echo "my id is ".$id;
?>
<html>
<head>
	<title>ShareStuff - Edit Listing</title>
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
			<h2 class="head">Edit Listing</h2>
			<div class="post-ad-form">
				<?php
				if (isset($_POST['edit_listing'])) {
                	$category = $_POST['category'];
					$description = $_POST['description'];
					$price = $_POST['price'];
					$pickup = $_POST['pickup'];
					$return = $_POST['return'];
					$start_date = $_POST['start_date'];
					$end_date = $_POST['end_date'];
					$title = $_POST['title'];
					$input_status = $_POST['status'];
					$status = "";
					if($input_status == 'Available'){
						$status = 'true';
					}
					else if($input_status == 'Not Available'){
						$status = 'false';
					}
					$result = pg_query($db, "SELECT update_listing($id, '$title', $price, '$description', '$pickup', '$return', '$start_date', '$end_date', '$status','DEFAULT' ,'$category')");
					if($result == true){
						echo "<span style='color:green;'><b>Success in updating listing</b></span>";
						header( "refresh:1; url=my_account.php" ); 
					}
					else{
						echo "<span style='color:red;'><b>Error in updating new listing!</b></span>";
					}
				}
				if(isset($_POST['delete_listing'])){
					$result = pg_query($db, "SELECT delete_listing($id)");
					if($result == true){
						echo "<span style='color:green;'><b>Success in deleting listing!</b></span>";
						header( "refresh:1; url=my_account.php" ); 
					}
					else{
						echo "<span style='color:red;'><b>Error in deleting listing!</b></span>";
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
								<?php $curr_category = $json->category_name ?>
								<!-- <option>Select Category</option> -->
								<option value='Mobile Devices' <?php if($curr_category == "Mobile Devices") echo "selected";?> >Mobile Devices</option>
								<option value='Electronics & Appliances' <?php if($curr_category == "Electronics & Appliances") echo "selected";?>>Electronics & Appliances</option>
								<option value='Furniture' <?php if($curr_category == "Furniture") echo "selected";?> >Furniture</option>
								<option value='Pet Accessories' <?php if($curr_category == "Pet Accessories") echo "selected";?>>Pet Accessories</option>
								<option value='Books' <?php if($curr_category == "Books") echo "selected";?>>Books</option>
								<option value='Fashion' <?php if($curr_category == "Fashion") echo "selected";?>>Fashion</option>
								<option value='Kids' <?php if($curr_category == "Kids") echo "selected";?>>Kids</option>
								<option value='Sports & Hobbies' <?php if($curr_category == "Sports & Hobbies") echo "selected";?>>Sports & Hobbies</option>
							</select>
							<div class="clearfix"></div>
							<label>Listing Title <span>*</span></label>
							<input type="text" placeholder="Your listing title" required="" name="title" value="<?php echo $json->title; ?>" >
							<div class="clearfix"></div>
							<label>Listing Description <span>*</span></label>
							<textarea required="" name="description"><?php echo $json->description; ?></textarea>
							<div class="clearfix"></div>
							<label>Price <span>*</span></label>
							<!-- <input type='text' pattern='[0-9]' required="" name="price" value="<?php echo $json->price; ?>"> -->
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
							<label>Select Availability <span>*</span></label>
							<select required="" name="status">
								<option>Available</option>
								<option>Not Available</option>
							</select>
							<div class="clearfix"></div>	
							<p align="center">
								<input type="submit" style="background-color:#d31b0e; margin-right:20px;" name="delete_listing" value="Delete Listing"> 	
								<input type="submit" name="edit_listing" value="Edit"> 
							</p>
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