<?php
require 'db_connect.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<a href="admin_dashboard.php" class="btn btn-secondary mt-4 mx-5">Dashboard</a>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Users</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['user_email']; ?></td>
                            <td><?php echo $row['user_password']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found</td>
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
