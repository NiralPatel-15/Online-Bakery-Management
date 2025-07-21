<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');

if (strlen($_SESSION['fosuid'] == 0)) {
	header('location:logout.php');
} else {
	// Delete product from cart
	if (isset($_GET['delid'])) {
		$rid = intval($_GET['delid']);
		mysqli_query($con, "DELETE FROM tblorders WHERE ID='$rid'");
		echo "<script>
			document.addEventListener('DOMContentLoaded', function() {
				Swal.fire('Deleted!', 'Product removed from cart.', 'success').then(() => {
					window.location.href = 'cart.php';
				});
			});
		</script>";
	}

	// Place order
	if (isset($_POST['placeorder'])) {
		$fnaobno = $_POST['flatbldgnumber'];
		$street = $_POST['streename'];
		$area = $_POST['area'];
		$lndmark = $_POST['landmark'];
		$city = $_POST['city'];
		$userid = $_SESSION['fosuid'];

		$orderno = mt_rand(100000000, 999999999);
		$query = "UPDATE tblorders SET OrderNumber='$orderno', IsOrderPlaced='1' WHERE UserId='$userid' AND IsOrderPlaced IS NULL;";
		$query .= "INSERT INTO tblorderaddresses(UserId, Ordernumber, Flatnobuldngno, StreetName, Area, Landmark, City) 
		           VALUES('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";

		$result = mysqli_multi_query($con, $query);
		if ($result) {
			echo "<script>
				document.addEventListener('DOMContentLoaded', function() {
					Swal.fire('Success!', 'Your order placed successfully. Order number: $orderno', 'success').then(() => {
						window.location.href = 'my-order.php';
					});
				});
			</script>";
		}
	}
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>Bakery House || Cart Page</title>
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="vendors/linearicons/style.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="css/responsive.css" rel="stylesheet">
	</head>

	<body>
		<?php include_once('includes/header.php'); ?>

		<section class="banner_area">
			<div class="container">
				<div class="banner_text">
					<h3>Cart</h3>
					<ul>
						<li><a href="index.php">Home</a></li>
						<li><a href="cart.php">Cart</a></li>
					</ul>
				</div>
			</div>
		</section>

		<section class="cart_table_area p_100">
			<div class="container">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Preview</th>
								<th>Product</th>
								<th>Price</th>
								<th>Weight</th>
								<th>Quantity</th>
								<th>Total</th>
								<th>Remove</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$userid = $_SESSION['fosuid'];
							$query = mysqli_query($con, "SELECT tblproduct.Image, tblproduct.ItemName, tblproduct.Weight, tblproduct.ItemPrice, tblorders.ItemQty, tblorders.ID 
						FROM tblorders JOIN tblproduct ON tblproduct.ID = tblorders.FoodId 
						WHERE tblorders.UserId='$userid' AND tblorders.IsOrderPlaced IS NULL");

							$num = mysqli_num_rows($query);
							$grandtotal = 0;

							if ($num > 0) {
								while ($row = mysqli_fetch_array($query)) {
									$total = $row['ItemPrice'] * $row['ItemQty'];
									$grandtotal += $total;
							?>
									<tr>
										<td><img src="admin/itemimages/<?php echo $row['Image']; ?>" width="100" height="80"></td>
										<td><?php echo $row['ItemName']; ?></td>
										<td>₹<?php echo $row['ItemPrice']; ?></td>
										<td><?php echo $row['Weight']; ?></td>
										<td>
											<button class="qty-btn minus" data-id="<?php echo $row['ID']; ?>">-</button>
											<span id="qty-<?php echo $row['ID']; ?>"><?php echo $row['ItemQty']; ?></span>
											<button class="qty-btn plus" data-id="<?php echo $row['ID']; ?>">+</button>
										</td>
										<td>₹ <?php echo $total; ?></td>
										<td>
											<a href="#" class="delete-btn" data-id="<?php echo $row['ID']; ?>">
												<i class="fa fa-trash fa-delete" aria-hidden="true"></i>
											</a>
										</td>
									</tr>
							<?php
								}
							} else {
								echo "<tr><td colspan='7'>Your cart is empty.</td></tr>";
							}
							?>
						</tbody>
					</table>
				</div>

				<div class="row cart_total_inner">
					<div class="col-lg-7"></div>
					<div class="col-lg-5">
						<div class="cart_total_text">
							<div class="cart_head">Cart Total</div>
							<div class="sub_total">
								<h5>Sub Total <span>₹<?php echo $grandtotal; ?></span></h5>
							</div>
							<div class="total">
								<h4>Total <span>₹<?php echo $grandtotal; ?></span></h4>
							</div>
							<div class="cart_footer">
								<a id="proceedCheckoutBtn" class="pest_btn" href="checkout.php">Proceed to Checkout</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php include_once('includes/footer.php'); ?>

		<script src="js/jquery-3.2.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function() {
				const grandTotal = <?php echo $grandtotal; ?>;

				// SweetAlert for delete confirmation
				document.querySelectorAll(".delete-btn").forEach(btn => {
					btn.addEventListener("click", function(e) {
						e.preventDefault();
						const id = this.getAttribute("data-id");
						Swal.fire({
							title: 'Are you sure?',
							text: 'Do you want to remove this product from your cart?',
							icon: 'warning',
							showCancelButton: true,
							confirmButtonText: 'Yes, delete it!',
							cancelButtonText: 'No, cancel!',
							confirmButtonColor: '#d33',
							cancelButtonColor: '#3085d6'
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = 'cart.php?delid=' + id;
							}
						});
					});
				});

				// Prevent checkout if cart is empty
				document.getElementById('proceedCheckoutBtn').addEventListener('click', function(e) {
					if (grandTotal <= 0) {
						e.preventDefault();
						Swal.fire('Cart is Empty', 'Please add at least 1 item to proceed to checkout.', 'info');
					}
				});

				// Qty update handler
				document.querySelectorAll(".qty-btn").forEach(button => {
					button.addEventListener("click", function() {
						let orderId = this.getAttribute("data-id");
						let action = this.classList.contains("plus") ? "increase" : "decrease";
						let qtyElement = document.getElementById("qty-" + orderId);

						fetch("update_cart.php", {
								method: "POST",
								headers: {
									"Content-Type": "application/x-www-form-urlencoded"
								},
								body: `order_id=${orderId}&action=${action}`
							})
							.then(response => response.json())
							.then(data => {
								if (data.status === "success") {
									qtyElement.textContent = data.newQty;
									location.reload();
								} else {
									Swal.fire('Error', data.message, 'error');
								}
							})
							.catch(err => console.error(err));
					});
				});
			});
		</script>
	</body>

	</html>
<?php } ?>