<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $foodid = mysqli_real_escape_string($con, $_POST['foodid']);
    $userid = $_SESSION['fosuid'];
    if (!$userid) {
        echo "<script>showGlobalModal('Login Required', 'Please login to add items to cart.');</script>";
    } else {
        $query = mysqli_query($con, "INSERT INTO tblorders(UserId, FoodId) VALUES ('$userid', '$foodid')");
        if ($query) {
            echo "<script>showGlobalModal('Success', 'Item has been added to the cart.');</script>";
        } else {
            echo "<script>showGlobalModal('Error', 'Something went wrong.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bakery House || Product Details</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/linearicons/style.css" rel="stylesheet">
    <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
    <link href="vendors/stroke-icon/style.css" rel="stylesheet">
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
                <h3>Our Category</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="product.php">Category Details</a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="our_cakes_area p_100">
        <div class="container">
            <div class="main_title">
                <h2>Category: <?php echo htmlspecialchars($_GET['catname']); ?></h2>
                <h5>From soft cakes to crispy cookies—pure delight in every bite!</h5>
            </div>

            <div class="cake_feature_row row">
                <?php
                $cname = mysqli_real_escape_string($con, $_GET['catname']);
                $page_no = isset($_GET['page_no']) && $_GET['page_no'] != "" ? intval($_GET['page_no']) : 1;
                $total_records_per_page = 12;
                $offset = ($page_no - 1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;
                $adjacents = "2";

                $result_count = mysqli_query($con, "SELECT COUNT(*) AS total_records FROM tblproduct WHERE CategoryName='$cname'");
                $total_records = mysqli_fetch_array($result_count)['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                $second_last = $total_no_of_pages - 1;

                $ret = mysqli_query($con, "SELECT * FROM tblproduct WHERE CategoryName='$cname' LIMIT $offset, $total_records_per_page");
                while ($row = mysqli_fetch_array($ret)) {
                ?>
                    <div class="col-lg-3 col-md-4 col-6 mb-4">
                        <div class="cake_feature_item">
                            <div class="cake_img">
                                <img src="admin/itemimages/<?php echo htmlspecialchars($row['Image']); ?>" alt="<?php echo htmlspecialchars($row['ItemName']); ?>" class="img-fluid">
                            </div>
                            <div class="cake_text text-center">
                                <h4>₹<?php echo $row['ItemPrice']; ?></h4>
                                <h3><a href="product-detail.php?fid=<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['ItemName']); ?></a></h3>
                                <form method="post" style="margin-top:10px;">
                                    <input type="hidden" name="foodid" value="<?php echo $row['ID']; ?>">
                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page_no <= 1) echo 'disabled'; ?>">
                    <a class="page-link" <?php if ($page_no > 1) echo "href='?catname=$cname&page_no=$previous_page'"; ?>>Previous</a>
                </li>
                <?php
                if ($total_no_of_pages <= 10) {
                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                        echo "<li class='page-item " . ($counter == $page_no ? 'active' : '') . "'>
                            <a class='page-link' href='?catname=$cname&page_no=$counter'>$counter</a></li>";
                    }
                } elseif ($total_no_of_pages > 10) {
                    if ($page_no <= 4) {
                        for ($counter = 1; $counter < 8; $counter++) {
                            echo "<li class='page-item " . ($counter == $page_no ? 'active' : '') . "'>
                                <a class='page-link' href='?catname=$cname&page_no=$counter'>$counter</a></li>";
                        }
                        echo "<li class='page-item'><a class='page-link'>...</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=$second_last'>$second_last</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=1'>1</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=2'>2</a></li>";
                        echo "<li class='page-item'><a class='page-link'>...</a></li>";
                        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                            echo "<li class='page-item " . ($counter == $page_no ? 'active' : '') . "'>
                                <a class='page-link' href='?catname=$cname&page_no=$counter'>$counter</a></li>";
                        }
                        echo "<li class='page-item'><a class='page-link'>...</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=$second_last'>$second_last</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=1'>1</a></li>";
                        echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=2'>2</a></li>";
                        echo "<li class='page-item'><a class='page-link'>...</a></li>";
                        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                            echo "<li class='page-item " . ($counter == $page_no ? 'active' : '') . "'>
                                <a class='page-link' href='?catname=$cname&page_no=$counter'>$counter</a></li>";
                        }
                    }
                }
                ?>
                <li class="page-item <?php if ($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) echo "href='?catname=$cname&page_no=$next_page'"; ?>>Next</a>
                </li>
                <?php if ($page_no < $total_no_of_pages) {
                    echo "<li class='page-item'><a class='page-link' href='?catname=$cname&page_no=$total_no_of_pages'>Last</a></li>";
                } ?>
            </ul>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>