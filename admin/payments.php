
<?php
require 'db_connect.php';
// Handle form submission to update order status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $payment_id = intval($_POST['payment_id']);
    $new_status = $conn->real_escape_string($_POST['order_status']);

    // Update query
    $update_sql = "UPDATE payments SET order_status = '$new_status' WHERE payment_id = $payment_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "<div class='alert alert-success'>Order status updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating order status: " . $conn->error . "</div>";
    }
}

// SQL query to fetch payments
$sql = "SELECT payment_id, order_id, user_id, order_status FROM payments";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<a href="admin_dashboard.php" class="btn btn-secondary mt-4 mx-5">Dashboard</a>
    <div class="container mt-5">
        <h1 class="mb-4">Payments</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Order Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['payment_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($row['payment_id']); ?>">
                                    <select name="order_status" class="form-control">
                                        <option value="paid" <?php if ($row['order_status'] == 'paid') echo 'selected'; ?>>Paid</option>
                                        <option value="delivered" <?php if ($row['order_status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                                        <option value="not paid" <?php if ($row['order_status'] == 'not paid') echo 'selected'; ?>>Not Paid</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary mt-2">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No payments found.</p>
        <?php endif; ?>
    </div>
    
</body>
</html>

<?php
// Close connection
$conn->close();
?>