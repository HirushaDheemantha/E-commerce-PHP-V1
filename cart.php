<?php
session_start(); // Initialize session

if (isset($_POST['add_to_cart'])) {
    // Check if the 'cart' key is set in the session
    if (!isset($_SESSION['cart'])) {
        // If not set, initialize the 'cart' array
        $_SESSION['cart'] = array();
    }

    // Check if the product is already in the cart
    $product_id = $_POST['product_id'];
    if (array_key_exists($product_id, $_SESSION['cart'])) {
        echo '<script>alert("Product was already added");</script>';
    } else {
        // Add the product to the cart
        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity']
        );
        $_SESSION['cart'][$product_id] = $product_array;
    }
 //calculate total cart 
calculateTotalCart();




    
//remove product    
}else if(isset($_POST['remove_product'])){

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    
    //incase remove
    calculateTotalCart();

}else if(isset($_POST['edit_quantity'])){
//we get id and quantity from the form
$product_id = $_POST['product_id'];
$product_quantity = $_POST['product_quantity'];

//get the product array from the session
$product_array = $_SESSION['cart'][$product_id];
//update the product quantity 
$product_array['product_quantity']=$product_quantity;
//return array back its place 
$_SESSION['cart'][$product_id] = $product_array;

//incase edit
calculateTotalCart();


}else{
    //header('location: index.php');
}

function calculateTotalCart(){

    $total_price=0;
    $total_quantity=0;


    foreach($_SESSION['cart'] as $key => $value){
        $product = $_SESSION['cart'][$key];

        $price = $product['product_price'];
        $quantity = $product['product_quantity'];

        $total_price = $total + ($price * $quantity);
        $total_quantity = $total_quantity+$quantity;

    }

    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;
}






?>



<?php include('assets/layouts/header.php'); ?>


    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h3>Your cart</h3>
            <hr>

            <table class="mt-5 pt-5">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>

                <?php foreach($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $value['product_image']; ?>">
                            <div>
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span>$</span><?php echo $value['product_price']; ?></small>
                                <br>
                                <form method="POST" action="cart.php">
                                   <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"> 
                                <input type="submit" name="remove_product" class="remove-btn" value="remove">
                                </form>
                            </div>
                        </div>
                    </td>

                    <td>
                        
                        <!-- <a class="edit-btn" href="#">Edit</a> -->
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>">
                            <input type="submit" class="edit-btn" value="edit" name="edit_quantity">
                        </form>


                    </td>

                    <td>
                        <span>$</span>
                       <?php echo $value['product_quantity']* $value['product_price'];?> 
                    </td>
                </tr>
                <?php } ?>

            </table>

<div class="cart-total">
            <table>
                <!-- <tr>
                    <td>Subtotal</td>
                    <td></td>
                </tr> -->

                <tr>
                    <td>Total Amount</td>
                    <td>$ <?php echo $_SESSION['total']; ?> </td>
                </tr>
            </table>
        </div>

        </div>

<div class="checkout-container">
    <form method="POST" action="checkout.php">
        <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
    </form>
</div>
    </section>
    


    <?php include('assets/layouts/footer.php'); ?>