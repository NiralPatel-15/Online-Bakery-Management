<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$feedback = ''; // Add this for styled popup

if (strlen($_SESSION['fosuid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $sid = $_SESSION['fosuid'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];

    $query = mysqli_query($con, "UPDATE tbluser SET FirstName='$fname', LastName='$lname' WHERE ID='$sid'");

    if ($query) {
      $feedback = 'success|Your profile has been updated!';
    } else {
      $feedback = 'error|Something went wrong. Please try again.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bakery House || Profile</title>

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

  <!-- SweetAlert2 for styled popup -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <?php include_once('includes/header.php'); ?>

  <section class="banner_area">
    <div class="container">
      <div class="banner_text">
        <h3>Profile</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="profile.php">User Profile</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="contact_form_area p_100">
    <div class="container">
      <div class="main_title">
        <h2>User Profile</h2>
        <h5>Update your profile!!!</h5>
      </div>
      <div class="row">
        <div class="col-lg-7">
          <form class="row contact_us_form" action="" method="post">
            <?php
            $pid = $_SESSION['fosuid'];
            $ret = mysqli_query($con, "SELECT * FROM tbluser WHERE ID='$pid'");
            while ($row = mysqli_fetch_array($ret)) {
            ?>
              <div class="form-group col-md-12">
                <label style="color: royalblue;">First Name</label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $row['FirstName']; ?>" required="true">
              </div>
              <div class="form-group col-md-12">
                <label style="color: royalblue;">Last Name</label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $row['LastName']; ?>" required="true">
              </div>
              <div class="form-group col-md-12">
                <label style="color: royalblue;">Email address</label>
                <input type="email" class="form-control" value="<?php echo $row['Email']; ?>" readonly="true">
              </div>
              <div class="form-group col-md-12">
                <label style="color: royalblue;">Mobile Number</label>
                <input type="text" class="form-control" value="<?php echo $row['MobileNumber']; ?>" readonly="true">
              </div>
              <div class="form-group col-md-12">
                <label style="color: royalblue;">Registration Date</label>
                <input type="text" class="form-control" value="<?php echo $row['RegDate']; ?>" readonly="true">
              </div>
            <?php } ?>
            <div class="form-group col-md-12">
              <button type="submit" name="submit" class="btn order_s_btn form-control">Submit now</button>
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