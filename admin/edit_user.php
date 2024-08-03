<?php
require 'db_connect.php';
// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch user data
if ($user_id > 0) {
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and update user data
    if (!empty($name) && !empty($email)) {
        $sql = "UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $password, $user_id);
        if ($stmt->execute()) {
            echo "User updated successfully";
        } else {
            echo "Error updating user: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Name and Email are required!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post" action="edit_user.php?id=<?php echo $user_id; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>