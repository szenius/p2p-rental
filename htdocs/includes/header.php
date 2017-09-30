<div class="container">
    <div class="logo">
        <a href="index.php"><span>Share</span>Stuff</a>
    </div>
    <div class="header-right">
    	<?php 
    	if(isset($_SESSION['username']) || !empty($_SESSION['username'])){
    		echo '<a class="account" href="login.php">My Account:'.$_SESSION['username'].'</a>';
    	}
    	else{
    		echo '<a class="account" href="login.php">Login</a>';
    	}
    	?>
        <!-- Large modal -->
    </div>
</div>