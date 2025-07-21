<?php
session_start();
include('includes/dbconnection.php');

$feedback = ''; // To store popup message

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

            $_SESSION['feedback'] = "success|Item has been added to the cart";
        } else {
            $_SESSION['feedback'] = "error|Something went wrong.";
        }
    } else {
        $_SESSION['feedback'] = "warning|Sorry, this item is out of stock.";
    }

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Load feedback message if available
if (isset($_SESSION['feedback'])) {
    $feedback = $_SESSION['feedback'];
    unset($_SESSION['feedback']);
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

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .product-card {
            border: 1px solid #eee;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card .cake_img img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .product-card .cake_text {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            text-align: center;
        }

        .product-card .cake_text h4 {
            margin-bottom: 10px;
        }

        .product-card .cake_text h5 {
            margin-bottom: 10px;
            min-height: 40px;
        }

        .product-card .btn,
        .product-card .badge {
            margin-top: auto;
        }
    </style>
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
                <h5>Bakery Products include bread, rolls, cookies, pies, pastries, and muffins.</h5>
            </div>
            <div class="cake_feature_row row">
                <?php
                $page_no = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
                $total_records_per_page = 12;
                $offset = ($page_no - 1) * $total_records_per_page;

                $result_count = mysqli_query($con, "SELECT COUNT(*) AS total_records FROM tblproduct");
                $total_records = mysqli_fetch_array($result_count)['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);

                $ret = mysqli_query($con, "SELECT * FROM tblproduct LIMIT $offset, $total_records_per_page");
                while ($row = mysqli_fetch_array($ret)) {
                    $stock = intval($row['ItemQty']);
                ?>
                    <div class="col-lg-3 col-md-4 col-6 mb-4 d-flex">
                        <div class="product-card w-100">
                            <div class="cake_img">
                                <img src="admin/itemimages/<?php echo $row['Image']; ?>" alt="">
                            </div>
                            <div class="cake_text">
                                <h4>₹<?php echo $row['ItemPrice']; ?></h4>
                                <h5>
                                    <?php if ($stock > 0) { ?>
                                        <a href="product-detail.php?fid=<?php echo $row['ID']; ?>"><?php echo htmlspecialchars($row['ItemName']); ?></a>
                                    <?php } else { ?>
                                        Out of Stock
                                    <?php } ?>
                                </h5>

                                <?php if ($stock > 0) { ?>
                                    <form method="post">
                                        <input type="hidden" name="foodid" value="<?php echo $row['ID']; ?>">
                                        <button type="submit" name="submit" class="btn btn-sm btn-success">Add to Cart</button>
                                    </form>
                                <?php } else { ?>
                                    <span class="badge badge-danger">Out of Stock</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item <?php echo ($page_no <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" <?php if ($page_no > 1) echo "href='?page_no=" . ($page_no - 1) . "'"; ?>>« Previous</a>
                </li>

                <?php for ($counter = 1; $counter <= $total_no_of_pages; $counter++) { ?>
                    <li class="page-item <?php echo ($counter == $page_no) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page_no=<?php echo $counter; ?>"><?php echo $counter; ?></a>
                    </li>
                <?php } ?>

                <li class="page-item <?php echo ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" <?php if ($page_no < $total_no_of_pages) echo "href='?page_no=" . ($page_no + 1) . "'"; ?>>Next »</a>
                </li>
            </ul>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <?php
    if (!empty($feedback)) {
        list($type, $message) = explode('|', $feedback);
        echo "<script>
        Swal.fire({
            icon: '$type',
            title: '" . ucfirst($type) . "',
            text: '$message',
            confirmButtonColor: '#3085d6'
        });
        </script>";
    }
    ?>
</body>

</html>