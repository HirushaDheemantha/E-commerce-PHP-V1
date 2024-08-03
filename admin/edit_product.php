<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    // Handle file uploads
    $images = [];
    for ($i = 0; $i <= 3; $i++) {
        if (isset($_FILES["image$i"]) && $_FILES["image$i"]['error'] == UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image$i"]["name"]);
            if (move_uploaded_file($_FILES["image$i"]["tmp_name"], $target_file)) {
                $images["product_image$i"] = $target_file;
            }
        }
    }

    $sql = "UPDATE products SET product_name = ?, product_description = ?, product_price = ?, product_quantity = ?, product_category = ?";
    $params = [$name, $description, $price, $quantity, $category];

    foreach ($images as $key => $value) {
        $sql .= ", $key = ?";
        $params[] = $value;
    }

    $sql .= " WHERE product_id = ?";
    $params[] = $id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Product updated successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Product</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo htmlspecialchars($product['product_quantity']); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" class="form-control" value="<?php echo htmlspecialchars($product['product_category']); ?>" required>
            </div>
            <?php for ($i = 0; $i <= 3; $i++): ?>
                <div class="form-group">
                    <label for="image<?php echo $i; ?>">Image <?php echo $i + 1; ?>:</label>
                    <input type="file" id="image<?php echo $i; ?>" name="image<?php echo $i; ?>" class="form-control">
                    <?php if (!empty($product["product_image$i"])): ?>
                        <img src="<?php echo htmlspecialchars($product["product_image$i"]); ?>" alt="Product Image <?php echo $i + 1; ?>" style="width: 150px; height: auto; margin-top: 10px;">
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</body>
</html>
