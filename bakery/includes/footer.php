<?php
include('includes/dbconnection.php');

// Ensure session is started only if not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(0);
?>

<!--================Newsletter Area =================-->
<section class="newsletter_area">
    <div class="container">
        <div class="row newsletter_inner">
            <div class="col-lg-6">
                <div class="news_left_text">
                    <h4>Join our Newsletter list to get all the latest offers, discounts and other benefits</h4>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="newsletter_form">
                    <form method="post">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email address" name="email" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" value="submit" name="sub">
                                    Subscribe Now
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['sub'])) {
                        $email = $_POST['email'];

                        $query = mysqli_query($con, "INSERT INTO tblsubscriber (Email) VALUES ('$email')");
                        if ($query) {
                            echo "<script>
                                $(document).ready(function(){
                                    showGlobalModal(
                                        'Subscription Successful!',
                                        '🎉 Thank you for subscribing to Bakery House! You will now receive our latest offers.',
                                        '<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>'
                                    );
                                });
                            </script>";
                        } else {
                            echo "<script>
                                $(document).ready(function(){
                                    showGlobalModal('Error', 'Something went wrong. Please try again.');
                                });
                            </script>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Newsletter Area =================-->

<!--================Footer Area =================-->
<footer class="footer_area">
    <div class="footer_widgets">
        <div class="container">
            <div class="row footer_wd_inner">
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_about_widget">
                        <img src="img/mf.jpg" alt="">
                        <?php
                        $ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='aboutus'");
                        while ($row = mysqli_fetch_array($ret)) {
                        ?>
                            <p><?php echo $row['PageDescription']; ?>.</p>
                        <?php } ?>
                        <ul class="nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_link_widget">
                        <div class="f_title">
                            <h3>Quick Links</h3>
                        </div>
                        <ul class="list_style">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="product.php">Our Products</a></li>
                            <li><a href="about-us.php">About Us</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                            <?php if (empty($_SESSION['fosuid'])) { ?>
                                <li><a href="registration.php">Sign Up</a></li>
                                <li><a href="login.php">Sign In</a></li>
                                <li><a href="cart.html">Track Order</a></li>
                            <?php } else { ?>
                                <li><a href="cart.php">Cart Page</a></li>
                                <li><a href="orders.php">My Orders</a></li>
                            <?php } ?>
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_link_widget">
                        <div class="f_title">
                            <h3>Work Times</h3>
                        </div>
                        <ul class="list_style">
                            <li><a href="#">Mon - Sun: 8 AM - 11:30 PM</a></li>
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-3 col-6">
                    <aside class="f_widget f_contact_widget">
                        <div class="f_title">
                            <h3>Contact Info</h3>
                        </div>
                        <h4>Phone: 3110021004</h4>
                        <p>Address:<br />#590 Sunrise Bakery Lane, Bilimora</p>
                        <h5>Email: bakery@gmail.com</h5>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_copyright">
        <div class="container">
            <div class="copyright_inner">
                <div class="float-left">
                    <h5><a target="_blank" href="index.php"> Bakery House </a></h5>
                </div>
                <div class="float-right">
                    <a href="index.php">Home Page</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--================End Footer Area =================-->

<!-- ===============================
     Bakery House Global Custom Modal
     =============================== -->
<div class="modal fade bakery-modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="globalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="globalModalLabel">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Dynamic content will appear here -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- ===============================
     Scripts
     =============================== -->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- ===============================
     Global Modal Helper Script
     =============================== -->
<script>
    /**
     * Bakery House Global Modal Function
     * @param {string} title - Modal title
     * @param {string} message - Modal body content (HTML allowed)
     * @param {string} [footer] - Optional custom footer buttons
     */
    function showGlobalModal(title, message, footer = '') {
        $('#globalModalLabel').html(title);
        $('#globalModal .modal-body').html(message);

        if (footer) {
            $('#globalModal .modal-footer').html(footer);
        } else {
            $('#globalModal .modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>');
        }

        $('#globalModal').modal('show');
    }
</script>