<?php
session_start();
include_once 'includes/dbconnection.php';
error_reporting(0);

// Prepare SweetAlert2 feedback
$feedback = '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Bakery House - Track Order</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

<body class="p-4">

  <div class="container">
    <?php
    $orderid = intval($_GET['oid']);
    $ret = mysqli_query($con, "SELECT OrderCanclledByUser, remark, status AS bstatus, StatusDate FROM tblordertracking WHERE OrderId ='$orderid'");
    $num = mysqli_num_rows($ret);

    if ($num > 0) {
    ?>
      <div class="text-center mb-4">
        <h4 class="fw-bold">Tracking History of Order #<?php echo htmlentities($orderid); ?></h4>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead class="table-dark">
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
                  } elseif ($cancelledby == 2) {
                    echo " (by restaurant)";
                  }
                  ?>
                </td>
                <td><?php echo htmlentities($row['StatusDate']); ?></td>
              </tr>
            <?php
              $cnt++;
            }
            ?>
          </tbody>
        </table>
      </div>
      <div class="mt-4 text-center">
        <button class="btn btn-secondary me-2" onclick="return f2();">Close</button>
        <button class="btn btn-primary" onclick="return f3();">Print</button>
      </div>
    <?php
    } else {
      $feedback = "info|No tracking history found for this order!";
    }
    ?>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <?php
  if (!empty($feedback)) {
    list($icon, $message) = explode('|', $feedback);
    echo "<script>
    Swal.fire({
      icon: '$icon',
      title: 'Info',
      text: '$message',
      confirmButtonColor: '#3085d6'
    }).then(() => { window.close(); });
    </script>";
  }
  ?>
</body>

</html>