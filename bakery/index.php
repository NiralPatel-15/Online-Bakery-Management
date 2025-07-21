<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Add SweetAlert2 results
$popupMessage = '';
$popupIcon = '';

if (isset($_POST['submit'])) {
    $foodid = intval($_POST['foodid']);
    $userid = intval($_SESSION['fosuid']);

    // Check available stock
    $stock_query = mysqli_query($con, "SELECT ItemQty FROM tblproduct WHERE ID='$foodid'");
    $row = mysqli_fetch_assoc($stock_query);

    if ($row && $row['ItemQty'] > 0) {
        // Insert order if stock is available
        $query = mysqli_query($con, "INSERT INTO tblorders(UserId, FoodId) VALUES('$userid', '$foodid')");
        if ($query) {
            // Reduce stock count by 1
            mysqli_query($con, "UPDATE tblproduct SET ItemQty = ItemQty - 1 WHERE ID='$foodid'");
            $popupMessage = 'Item has been added to the cart!';
            $popupIcon = 'success';
        } else {
            $popupMessage = 'Something went wrong.';
            $popupIcon = 'error';
        }
    } else {
        $popupMessage = 'Sorry, this item is out of stock.';
        $popupIcon = 'warning';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bakery House || Home Page</title>

    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/linearicons/style.css" rel="stylesheet">
    <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/revolution/css/settings.css" rel="stylesheet">
    <link href="vendors/revolution/css/layers.css" rel="stylesheet">
    <link href="vendors/revolution/css/navigation.css" rel="stylesheet">
    <link href="vendors/animate-css/animate.css" rel="stylesheet">
    <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
    <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include_once('includes/header.php'); ?>

    <!-- Slider & Content as is -->

    <section class="welcome_bakery_area">
        <div class="container">
            <div class="welcome_bakery_inner p_100">
                <div class="row">
                    <div class="col-lg-6">
                        <?php
                        $ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='aboutus'");
                        while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <div class="main_title">
                                <h2><?php echo $row['PageTitle']; ?></h2>
                                <p><?php echo $row['PageDescription']; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6">
                        <div class="welcome_img">
                            <img class="img-fluid" src="img/cake-feature/welcome-right.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="cake_feature_inner">
                <div class="main_title">
                    <h2>Our Featured Products</h2>
                    <h5>Taste the magic! Our featured delights are handpicked for you.</h5>
                </div>
                <div class="cake_feature_slider owl-carousel">
                    <?php
                    $ret = mysqli_query($con, "SELECT * FROM tblproduct");
                    while ($row = mysqli_fetch_array($ret)) {
                    ?>
                        <div class="item">
                            <div class="cake_feature_item">
                                <div class="cake_img">
                                    <img src="admin/itemimages/<?php echo $row['Image']; ?>" width="400" height="180">
                                </div>
                                <div class="cake_text">
                                    <h4>₹ <?php echo $row['ItemPrice']; ?></h4>
                                    <h3><a href="product-detail.php?fid=<?php echo $row['ID']; ?>"><?php echo $row['ItemName']; ?></a></h3>
                                    <form method="post" style="margin-top:10px;">
                                        <input type="hidden" name="foodid" value="<?php echo $row['ID']; ?>">
                                        <button type="submit" name="submit" class="btn order_s_btn">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <?php include_once('includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
    <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
    <script src="vendors/datetime-picker/js/moment.min.js"></script>
    <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
    <script src="vendors/lightbox/simpleLightbox.min.js"></script>
    <script src="js/theme.js"></script>

    <?php if ($popupMessage != '') { ?>
        <script>
            Swal.fire({
                icon: '<?php echo $popupIcon; ?>',
                title: '<?php echo ($popupIcon == "success") ? "Success" : "Notice"; ?>',
                text: '<?php echo $popupMessage; ?>',
                confirmButtonText: 'OK'
            });
        </script>
    <?php } ?>
</body>

</html>