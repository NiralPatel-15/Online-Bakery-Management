<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$feedback = ''; // For styled popup

if (isset($_POST['submit'])) {
  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $contno = $_POST['mobilenumber'];
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $ret = mysqli_query($con, "SELECT Email FROM tbluser WHERE Email='$email' OR MobileNumber='$contno'");
  $result = mysqli_fetch_array($ret);
  if ($result > 0) {
    $feedback = 'warning|This email or Contact Number is already associated with another account!';
  } else {
    $query = mysqli_query($con, "INSERT INTO tbluser(FirstName, LastName, MobileNumber, Email, Password) VALUES('$fname', '$lname', '$contno', '$email', '$password')");
    if ($query) {
      $feedback = 'success|You have successfully registered!';
    } else {
      $feedback = 'error|Something went wrong. Please try again.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bakery House || Sign Up</title>

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

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript">
    function checkpass() {
      if (document.signup.password.value != document.signup.repeatpassword.value) {
        Swal.fire({
          icon: 'warning',
          title: 'Warning',
          text: 'Password and Repeat Password fields do not match!'
        });
        document.signup.repeatpassword.focus();
        return false;
      }
      return true;
    }
  </script>
</head>

<body>

  <?php include_once('includes/header.php'); ?>

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
        <h2>Registration Form</h2>
        <h5>Fill in your details below.</h5>
      </div>
      <div class="row">
        <div class="col-lg-7">
          <form class="row contact_us_form" action="" name="signup" method="post" onsubmit="return checkpass();">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="firstname" required placeholder="First Name">
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="lastname" required placeholder="Last Name">
            </div>
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="mobilenumber" required maxlength="10" pattern="[0-9]{10}" placeholder="Mobile Number">
            </div>
            <div class="form-group col-md-6">
              <input type="email" class="form-control" name="email" required placeholder="Email address">
            </div>
            <div class="form-group col-md-6">
              <input type="password" class="form-control" name="password" required placeholder="Password">
            </div>
            <div class="form-group col-md-6">
              <input type="password" class="form-control" name="repeatpassword" required placeholder="Repeat Password">
            </div>
            <div class="form-group col-md-12">
              <button type="submit" name="submit" class="btn order_s_btn form-control">Submit now</button>
            </div>
            <div class="form-group col-md-12">
              <a href="login.php" class="btn order_s_btn form-control"><i class="ft-user"></i> Login</a>
              <strong>Already have an account?</strong>
            </div>
          </form>
        </div>
        <div class="col-lg-4 offset-md-1">
          <div class="contact_details">
            <?php
            $ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='contactus'");
            while ($row = mysqli_fetch_array($ret)) {
            ?>
              <div class="contact_d_item">
                <h3>Address :</h3>
                <p><?php echo $row['PageDescription']; ?></p>
              </div>
              <div class="contact_d_item">
                <h5>Phone : <?php echo $row['MobileNumber']; ?></h5>
                <h5>Email : <?php echo $row['Email']; ?></h5>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once('includes/footer.php'); ?>

  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
  <script src="js/theme.js"></script>

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