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
error_reporting(0);

include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title> Bakery House|| About Us</title>

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

        
    </head>
    <body>
        
        
		<?php include_once('includes/header.php');?>
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>About Us</h3>
        			<ul>
        				<li><a href="index.php">Home</a></li>
        				<li><a href="about-us.php">About Us</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        
        <section class="our_bakery_area p_100">
        	<div class="container">
        		<?php

$ret=mysqli_query($con,"select * from tblpage where PageType='aboutus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
        		<div class="our_bakery_text">
        			<h2><?php  echo $row['PageTitle'];?></h2>
								<p><?php  echo $row['PageDescription'];?></p>
        		</div><?php } ?>
        		<div class="row our_bakery_image">
        			<div class="col-md-4 col-6">
        				<img class="img-fluid" src="img/our-bakery/bakery-4.jpg" alt="">
        			</div>
        			<div class="col-md-4 col-6">
        				<img class="img-fluid" src="img/our-bakery/bakery-5.jpg" alt="">
        			</div>
        			<div class="col-md-4 col-6">
        				<img class="img-fluid" src="img/our-bakery/bakery-6.jpg" alt="">
        			</div>
        		</div>
        	</div>
        </section>
        
        
   <?php include_once('includes/footer.php');?>
    
        <script src="js/jquery-3.2.1.min.js"></script>
        
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Rev slider js -->
        <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <!-- Extra plugin js -->
        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
        
        <script src="js/theme.js"></script>
    </body>

</html>