<div class="container">
    <div class="logo">
        <a href="index.php"><span>Share</span>Stuff</a>
    </div>
    <div class="header-right">
        <?php
        if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
            ?>
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="login.php">
                    Welcome, <?php echo $_SESSION['username']; ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="my_account.php">View Profile</a></li>
                    <li><a href="edit_profile.php?username=<?php echo $_SESSION['username']; ?>">Edit Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <?php
        } else {
            echo '<a class="account" href="login.php">Login</a>';
        }
        ?>
        <!-- Large modal -->
    </div>
</div>