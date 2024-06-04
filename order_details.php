<?php
session_start();

include('server/connection.php');

if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];
    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $order_details = $stmt->get_result();

    // Calculate total order amount
    $total = 0;
    while ($row = $order_details->fetch_assoc()) {
        $total += $row['product_price'] * $row['product_quantity'];
    }

    // Store total in session
    $_SESSION['total'] = $total;
} else {
    header("location: account.php");
    exit;
}
?>

<?php include('assets/layouts/header.php'); ?>

<section id='orders' class="orders container my-5 py-3">
    <div class="container mt-2">
        <h3 class="text-center">Order details</h3>
        <hr class="mx-auto">

        <table class="mt-5 pt-5 mx-auto">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th class="img">Image</th>
            </tr>
            <?php 
            // Reset the pointer of the result set to start
            mysqli_data_seek($order_details, 0); // Added this line
            while ($row = $order_details->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <p class="mt-3"><?php echo $row['product_name']; ?></p>
                        </div>
                    </td>
                    <td>
                        <span><p class="mt-3"><?php echo $row['product_price']; ?></p></span>
                    </td>
                    <td>
                        <span><p class="mt-3"><?php echo $row['product_quantity']; ?></p></span>
                    </td>
                    <td>
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" alt="<?php echo $row['product_name']; ?>" height="50" width="50">
                    </td>
                </tr>
            <?php } ?>
        </table>

        <?php if ($order_status == 'not paid') { ?>
            <form style="float: right" method="POST" action="payment.php">
                <input type="submit" value="Pay Now" class="btn btn-primary">
                <input type="hidden" name="order_id" value="<?php echo $order_id ;?>">
            </form>
        <?php } ?>
    </div>
</section>

<?php include('assets/layouts/footer.php'); ?>
