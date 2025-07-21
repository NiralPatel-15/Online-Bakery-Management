<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');

if (isset($_POST['submit'])) {
  $orderid = mysqli_real_escape_string($con, $_GET['oid']);
  $ressta = "Order Cancelled";
  $remark = mysqli_real_escape_string($con, $_POST['restremark']);
  $canclbyuser = 1;

  // Insert tracking info
  $query1 = mysqli_query($con, "INSERT INTO tbltracking (OrderId, remark, status, OrderCanclledByUser) 
                VALUES ('$orderid', '$remark', '$ressta', '$canclbyuser')");

  // Update final status
  $query2 = mysqli_query($con, "UPDATE tblorderaddresses 
                SET OrderFinalStatus='$ressta' 
                WHERE Ordernumber='$orderid'");

  if ($query1 && $query2) {
    echo "<script>
            $(document).ready(function() {
                showGlobalModal('Success', 'Order has been successfully cancelled.');
            });
        </script>";
  } else {
    echo "<script>
            $(document).ready(function() {
                showGlobalModal('Error', 'Something went wrong while cancelling the order.');
            });
        </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Cancel Order | Bakery House</title>
  <meta charset="UTF-8">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet"> <!-- Your main theme stylesheet -->
</head>

<body>

  <?php include_once('includes/header.php'); ?>

  <section class="banner_area">
    <div class="container">
      <div class="banner_text">
        <h3>Cancel Order</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Cancel Order</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="order_cancel_area p_100">
    <div class="container">
      <?php
      $orderid = $_GET['oid'];
      $query = mysqli_query($con, "SELECT Ordernumber, OrderFinalStatus FROM tblorderaddresses WHERE Ordernumber='$orderid'");
      $row = mysqli_fetch_array($query);
      $status = $row['OrderFinalStatus'];
      ?>

      <div class="mb-4">
        <h4>Cancel Order #<?php echo htmlspecialchars($orderid); ?></h4>
        <table class="table table-bordered mt-3">
          <tr>
            <th>Order Number</th>
            <th>Current Status</th>
          </tr>
          <tr>
            <td><?php echo htmlspecialchars($orderid); ?></td>
            <td>
              <?php
              if ($status == "") {
                echo "Waiting for confirmation";
              } else {
                echo $status;
              }
              ?>
            </td>
          </tr>
        </table>
      </div>

      <?php if ($status == "" || $status == "Order Accept") { ?>
        <form method="post">
          <div class="form-group">
            <label for="restremark"><strong>Reason for Cancellation:</strong></label>
            <textarea name="restremark" rows="6" class="form-control" required></textarea>
          </div>
          <button type="submit" name="submit" class="btn btn-danger">Cancel Order</button>
        </form>
      <?php } else { ?>
        <div class="alert alert-<?php echo $status == 'Order Cancelled' ? 'danger' : 'warning'; ?>">
          <?php
          if ($status == 'Order Cancelled') {
            echo "<strong>Note:</strong> Order is already cancelled.";
          } else {
            echo "<strong>Note:</strong> You can't cancel this order. It is either on the way or already delivered.";
          }
          ?>
        </div>
      <?php } ?>
    </div>
  </section>

  <?php include_once('includes/footer.php'); ?>

  <!-- Scripts -->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/theme.js"></script>

</body>

</html>