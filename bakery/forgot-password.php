<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
  $contactno = $_POST['contactno'];
  $email = $_POST['email'];
  $password = md5($_POST['newpassword']);

  $query = mysqli_query($con, "SELECT ID FROM tbluser WHERE Email='$email' AND MobileNumber='$contactno'");
  $ret = mysqli_num_rows($query);

  if ($ret > 0) {
    $_SESSION['contactno'] = $contactno;
    $_SESSION['email'] = $email;
    $query1 = mysqli_query($con, "UPDATE tbluser SET Password='$password' WHERE Email='$email' AND MobileNumber='$contactno' ");
    if ($query1) {
      echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Password successfully changed.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'login.php';
                    });
                });
            </script>";
    }
  } else {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid details. Please try again.'
                });
            });
        </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bakery House || Forgot Password</title>

  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="vendors/linearicons/style.css" rel="stylesheet">
  <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
  <link href="vendors/stroke-icon/style.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script type="text/javascript">
    function checkpass() {
      if (document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
        Swal.fire({
          icon: 'warning',
          title: 'Mismatch',
          text: 'New Password and Confirm Password do not match!'
        });
        document.changepassword.confirmpassword.focus();
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
        <h3>Reset Password</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="forgot-password.php">Forgot Password</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="contact_form_area p_100">
    <div class="container">
      <div class="main_title">
        <h2>Forgot Password!!</h2>
        <h5>Reset your password by filling in the details below.</h5>
      </div>
      <div class="row">
        <div class="col-lg-7">
          <form class="row contact_us_form" action="" method="post" name="changepassword" onsubmit="return checkpass();">
            <div class="form-group col-md-12">
              <input type="email" class="form-control" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="form-group col-md-12">
              <input type="text" class="form-control" name="contactno" placeholder="Contact Number" required pattern="[0-9]+">
            </div>
            <div class="form-group col-md-12">
              <input type="password" class="form-control" name="newpassword" placeholder="New Password" required>
            </div>
            <div class="form-group col-md-12" style="padding-top: 20px;">
              <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
            </div>
            <div class="form-group col-md-12">
              <button type="submit" name="submit" class="btn order_s_btn form-control">Reset</button>
            </div>
            <div class="form-group col-md-12">
              <a href="registration.php" class="btn order_s_btn form-control">Register</a>
              <strong>Register with us!!!!</strong>
            </div>
            <div class="form-group col-md-12">
              <a href="login.php" class="btn order_s_btn form-control">Login</a>
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
          </div>
        </div><?php } ?>
      </div>
    </div>
  </section>

  <?php include_once('includes/footer.php'); ?>

  <!-- Scripts -->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/theme.js"></script>
</body>

</html>