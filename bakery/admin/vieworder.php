<?php
session_start();
include('includes/dbconnection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['fosaid']) || strlen($_SESSION['fosaid']) == 0) {
  header('location:logout.php');
  exit();
}

$msg = '';            // Prevent undefined variable warning
$grandtotal = 0;      // Prevent undefined variable warning

if (isset($_POST['submit'])) {
  $oid = $_GET['orderid'];
  $ressta = $_POST['status'];
  $remark = $_POST['restremark'];

  $insertTracking = mysqli_query($con, "INSERT INTO tblordertracking (orderId, status, remark) VALUES ('$oid', '$ressta', '$remark')
");


  $updateStatus = mysqli_query($con, "UPDATE tblorderaddresses SET OrderFinalStatus='$ressta' WHERE Ordernumber='$oid'");

  if ($insertTracking && $updateStatus) {
    $_SESSION['popup_message'] = 'Order has been updated successfully';
    $_SESSION['popup_type'] = 'success';
  } else {
    $_SESSION['popup_message'] = 'Something went wrong. Please try again';
    $_SESSION['popup_type'] = 'error';
  }

  header("Location: " . $_SERVER['PHP_SELF'] . "?orderid=" . urlencode($oid));
  exit();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Bakery House</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
  <link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <?php if (isset($_SESSION['popup_message'])) { ?>
    <script>
      Swal.fire({
        icon: "<?php echo $_SESSION['popup_type']; ?>",
        title: "<?php echo ($_SESSION['popup_type'] === 'success') ? 'Success' : 'Error'; ?>",
        text: "<?php echo $_SESSION['popup_message']; ?>",
      });
    </script>
  <?php
    unset($_SESSION['popup_message']);
    unset($_SESSION['popup_type']);
  } ?>

  <div id="wrapper">
    <?php include_once('includes/leftbar.php'); ?>
    <div id="page-wrapper" class="gray-bg">
      <?php include_once('includes/header.php'); ?>
      <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
          <h2>Order Details #<?php echo $_GET['orderid']; ?></h2>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item">Order Detail</li>
            <li class="breadcrumb-item active"><strong>Update</strong></li>
          </ol>
        </div>
      </div>

      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox">
              <div class="ibox-content">
                <?php
                $oid = $_GET['orderid'];
                $ret = mysqli_query($con, "SELECT * FROM tblorderaddresses JOIN tbluser ON tbluser.ID=tblorderaddresses.UserId WHERE tblorderaddresses.Ordernumber='$oid'");
                while ($row = mysqli_fetch_array($ret)) {
                ?>
                  <div class="row">
                    <div class="col-6">
                      <table border="1" class="table table-bordered mg-b-0">
                        <tr align="center">
                          <td colspan="2" style="font-size:20px;color:blue">User Details</td>
                        </tr>
                        <tr>
                          <th>Order Number</th>
                          <td><?php echo $row['Ordernumber']; ?></td>
                        </tr>
                        <tr>
                          <th>First Name</th>
                          <td><?php echo $row['FirstName']; ?></td>
                        </tr>
                        <tr>
                          <th>Last Name</th>
                          <td><?php echo $row['LastName']; ?></td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td><?php echo $row['Email']; ?></td>
                        </tr>
                        <tr>
                          <th>Mobile Number</th>
                          <td><?php echo $row['MobileNumber']; ?></td>
                        </tr>
                        <tr>
                          <th>Flat no./buldng no.</th>
                          <td><?php echo $row['Flatnobuldngno']; ?></td>
                        </tr>
                        <tr>
                          <th>StreetName</th>
                          <td><?php echo $row['StreetName']; ?></td>
                        </tr>
                        <tr>
                          <th>Area</th>
                          <td><?php echo $row['Area']; ?></td>
                        </tr>
                        <tr>
                          <th>Land Mark</th>
                          <td><?php echo $row['Landmark']; ?></td>
                        </tr>
                        <tr>
                          <th>City</th>
                          <td><?php echo $row['City']; ?></td>
                        </tr>
                        <tr>
                          <th>Order Date</th>
                          <td><?php echo $row['OrderTime']; ?></td>
                        </tr>
                        <tr>
                          <th>Order Final Status</th>
                          <td><?php echo $row['OrderFinalStatus'] ?: 'Wait for restaurants approval'; ?></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-6" style="margin-top:2%">
                      <?php
                      $query = mysqli_query($con, "SELECT tblproduct.Image, tblproduct.ItemName, tblproduct.ItemDes, tblproduct.ItemPrice, tblproduct.ItemQty, tblorders.FoodId, tblorders.CashonDelivery FROM tblorders JOIN tblproduct ON tblproduct.ID=tblorders.FoodId WHERE tblorders.IsOrderPlaced=1 AND tblorders.OrderNumber='$oid'");
                      $cnt = 1;
                      ?>
                      <table border="1" class="table table-bordered mg-b-0">
                        <tr align="center">
                          <td colspan="4" style="font-size:20px;color:blue">Order Details</td>
                        </tr>
                        <tr>
                          <th>#</th>
                          <th>Item Image</th>
                          <th>Item Name</th>
                          <th>Delivery Type</th>
                          <th>Price</th>
                        </tr>
                        <?php
                        while ($row1 = mysqli_fetch_array($query)) {
                          $total = $row1['ItemPrice'];
                          $grandtotal += $total;
                        ?>
                          <tr>
                            <td><?php echo $cnt++; ?></td>
                            <td><img src="itemimages/<?php echo $row1['Image']; ?>" width="60" height="40"></td>
                            <td><?php echo $row1['ItemName']; ?></td>
                            <td><?php echo $row1['CashonDelivery']; ?></td>
                            <td>₹<?php echo $total; ?></td>
                          </tr>
                        <?php } ?>
                        <tr>
                          <th colspan="4" style="text-align:right">Grand Total</th>
                          <td>₹<?php echo $grandtotal; ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <?php if (in_array($row['OrderFinalStatus'], ["Order Confirmed", "Order being Prepared", "Order Pickup", ""])) { ?>
                    <form name="submit" method="post">
                      <table class="table mb-0">
                        <tr>
                          <th>Restaurant Remark:</th>
                          <td><textarea name="restremark" rows="4" class="form-control" required></textarea></td>
                        </tr>
                        <tr>
                          <th>Restaurant Status:</th>
                          <td><select name="status" class="form-control" required>
                              <option value="Order Confirmed">Order Confirmed</option>
                              <option value="Order Cancelled">Order Cancelled</option>
                              <option value="Order being Prepared">Order being Prepared</option>
                              <option value="Order Pickup">Order Pickup</option>
                              <option value="Order Delivered">Order Delivered</option>
                            </select></td>
                        </tr>
                        <tr align="center">
                          <td colspan="2"><button type="submit" name="submit" class="btn btn-primary">Update order</button></td>
                        </tr>
                      </table>
                    </form>
                  <?php } ?>

                  <?php
                  $ret = mysqli_query($con, "SELECT remark, status as fstatus, StatusDate FROM tblordertracking WHERE OrderId='$oid'");
                  if (mysqli_num_rows($ret) > 0) {
                  ?>
                    <table class="table table-bordered">
                      <tr align="center">
                        <th colspan="4">Cake Tracking History</th>
                      </tr>
                      <tr>
                        <th>#</th>
                        <th>Remark</th>
                        <th>Status</th>
                        <th>Time</th>
                      </tr>
                      <?php
                      $cnt = 1;
                      while ($row = mysqli_fetch_array($ret)) {
                      ?>
                        <tr>
                          <td><?php echo $cnt++; ?></td>
                          <td><?php echo $row['remark']; ?></td>
                          <td><?php echo $row['fstatus']; ?></td>
                          <td><?php echo $row['StatusDate']; ?></td>
                        </tr>
                      <?php } ?>
                    </table>
                  <?php } ?>

                <?php } // end while 
                ?>

              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include_once('includes/footer.php'); ?>
    </div>
  </div>

  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/inspinia.js"></script>
  <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/steps/jquery.steps.min.js"></script>
  <script src="js/plugins/validate/jquery.validate.min.js"></script>
</body>

</html>