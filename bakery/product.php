/*
 * This file is part of the Online Bakery Management System.
 * 
 * Copyright (c) 2025 Niral Patel
 * 
 * This project is licensed under the MIT License.
 * See the LICENSE file for more details.
 */

<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    if (!isset($_SESSION['fosuid'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit();
    }

    $foodid = $_POST['foodid'];
    $userid = $_SESSION['fosuid'];

    // Check available stock before adding to cart
    $check_stock = mysqli_query($con, "SELECT ItemQty FROM tblproduct WHERE ID = '$foodid'");
    $row = mysqli_fetch_assoc($check_stock);
    $current_stock = intval($row['ItemQty']);

    if ($current_stock > 0) {
        // Insert order into tblorders
        $query = mysqli_query($con, "INSERT INTO tblorders(UserId, FoodId) VALUES('$userid','$foodid')");

        if ($query) {
            // Deduct 1 from stock
            $new_stock = $current_stock - 1;
            mysqli_query($con, "UPDATE tblproduct SET ItemQty = '$new_stock' WHERE ID = '$foodid'");

            echo "<script>alert('Item has been added to the cart');</script>";
        } else {
            echo "<script>alert('Something went wrong.');</script>";
        }
    } else {
        echo "<script>alert('Sorry, this item is out of stock.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bakery House || Product Details</title>

    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/linearicons/style.css" rel="stylesheet">
    <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
    <link href="vendors/stroke-icon/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/revolution/css/settings.css" rel="stylesheet">
    <link href="vendors/revolution/css/layers.css" rel="stylesheet">
    <link href="vendors/revolution/css/navigation.css" rel="stylesheet">
    <link href="vendors/animate-css/animate.css" rel="stylesheet">
    <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
    <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
</head>

<body>

    <?php include_once('includes/header.php'); ?>

    <section class="banner_area">
        <div class="container">
            <div class="banner_text">
                <h3>Our Products</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product.php">Products</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="our_cakes_area p_100">
        <div class="container">
            <div class="main_title">
                <h2>Our Products</h2>
                <h5>Bakery Products include bread, rolls, cookies, pies, pastries, and muffins. They are usually prepared from flour or meal derived from grains and cooked by dry heat, especially in an oven.</h5>
            </div>
            <div class="cake_feature_row row">
                <?php
                // Pagination Setup
                $page_no = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
                $total_records_per_page = 12;
                $offset = ($page_no - 1) * $total_records_per_page;

                $result_count = mysqli_query($con, "SELECT COUNT(*) AS total_records FROM tblproduct");
                $total_records = mysqli_fetch_array($result_count)['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);

                $ret = mysqli_query($con, "SELECT * FROM tblproduct LIMIT $offset, $total_records_per_page");
                while ($row = mysqli_fetch_array($ret)) {
                    $stock = intval($row['ItemQty']); // Get available stock
                ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="cake_feature_item">
                            <div class="cake_img">
                                <img src="admin/itemimages/<?php echo $row['Image']; ?>" width="400" height="180">
                            </div>
                            <div class="cake_text">
                                <h4>₹<?php echo $row['ItemPrice']; ?></h4>
                                <h3><a href="product-detail.php?fid=<?php echo $row['ID']; ?>"><?php echo $row['ItemName']; ?></a></h3>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>


            <!-- Pagination -->
            <ul class="pagination">
                <li class="<?php echo ($page_no <= 1) ? 'disabled' : ''; ?>">
                    <a <?php if ($page_no > 1) echo "href='?page_no=" . ($page_no - 1) . "'"; ?>>« Previous</a> 
                </li>

                <?php for ($counter = 1; $counter <= $total_no_of_pages; $counter++) { ?>
                    <li class="<?php echo ($counter == $page_no) ? 'active' : ''; ?>">
                        <a href="?page_no=<?php echo $counter; ?>"> &nbsp;<?php echo $counter; ?></a>
                    </li>
                <?php } ?>

                &nbsp;
                <li class="<?php echo ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                    <a <?php if ($page_no < $total_no_of_pages) echo "href='?page_no=" . ($page_no + 1) . "'"; ?>>Next »</a>
                </li>
            </ul>


        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <!-- JS Scripts -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
    <script src="js/theme.js"></script>

</body>

</html>