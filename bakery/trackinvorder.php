/*
 * This file is part of the Online Bakery Management System.
 * 
 * Copyright (c) 2025 Niral Patel
 * 
 * This project is licensed under the MIT License.
 * See the LICENSE file for more details.
 */

<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);


  ?>
<script language="javascript" type="text/javascript">
function f2()
{
window.close();
}
function f3()
{
window.print(); 
}
</script>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title> Bakery House || Track Order</title>

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
        
       
		<?php include_once('includes/header.php');?>
        
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>Track Order</h3>
        			<ul>
        				<li><a href="index.php">Home</a></li>
        				<li><a href="track-order.php">Track Order</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        
        <section class="contact_form_area p_100">
        	<div class="container">
        		<div class="main_title">
					<h2>Your Order Delivery Detail</h2>
					<h5>Your Order Deliver Status is shown as below.</h5>
				</div>
       			<div class="row">
       				

       				<?php  

$orderid=intval($_GET['oid']);
$ret=mysqli_query($con,"select tblordertracking.OrderCanclledByUser,tblordertracking.remark,tblordertracking.status as bstatus,tblordertracking.StatusDate from tblordertracking where tblordertracking.OrderId ='$orderid'");
$cnt=1;


 ?>
<table border="1"  cellpadding="10" style="border-collapse: collapse; border-spacing:0; width: 100%; text-align: center;">
  <tr align="center">
   <th colspan="4" >Tracking History of #<?php echo  $orderid;?></th> 
  </tr>
  <tr>
    <th>#</th>
<th>Remark</th>
<th>Status</th>
<th>Time</th>
</tr>
<?php  
while ($row=mysqli_fetch_array($ret)) { 
  $cancelledby=$row['OrderCanclledByUser'];
  ?>
<tr>
  <td><?php echo $cnt;?></td>
 <td><?php  echo $row['remark'];?></td> 
  <td><?php  echo $row['bstatus']; 
if($cancelledby==1){
echo "("."by user".")";
} else {

echo "("."by resturent".")";
}

  ?></td> 
   <td><?php  echo $row['StatusDate'];?></td> 
</tr>
<?php $cnt=$cnt+1;} ?>
</table>
     
 
       			</div>
        	</div>
        </section>
        
        
        
       
       <?php include_once('includes/footer.php');?>
        
       
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
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
       
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
        <script src="js/gmaps.min.js"></script>
        <script src="js/map-active.js"></script>
        
      
        <script src="js/jquery.form.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/contact.js"></script>
        
        <script src="js/theme.js"></script>
    </body>

</html>