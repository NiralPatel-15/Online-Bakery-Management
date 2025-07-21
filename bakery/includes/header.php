<?php
session_start();
include('includes/dbconnection.php');
$loggedIn = isset($_SESSION['fosuid']) ? $_SESSION['fosuid'] : false;

// Get cart count if logged in
$cartCount = 0;
if ($loggedIn) {
    $ret1 = mysqli_query($con, "SELECT * FROM tblorders WHERE IsOrderPlaced IS NULL AND UserId='$loggedIn'");
    $cartCount = mysqli_num_rows($ret1);
}
?>

<header class="main_header_area">
    <!-- ✅ Top Header -->
    <div class="top_header_area row m0">
        <div class="container">
            <div class="float-left">
                <a href="tel:+9876543210"><i class="fa fa-phone"></i> +9876543210</a>
                <a href="mailto:bakery@gmail.com"><i class="fa fa-envelope-o"></i> bakery@gmail.com</a>
            </div>
            <div class="float-right">
                <ul class="h_search list_style">
                    <li>
                        <a href="cart.php">
                            <i class="lnr lnr-cart">
                                <strong><?php echo $cartCount; ?></strong>
                            </i>
                        </a>
                    </li>
                    <li><a href="search-item.php"><i class="fa fa-search"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ✅ Main Menu -->
    <div class="main_menu_area">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <!-- Logo -->
                <a class="navbar-brand" href="index.php">
                    <img src="img/l5.jpg" alt="Bakery Logo">
                    <img src="img/left-logo.jpg" alt="Left Logo">
                </a>

                <!-- Toggle for mobile -->
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="my_toggle_menu">
                        <span></span><span></span><span></span>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Nav -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active"><a href="index.php">Home</a></li>
                        <li><a href="product.php">Our Products</a></li>
                        <li class="dropdown submenu">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product Category</a>
                            <ul class="dropdown-menu">
                                <?php
                                $ret = mysqli_query($con, "SELECT * FROM tblcategory");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                    <li>
                                        <a href="category-details.php?catname=<?php echo urlencode($row['CategoryName']); ?>">
                                            <?php echo $row['CategoryName']; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li><a href="about-us.php">About Us</a></li>
                    </ul>

                    <!-- Right Nav -->
                    <ul class="navbar-nav justify-content-end">
                        <?php if (!$loggedIn) { ?>
                            <li><a href="registration.php">Sign up</a></li>
                            <li><a href="login.php">Sign in</a></li>
                            <li><a href="track-order.php">Track Order</a></li>
                        <?php } else { ?>
                            <li class="dropdown submenu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Account</a>
                                <ul class="dropdown-menu">
                                    <li><a href="profile.php">Profile</a></li>
                                    <li><a href="change-password.php">Change Password</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            </li>
                            <li><a href="cart.php">Cart Page</a></li>
                            <li><a href="my-order.php">My Orders</a></li>
                        <?php } ?>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>