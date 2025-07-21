<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

$feedback = ''; // For SweetAlert2 message
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bakery House || Track Order</title>

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
</head>

<body>

  <?php include_once('includes/header.php'); ?>

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
        <h2>Track Your Order</h2>
        <h5>Track your order by your provided order number.</h5>
      </div>
      <div class="row">
        <div class="col-lg-7 mb-4">
          <form class="row contact_us_form" method="post">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" id="searchdata" name="searchdata" placeholder="Enter Order Number" required>
            </div>

            <div class="form-group col-md-12">
              <button type="submit" name="search" class="btn order_s_btn form-control">Submit Now</button>
            </div>
          </form>
        </div>

        <?php
        if (isset($_POST['search'])) {
          $sdata = $_POST['searchdata'];
        ?>
          <div class="col-lg-12">
            <h4 align="center">Result for "<?php echo htmlentities($sdata); ?>"</h4>
            <hr />
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>S.NO</th>
                    <th>Order Number</th>
                    <th>Order Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = mysqli_query($con, "SELECT * FROM tblorderaddresses WHERE Ordernumber LIKE '$sdata%'");
                  $num = mysqli_num_rows($ret);
                  if ($num > 0) {
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($ret)) {
                  ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo htmlentities($row['Ordernumber']); ?></td>
                        <td><?php echo htmlentities($row['OrderTime']); ?></td>
                        <td><a href="trackinvorder.php?oid=<?php echo $row['Ordernumber']; ?>">View Details</a></td>
                      </tr>
                    <?php
                      $cnt++;
                    }
                  } else {
                    $feedback = 'error|No record found against this order number!';
                    ?>
                    <!-- Empty row for layout, handled by SweetAlert -->
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php } ?>
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