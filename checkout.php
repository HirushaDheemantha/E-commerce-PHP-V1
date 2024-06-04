<?php

session_start();

// Check if the user is logged in and the cart is not empty
if (!isset($_SESSION['logged_in']) || empty($_SESSION['cart'])) {
    header('location: index.php');
    exit();
}


?>





<?php include('assets/layouts/header.php'); ?>


      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-3">
            <h2 class="font-weight-bold">Check Out</h2>
            <hr id="checkouthr" class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="checkout-form" action="server/place_order.php" method="POST">
            <p class="text-center" style="color:red;">
            <?php if(isset($_GET['message'])){echo $_GET['message'];}?>
            <?php   if(isset($_GET['message'])){ ?>
            <a href="login.php" class="btn btn-primary">Login</a>
        <?php  } ?>
        
        </p>
                <div class="form-group checkout-small-element">
                    <label>Name</label>
                    <input type="text" class="form-control" id="checkout-email" name="name" placeholder="name" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>Phone</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="phone" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
                </div>
                <div class="form-group checkout-large-element">
                    <label>Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                </div>

                <div class="form-group checkout-btn-container">
                    <p>Total ammount: $ <?php echo $_SESSION['total'];?> </p>
                    <input type="submit" name="place_order" class="btn" id="checkout-btn" value="Place Order">
                </div>

            </form>
        </div>
      </section>






      <?php include('assets/layouts/footer.php'); ?>