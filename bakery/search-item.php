<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$feedback = ''; // For SweetAlert2

if (isset($_POST['submit'])) {
  if (!isset($_SESSION['fosuid'])) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
  }

  $foodid = $_POST['foodid'];
  $userid = $_SESSION['fosuid'];
  $query = mysqli_query($con, "INSERT INTO tblorders(UserId, FoodId) VALUES('$userid','$foodid')");
  if ($query) {
    $feedback = 'success|Item has been added to the cart!';
  } else {
    $feedback = 'error|Something went wrong.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bakery House || Search</title>

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
        <h3>Search Items..</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="search-item.php">Search Items..</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="our_cakes_area p_100">
    <div class="container">
      <div class="main_title">
        <h2>Search Items..</h2>
        <form method="post">
          <div class="form-group col-md-12" style="padding-top: 20px;">
            <input type="text" class="form-control" id="searchkey" name="searchkey" placeholder="Search Items by name" required>
          </div>

          <div class="form-group col-md-12">
            <button type="submit" value="Search" name="search" class="btn order_s_btn form-control">Search</button>
          </div>
        </form>
      </div>

      <?php if (isset($_POST['search'])) {
        $searchkey = $_POST['searchkey'];
      ?>
        <h3 align="center">Search Result for "<?php echo htmlentities($searchkey); ?>"</h3>
        <hr />
        <div class="cake_feature_row row">
          <?php
          $ret = mysqli_query($con, "SELECT * FROM tblproduct WHERE ItemName LIKE '%$searchkey%'");
          $num = mysqli_num_rows($ret);
          if ($num > 0) {
            while ($row = mysqli_fetch_array($ret)) {
          ?>
              <div class="col-lg-3 col-md-4 col-6 mb-4">
                <div class="cake_feature_item text-center p-3" style="border:1px solid #eee; border-radius:8px;">
                  <div class="cake_img">
                    <img src="admin/itemimages/<?php echo htmlentities($row['Image']); ?>" width="100%" height="180" style="object-fit:cover;">
                  </div>
                  <div class="cake_text mt-3">
                    <h4>₹<?php echo htmlentities($row['ItemPrice']); ?></h4>
                    <h5><a href="product-detail.php?fid=<?php echo $row['ID']; ?>"><?php echo htmlentities($row['ItemName']); ?></a></h5>
                    <form method="post" style="margin-top: 10px;">
                      <input type="hidden" name="foodid" value="<?php echo $row['ID']; ?>">
                      <button type="submit" name="submit" class="btn btn-sm btn-success">Add to Cart</button>
                    </form>
                  </div>
                </div>
              </div>
            <?php }
          } else { ?>
            <div class="col-lg-12 text-center" style="font-size:26px; color:red;">
              No Record Found
            </div>
          <?php } ?>
        </div>
      <?php } ?>
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