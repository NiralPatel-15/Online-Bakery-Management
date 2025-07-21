<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid'] == 0)) {
    header('location:logout.php');
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Bakery House || My Order</title>

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
        <link href="vendors/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="vendors/nice-select/css/nice-select.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            .swal2-popup {
                width: 80% !important;
                max-width: 800px;
            }

            .swal2-html-container {
                padding: 0 !important;
            }

            .swal2-iframe {
                width: 100%;
                height: 500px;
                border: none;
            }
        </style>

        <script>
            function showTrackOrderPopup(oid) {
                Swal.fire({
                    title: 'Track Order #' + oid,
                    html: '<iframe src="trackorder.php?oid=' + oid + '" class="swal2-iframe"></iframe>',
                    showCloseButton: true,
                    showConfirmButton: false,
                    width: '800px',
                    padding: '1em'
                });
            }
        </script>

    </head>

    <body>

        <?php include_once('includes/header.php'); ?>

        <section class="banner_area">
            <div class="container">
                <div class="banner_text">
                    <h3>My Order</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="my-order.php">My Order</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="cart_table_area p_100">
            <div class="container">
                <div class="table-responsive">
                    <h4 style="color: palevioletred; text-align: center;">Your Order Detail</h4>

                    <table class="table" style="padding-top: 20px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Order Date and Time</th>
                                <th>Order Status</th>
                                <th>Track Order</th>
                                <th>View Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $userid = $_SESSION['fosuid'];
                            $query = mysqli_query($con, "SELECT * FROM tblorderaddresses WHERE UserId='$userid'");
                            $cnt = 1;
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td><?php echo $row['Ordernumber']; ?></td>
                                    <td><?php echo $row['OrderTime']; ?></td>
                                    <td><?php echo $row['OrderFinalStatus'] ?: 'Waiting for confirmation'; ?></td>
                                    <td>
                                        <button onclick="showTrackOrderPopup('<?php echo htmlentities($row['Ordernumber']); ?>')" class="btn btn-info btn-sm">
                                            <i class="fa fa-motorcycle"></i> Track Order
                                        </button>
                                    </td>
                                    <td>
                                        <a href="order-detail.php?orderid=<?php echo $row['Ordernumber']; ?>" class="btn theme-btn-dash btn-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php $cnt++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <?php include_once('includes/footer.php'); ?>

        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>

        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
        <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
        <script src="vendors/isotope/isotope.pkgd.min.js"></script>
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>

        <script src="js/theme.js"></script>
    </body>

    </html>
<?php } ?>