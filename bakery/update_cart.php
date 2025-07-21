<?php
session_start();
include_once('includes/dbconnection.php');

if (isset($_POST['order_id']) && isset($_POST['action'])) {
    $orderId = intval($_POST['order_id']);
    $action = $_POST['action'];

    $query = mysqli_query($con, "
        SELECT tblorders.ItemQty, tblproduct.ID AS ProductID, tblproduct.ItemQty AS StockQty, tblproduct.ItemPrice
        FROM tblorders 
        JOIN tblproduct ON tblorders.FoodId = tblproduct.ID
        WHERE tblorders.ID = '$orderId'
    ");
    $row = mysqli_fetch_assoc($query);

    if (!$row) {
        echo json_encode(['status' => 'error', 'message' => 'Item not found!']);
        exit;
    }

    $currentQty = $row['ItemQty'];
    $productID = $row['ProductID'];
    $stockQty = $row['StockQty'];
    $itemPrice = $row['ItemPrice'];

    if ($action === 'increase' && $stockQty > 0) {
        $newQty = $currentQty + 1;
        $newStockQty = $stockQty - 1;
    } elseif ($action === 'decrease' && $currentQty > 1) {
        $newQty = $currentQty - 1;
        $newStockQty = $stockQty + 1;
    } else {
        echo json_encode(['status' => 'info', 'message' => 'Cannot update quantity further.']);
        exit;
    }

    // Update cart
    mysqli_query($con, "UPDATE tblorders SET ItemQty='$newQty' WHERE ID='$orderId'");
    // Update stock
    mysqli_query($con, "UPDATE tblproduct SET ItemQty='$newStockQty' WHERE ID='$productID'");

    $updatedTotal = number_format($itemPrice * $newQty, 2);

    echo json_encode([
        'status' => 'success',
        'newQty' => $newQty,
        'updatedTotal' => $updatedTotal,
        'message' => 'Cart updated!'
    ]);
}
