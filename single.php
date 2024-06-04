<?php
include('server/connection.php');

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];

    $stmt =$conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt ->bind_param('i',$product_id);

    $stmt->execute();

$product = $stmt->get_result();

}else{
    header('location: index.php');
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style1.css">

</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top bg-white">
        <div class="container">
          <img class="navlogo" src="assets/imgs/logo" alt="logo">
          <h2 class="brand">ClickBuy</h2>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop.php">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">Blog</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact us</a>
              </li>
              <li class="nav-item">
               <a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></a> 
               <a href="account.html"><i class="fa-solid fa-user"></i></a> 
          </div>
        </div>
      </nav>



      <section class="container single-product my-5 pt-5">
   
   
      <div class="row mt-5">

    <?php while($row= $product->fetch_assoc()){?>

        



    <div class="col-lg-5 col-md-6 col-sm-12">
        <img class="image-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image'];?>" id="mainImg" >
    <div class="small-img-group">
        <div class="small-img-col">
            <img src="assets/imgs/<?php echo $row['product_image'];?>" width="100%" class="small-img">
        </div>
        <div class="small-img-col">
            <img src="assets/imgs/<?php echo $row['product_image2'];?>" width="100%" class="small-img">
        </div>
        <div class="small-img-col">
            <img src="assets/imgs/<?php echo $row['product_image3'];?>" width="100%" class="small-img">
        </div>
        <div class="small-img-col">
            <img src="assets/imgs/<?php echo $row['product_image4'];?>" width="100%" class="small-img">
        </div>    
     </div>
   </div>



   <div class="col-lg-6 col-md-12 col-12">
    <h6>Men/Shoes</h6>
    <h3 class="py-4"> <?php echo $row['product_name'];?></h3>
    <h2>$<?php echo $row['product_price'];?></h2>

    <form method="POST" action="cart.php">
    <input type="hidden" name="product_id" value="<?php echo $row['product_id'];?>">
    <input type="hidden" name="product_image" value="<?php echo $row['product_image'];?>">
    <input type="hidden" name="product_name" value="<?php echo $row['product_name'];?>">
    <input type="hidden" name="product_price" value="<?php echo $row['product_price'];?>">
    <!-- Correct input field for product quantity -->
    <input type="number" name="product_quantity" value="1" min="1"> <!-- Allow users to input quantity -->
    <button class="addtocart" type="submit" name="add_to_cart">Add To Cart</button>


</div>
</form>
   <?php }?> 

</div>
</section>

<section id="related" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Related Products</h3>
        <hr class="mx-auto">
        <p>Here you can check out our Related products</p>
    </div>
        <div class="row mx-auto container-fluid">
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/item1">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">sports shoe</h5>
            <h4 class="p-price">$199.8</h4>
            <button class="buy-btn">Buy Now</button>
        </div>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/item2">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">sports Bag</h5>
            <h4 class="p-price">$99.8</h4>
            <button class="buy-btn">Buy Now</button>
        </div>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/item3">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">Sports Shoe</h5>
            <h4 class="p-price">$129.8</h4>
            <button class="buy-btn">Buy Now</button>
        </div>

        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/item4">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">sports Bottle</h5>
            <h4 class="p-price">$11.8</h4>
            <button class="buy-btn">Buy Now</button>
        </div>
    </div>
</section>


      <footer class="mt-5 py-5" style="background-color: rgb(24, 22, 22);">
        <div class="row container mx-auto pt-5">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <img class="footlogo" src="assets/imgs/logo" >
                <p class="pt-3">We provide the best products for the most affordable prices at <a class="footerlogotxt color-orange" href="#">ClickBuy</a></p>
            </div>
            <div class="footer-one col-lg-3 col-md-6 col-sm-12">
                <h5 class="pb-2">Featured</h5>
                <ul class="text-uppercase">
            <li><a href="#">men</a></li>
            <li><a href="#">Women</a></li>
            <li><a href="#">Boys</a></li>
            <li><a href="#">Girls</a></li>
            <li><a href="#">New Arrivals</a></li>
            <li><a href="#">Clothes</a></li>
                </ul>
                </div>
                <div class="footer-one col-lg-3 col-md-6 col-sm-12">
                    <h5 class="pb-2">Contact Us</h5>
                    <div>
                        <h6 class="text-uppercase">
                            Address</h6>
                            <p>N0 61,Depot rd,Kekirawa</p> 
                    </div>
                    <div>
                        <h6 class="text-uppercase">
                            Number</h6>
                            <p>+9421314125</p>
                    </div>
                    <div>
                        <h6 class="text-uppercase">
                            Email</h6>
                            <p>info@gmail.com</p>
                    </div>
                </div>
                <div class="footer-one col-lg-3 col-md-6 col-sm-12">
                    <h5 class="pb-2">Instagram</h5>
                    <div class="row">
                        <img src="assets/imgs/footer1.jpg" class="img-fluid w-25 h-100 m-2">
                        <img src="assets/imgs/footer2.jpg" class="img-fluid w-25 h-100 m-2">
                        <img src="assets/imgs/footer4 (1).jpg" class="img-fluid w-25 h-100 m-2">
                        <img src="assets/imgs/footer4 (2).jpg" class="img-fluid w-25 h-100 m-2">
                        <img src="assets/imgs/footer4 (3).jpg" class="img-fluid w-25 h-100 m-2">
                    </div>
                </div>
        </div>
    
        <div class="copyright mt-5">
            <div class="row container mx-auto">
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <img src="assets/imgs/payment.jpg">
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
                    <p>eCommerce @2024 All Rights Reserved</p>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    
    
    
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");
    
        for (var i = 0; i < 4; i++) {
            (function(index) {
                smallImg[index].onclick = function() {
                    mainImg.src = smallImg[index].src;
                }
            })(i);
        }
    </script>
</body>
</html>