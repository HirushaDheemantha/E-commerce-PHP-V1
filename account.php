<?php 
session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location:login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];

    if ($password !== $confirm_password) {
        header('location: account.php?error=Password does not match!');
        exit();
    } else if (strlen($password) < 6) {
        header('location: account.php?error=Password should be more than 6 characters!');
        exit();
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt->bind_param('ss', md5($password), $user_email);

        if ($stmt->execute()) {
            header('location:account.php?message=Password update successful');
            exit();
        } else {
            header('location:account.php?error=Password update failed');
            exit();
        }
    }
}

// Get user orders
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<?php include('assets/layouts/header.php'); ?>

<section class="my-5 py-5">
    <div class="row container mx-auto">
    <?php if(isset($_GET['payment_message'])){?>
        <p class='mt-5 text-center' style="color:green"><?php echo $_GET['payment_message'];?></p>
        <?php } ?>


        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <h3 class="font-weight-bold">Account info</h3>
            <hr class="mx-auto">
            <div class="account-info">
                <p>Name <span><?php if (isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } ?></span></p>
                <p>Email <span><?php if (isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></span></p>
                <p><a href="#orders" id="order-btn">Your Orders</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <form id="account-form" method="POST" action="account.php">
                <p class='text-center' style="color:red"><?php if (isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                <p class='text-center' style="color:green"><?php if (isset($_GET['message'])) { echo $_GET['message']; } ?></p>
                <h3>Change Password</h3>
                <br>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="account-password" placeholder="Password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" placeholder="Password" name="confirmPassword" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn">
                </div>
            </form>
        </div>
    </div>
</section>

<section id='orders' class="orders container my-5 py-3">
    <div class="container mt-2">
        <h3 class="text-center">Your Orders</h3>
        <hr class="mx-auto">

        <table class="mt-5 pt-5">
            <tr>
                <th>Order ID</th>
                <th>Order Cost</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Order Details</th>
            </tr>

            <?php if ($orders): ?>
                <?php while ($row = $orders->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <div>
                                    <p class="mt-3"><?php echo $row['order_id']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span><?php echo $row['order_cost']; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row['order_status']; ?></span>
                        </td>
                        <td>
                            <span><?php echo $row['order_date']; ?></span>
                        </td>
                        <td>
                            <form action="order_details.php" method="POST">
                                <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                                <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                                <input type="submit" class="btn order-details-btn" name="order_details_btn" value="Details">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No orders found</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</section>

<?php include('assets/layouts/footer.php'); ?>
