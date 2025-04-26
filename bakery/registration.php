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
if(isset($_POST['submit']))
  {
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $contno=$_POST['mobilenumber'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $ret=mysqli_query($con, "select Email from tbluser where Email='$email' || MobileNumber='$contno'");
    $result=mysqli_fetch_array($ret);
    if($result>0){
$msg="This email or Contact Number already associated with another account";
    }
    else{
    $query=mysqli_query($con, "insert into tbluser(FirstName, LastName, MobileNumber, Email, Password) value('$fname', '$lname','$contno', '$email', '$password' )");
    if ($query) {
    $msg="You have successfully registered";
  }
  else
    {
      $msg="Something Went Wrong. Please try again";
    }
}
}

 ?>

<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Bakery House|| Sign Up</title>

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

        
    <script type="text/javascript">
function checkpass()
{
if(document.signup.password.value!=document.signup.repeatpassword.value)
{
alert('Password and Repeat Password field does not match');
document.signup.repeatpassword.focus();
return false;
}
return true;
} 

</script>
    </head>
    <body>
        
        
		<?php include_once('includes/header.php');?>
        
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>Registration Form</h3>
        			<ul>
        				<li><a href="index.php">Home</a></li>
        				<li><a href="registration.php">Sign Up</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        
        <section class="contact_form_area p_100">
        	<div class="container">
        		<div class="main_title">
					<h2>Regitration Form!!</h2>
					<h5>Fill below details.</h5>
				</div>
       			<div class="row">
       				<div class="col-lg-7">
                <p style="font-size:16px; color:red" align="center"> <?php if($msg){
    echo $msg;
  }  ?> </p>
       					<form class="row contact_us_form"action="" name="signup" method="post" onsubmit="return checkpass();">
							<div class="form-group col-md-6">
								<input type="text" class="form-control" name="firstname" required="true" placeholder="First Name" required="true">
							</div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required="true">
              </div>
              <div class="form-group col-md-6">
                <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" required="true" maxlength="10" pattern="[0-9]{10}" placeholder="Mobile Number" required="true">
              </div>
							<div class="form-group col-md-6">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email address" required="true">
							</div>
							
              <div class="form-group col-md-6">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="true">
              </div>
              <div class="form-group col-md-6">
                <input type="password" class="form-control" id="repeatpassword" name="repeatpassword" placeholder="Repeat password" required="true">
              </div>
							<div class="form-group col-md-12">
								<button type="submit" value="submit" name="submit" class="btn order_s_btn form-control">submit now</button>
							</div>
              <div class="form-group col-md-12">
                <a href="login.php" class="btn order_s_btn form-control"><i class="ft-user"></i> Login</a> <strong>Already Have an account!!!!</strong>
              </div>
						</form>
       				</div>
       				<div class="col-lg-4 offset-md-1">
       					<div class="contact_details">
       						<?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
       						<div class="contact_d_item">
       							<h3>Address :</h3>
       							<p><?php  echo $row['PageDescription'];?></p>
       						</div>
       						<div class="contact_d_item">
       							<h5>Phone : <?php  echo $row['MobileNumber'];?></h5>
       							<h5>Email : <?php  echo $row['Email'];?></h5>
       						</div>
       						
       					</div>
       				</div><?php } ?>
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