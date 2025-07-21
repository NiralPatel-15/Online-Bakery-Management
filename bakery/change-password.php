<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['fosuid']) == 0) {
  header('location:logout.php');
  exit();
}

$msg = "";

if (isset($_POST['submit'])) {
  $userid = $_SESSION['fosuid'];
  $currentpassword = mysqli_real_escape_string($con, $_POST['currentpassword']);
  $newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);

  // Secure hashing: Use password_hash instead of md5
  $query = mysqli_query($con, "SELECT Password FROM tbluser WHERE ID='$userid'");
  $row = mysqli_fetch_assoc($query);

  if ($row && password_verify($currentpassword, $row['Password'])) {
    $hashed_newpassword = password_hash($newpassword, PASSWORD_BCRYPT);
    $ret = mysqli_query($con, "UPDATE tbluser SET Password='$hashed_newpassword' WHERE ID='$userid'");

    // Destroy session and force logout
    session_destroy();
    header("Location: login.php?msg=" . urlencode("Password changed successfully, please log in again."));
    exit();
  } else {
    $msg = "Your current password is wrong";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bakery House || Change Password</title>

  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="vendors/linearicons/style.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">

  <script>
    function checkpass() {
      const newpass = document.changepassword.newpassword.value;
      const confirmpass = document.changepassword.confirmpassword.value;

      if (newpass !== confirmpass) {
        alert('New Password and Confirm Password do not match.');
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
        <h3>Change Password</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="change-password.php">Change Password</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="contact_form_area p_100">
    <div class="container">
      <div class="main_title">
        <h2>Change Password</h2>
        <h5>Secure your account with a new password.</h5>
      </div>
      <div class="row">
        <div class="col-lg-7">
          <?php if ($msg) : ?>
            <div class="alert alert-danger"><?php echo htmlentities($msg); ?></div>
          <?php endif; ?>

          <form class="row contact_us_form" method="post" name="changepassword" onsubmit="return checkpass();">
            <div class="form-group col-md-12">
              <label>Current Password</label>
              <input type="password" class="form-control" name="currentpassword" required>
            </div>
            <div class="form-group col-md-12">
              <label>New Password</label>
              <input type="password" class="form-control" name="newpassword" required>
            </div>
            <div class="form-group col-md-12">
              <label>Confirm New Password</label>
              <input type="password" class="form-control" name="confirmpassword" required>
            </div>
            <div class="form-group col-md-12">
              <button type="submit" name="submit" class="btn btn-primary w-100">Submit Now</button>
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
                <h3>Address:</h3>
                <p><?php echo htmlentities($row['PageDescription']); ?></p>
              </div>
              <div class="contact_d_item">
                <h5>Phone: <?php echo htmlentities($row['MobileNumber']); ?></h5>
                <h5>Email: <?php echo htmlentities($row['Email']); ?></h5>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once('includes/footer.php'); ?>

  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/theme.js"></script>
</body>

</html>