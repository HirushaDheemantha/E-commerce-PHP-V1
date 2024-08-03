<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Update this with your database username
$password = "";     // Update this with your database password
$dbname = "php_project"; // Update this with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch order details
$sql = "SELECT order_id, order_cost, order_status, user_id, user_phone, user_email, user_city, user_address, order_date FROM orders";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<a href="admin_dashboard.php" class="btn btn-secondary mt-4 mx-5">Dashboard</a>
    <div class="container mt-5">
        <h1 class="mb-4">Order Details</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Cost</th>
                        <th>Order Status</th>
                        <th>User ID</th>
                        <th>User Phone</th>
                        <th>User Email</th>
                        <th>User City</th>
                        <th>User Address</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_cost']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_city']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['order_id']); ?>">
                                    <button type="submit" name="delete_order" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>

        <!-- Dashboard Button -->
        
    </div>
</body>
</html>

<?php
// Handle form submission to delete an order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order'])) {
    $order_id = intval($_POST['order_id']);

    // Delete query
    $delete_sql = "DELETE FROM orders WHERE order_id = $order_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<div class='alert alert-success'>Order deleted successfully!</div>";
        // Refresh the page to reflect changes
        header("Refresh: 2; url=order_details.php");
    } else {
        echo "<div class='alert alert-danger'>Error deleting order: " . $conn->error . "</div>";
    }
}

// Close connection
$conn->close();
?>