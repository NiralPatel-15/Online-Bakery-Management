<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');

if (strlen($_SESSION['fosuid'] == 0)) {
  header('location:logout.php');
} else {
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Bakery House - Invoice</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      table {
        border-collapse: collapse;
        width: 90%;
        margin: 0 auto;
      }

      table,
      th,
      td {
        border: 1px solid #333;
        text-align: center;
        padding: 10px;
      }

      th {
        background: #f5f5f5;
      }

      .btns {
        margin: 20px auto;
        width: 200px;
        text-align: center;
      }

      .btns button {
        margin: 5px;
        padding: 10px 20px;
        background: #ff7f50;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 4px;
      }

      .btns button:hover {
        background: #ff5722;
      }

      h2 {
        text-align: center;
      }
    </style>
  </head>

  <body>

    <?php
    $oid = $_GET['oid'];
    $query = mysqli_query($con, "
  SELECT tblorderaddresses.OrderTime, tblproduct.Image, tblproduct.ItemName, tblproduct.Weight, tblproduct.ItemPrice, tblorders.FoodId, tblorders.OrderNumber
  FROM tblorders
  JOIN tblproduct ON tblproduct.ID = tblorders.FoodId
  JOIN tblorderaddresses ON tblorderaddresses.Ordernumber = tblorders.OrderNumber
  WHERE tblorders.OrderNumber = '$oid' AND tblorders.IsOrderPlaced = 1
");
    $cnt = 1;
    $grandtotal = 0;
    ?>

    <h2>Invoice #<?php echo htmlspecialchars($oid); ?></h2>

    <table>
      <tr>
        <th colspan="2">Order Date:</th>
        <td colspan="3"><?php echo htmlspecialchars($_GET['odate']); ?></td>
      </tr>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Item Name</th>
        <th>Weight</th>
        <th>Price</th>
      </tr>
      <?php while ($row = mysqli_fetch_array($query)) { ?>
        <tr>
          <td><?php echo $cnt; ?></td>
          <td><img src="admin/itemimages/<?php echo $row['Image']; ?>" width="60" height="40" alt=""></td>
          <td><?php echo htmlspecialchars($row['ItemName']); ?></td>
          <td><?php echo htmlspecialchars($row['Weight']); ?></td>
          <td>₹<?php echo $total = $row['ItemPrice']; ?></td>
        </tr>
      <?php
        $grandtotal += $total;
        $cnt++;
      } ?>
      <tr>
        <th colspan="4">Grand Total</th>
        <td>₹<?php echo $grandtotal; ?></td>
      </tr>
    </table>

    <div class="btns">
      <button onclick="confirmClose()">Close</button>
      <button onclick="confirmPrint()">Print</button>
    </div>

    <script>
      function confirmClose() {
        Swal.fire({
          title: 'Are you sure?',
          text: "Do you really want to close this invoice?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, Close it!',
          cancelButtonText: 'Cancel',
        }).then((result) => {
          if (result.isConfirmed) {
            window.close();
          }
        });
      }

      function confirmPrint() {
        Swal.fire({
          title: 'Print Invoice',
          text: "Do you want to print this invoice?",
          icon: 'info',
          showCancelButton: true,
          confirmButtonText: 'Yes, Print it!',
          cancelButtonText: 'Cancel',
        }).then((result) => {
          if (result.isConfirmed) {
            window.print();
          }
        });
      }
    </script>

  </body>

  </html>

<?php } ?>