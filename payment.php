<?php
session_start();
?>

<?php include('assets/layouts/header.php'); ?>

<style>
.paypal-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin-top: 20px;
}

#paypal-button-container {
    width: 100%;
    max-width: 800px; /* Optional: adjust the max-width as needed */
}
</style>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-3">
        <h2 class="font-weight-bold">Payment</h2>
        <hr id="checkouthr" class="mx-auto">
    </div>
    <div class="mx-auto container text-center">
        <p><?php if (isset($_GET['order_status'])) { echo htmlspecialchars($_GET['order_status']); } ?></p>
        <?php $amount = strval($_SESSION['total']); ?>
        <!-- <?php $order_id = $_SESSION['order_id']; ?> -->
        <p>Total Payment: $<?php if (isset($_SESSION['total'])) { echo htmlspecialchars($_SESSION['total']); } ?></p>
        <?php if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
            <div class="paypal-container">
                <div id="paypal-button-container"></div>
        <?php } else { ?>
            <p>You don't have an Order</p>
        <?php } ?>
        <?php if (isset($_GET['order_status']) && $_GET['order_status'] == "not paid") { ?>
            <div id="paypal-button-container"></div>
        <?php } ?>
    </div>
</section>

<p id="result-message"></p>

<!-- Include the PayPal JavaScript SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=AX7u1_9jPri5A8iOmqIfgecihU0WuCtpwFZhLmpAzW_CGDDUy4AcUKikiDSYDznqhxXe5AfoihKbhYUO&currency=USD"></script>
<script>
window.paypal.Buttons({
    style: {
        shape: "rect",
        layout: "vertical",
        color: "gold",
        label: "paypal",
    },
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: '<?php echo isset($_SESSION['total']) ? $_SESSION['total'] : "0.00"; ?>'
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            // Show a success message to the buyer
            alert('Transaction completed by ' + details.payer.name.given_name);

            window.location.href = "server/complete_payment.php?order_id=<?php echo $order_id; ?>";
            
        });
    },
    onError: function (err) {
        console.error('An error occurred during the PayPal transaction:', err);
        document.getElementById('result-message').innerHTML =
            'Sorry, your transaction could not be processed...<br><br>' + JSON.stringify(err);
    },
    onCancel: function (data) {
        console.log('PayPal transaction canceled:', data);
        document.getElementById('result-message').innerHTML = 'Transaction canceled by the user';
    },
    onClick: function () {
        console.log('PayPal button clicked');
    }
}).render('#paypal-button-container');
</script>

<?php include('assets/layouts/footer.php'); ?>
