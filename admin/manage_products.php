<?php
require 'db_connect.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<a href="admin_dashboard.php" class="btn btn-secondary mt-4 mx-5">Dashboard</a>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Products</h1>
        <a href="add_product.php" class="btn btn-primary mb-4">Add New Product</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['product_description']; ?></td>
                            <td><?php echo $row['product_price']; ?></td>
                            <td><?php echo $row['product_quantity']; ?></td>
                            <td><?php echo $row['product_category']; ?></td>
                            <td>
                                <?php for ($i = 0; $i <= 3; $i++): ?>
                                    <?php if (!empty($row["product_image$i"])): ?>
                                        <img src="<?php echo htmlspecialchars($row["product_image$i"]); ?>" alt="Product Image <?php echo $i + 1; ?>" class="product-image">
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
