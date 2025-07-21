<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

// Prepare SweetAlert2 feedback
$feedback = '';
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

  <script type="text/javascript">
    function f2() {
      window.close();
    }

    function f3() {
      window.print();
    }
  </script>
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
        <h2>Your Order Delivery Details</h2>
        <h5>Your order delivery status is shown below.</h5>
      </div>
      <div class="row">
        <?php
        $orderid = intval($_GET['oid']);
        $ret = mysqli_query($con, "SELECT OrderCanclledByUser, remark, status as bstatus, StatusDate FROM tblordertracking WHERE OrderId ='$orderid'");
        $num = mysqli_num_rows($ret);

        if ($num > 0) {
        ?>
          <div class="table-responsive">
            <table border="1" cellpadding="10" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th colspan="4">Tracking History of #<?php echo htmlentities($orderid); ?></th>
                </tr>
                <tr>
                  <th>#</th>
                  <th>Remark</th>
                  <th>Status</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
                  $cancelledby = $row['OrderCanclledByUser'];
                ?>
                  <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo htmlentities($row['remark']); ?></td>
                    <td>
                      <?php
                      echo htmlentities($row['bstatus']);
                      if ($cancelledby == 1) {
                        echo " (by user)";
                      } else if ($cancelledby == 2) {
                        echo " (by restaurant)";
                      }
                      ?>
                    </td>
                    <td><?php echo htmlentities($row['StatusDate']); ?></td>
                  </tr>
                <?php
                  $cnt++;
                } ?>
              </tbody>
            </table>
          </div>
        <?php
        } else {
          $feedback = "info|No tracking details found for this order yet!";
        }
        ?>
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