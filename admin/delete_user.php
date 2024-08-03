<?php
require 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete user data
if ($user_id > 0) {
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: manage_users.php");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid user ID!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Delete User</h1>
        <p>Are you sure you want to delete this user?</p>
        <form method="post" action="delete_user.php?id=<?php echo $user_id; ?>">
            <button type="submit" class="btn btn-danger">Delete User</button>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>