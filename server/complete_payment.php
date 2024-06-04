<?php
session_start();
include('connection.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $order_status = "paid";
    $user_id = $_SESSION['user_id'];

    // Change order_status to paid in orders table
    $stmt = $conn->prepare("UPDATE `orders` SET `order_status`=? WHERE `user_id`=? AND `order_id`=?;");
    $stmt->bind_param('sii', $order_status, $user_id, $order_id);
    $res = $stmt->execute();
    echo $res;
    if ($res) {
        // Store payment info in payments table
        $stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id, order_status) VALUES (?, ?, ?)");
        $stmt1->bind_param('iis', $order_id, $user_id, $order_status);
        $stmt1->execute();

        // Redirect to user account with success message
        header("Location: ../account.php?payment_message=Payment successful, thanks for shopping");
        exit();
    } else {
        // Handle update failure
        header("Location: ../account.php?payment_message=Payment failed, please try again.");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
