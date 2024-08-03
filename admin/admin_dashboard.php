<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Admin Dashboard</h1>
        <div class="list-group">
            <a href="manage_products.php" class="list-group-item list-group-item-action">Manage Products</a>
            <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="payments.php" class="list-group-item list-group-item-action">Payments</a>
            <a href="order_items.php" class="list-group-item list-group-item-action">Order Items</a>
        </div>
        <a href="login.php"><button class="submit" style="padding: 5px 10px;">Log out</button></a>
    </div>

</body>
</html>
