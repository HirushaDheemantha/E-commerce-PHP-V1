<?php include('assets/layouts/header.php'); ?>

<!-- home -->

<section id="home">
    <div class="container">
        <h3>New Arrivals</h3>
        <h1><span>Best prices</span> this season</h1>
        <p>Eshop offers the best products for the best prices</p>
        <button>Shop now</button>
    </div>
</section>

<section id="brand" class="container">
    <div class="row">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand1.jpg">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand2.jpg">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand3.jpg">
        <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand4.jpg">
    </div>
</section>

<!-- one -->
<section id="new" class="w-100">
    <div class="row p-0 m-0">
<div class="one col-lg-4 col-md-12 col-sm-12 p=0">
    <img class="image-fluid" src="assets/imgs/featured2.jpg">
    <div class="details">
        <h3>Branded Shoes</h3>
        <button class="item-btn text-uppercase">Shop now</button>
    </div>
</div>
<div class="one col-lg-4 col-md-12 col-sm-12 p=0">
    <img class="image-fluid" src="assets/imgs/featured1">
    <div class="details">
        <h3>Comfortable Jackets</h3>
        <button class="item-btn text-uppercase">Shop now</button>
    </div>
</div>
<div class="one col-lg-4 col-md-12 col-sm-12 p=0">
    <img class="image-fluid" src="assets/imgs/featured3">
    <div class="details">
        <h3>50% Watches</h3>
        <button class="item-btn text-uppercase">Shop now</button>
    </div>
</div>

</div>
</section>


<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Featured Products</h3>
        <hr class="mx-auto">
        <p>Here you can check out our featured products</p>
    </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_featured_products.php'); ?>
        <?php if($featured_products->num_rows > 0) { ?>
            <?php while($row = $featured_products->fetch_assoc()) { ?>
                <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>">
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                    <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                   <a href="single.php?product_id=<?php echo $row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
                </div>
            <?php } ?>
            <?php } else { ?>
            <p>No featured products available.</p>
        <?php } ?>

        </section>


<section id="banner">
    <img class="banner-image" src="assets/imgs/banner.jpg" alt="Banner">
    <div class="banner-text">
        <h4>MID SEASON'S SALE</h4>
        <h1>Autumn Collection <br> UP to 30% OFF</h1>
        <button class="shop-now-button">SHOP NOW</button>
    </div>
</section>


<section id="clothes" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Dresses and Coats</h3>
        <hr class="mx-auto">
        <p>Here you can check out our Amazing clothes</p>
    </div>

    <div class="row mx-auto container-fluid">
        <?php include('server/get_coats.php'); ?>
        <?php while($row = $coats_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-6">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                <a href="single.php?product_id=<?php echo $row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
            </div>
        <?php } ?>
    </div>
</section>

<section id="Watches" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Sport and luxury watches</h3>
        <hr class="mx-auto">
        <p>Here you can check out our Brand new watches</p>
    </div>
        <div class="row mx-auto container-fluid">
            <?php include('server/get_watches.php'); ?>
        <?php while($row = $watches->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"><?php echo $row['product_name'] ;?></h5>
            <h4 class="p-price"><?php echo $row['product_price'] ;?></h4>
            <a href="single.php?product_id=<?php echo $row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
        </div>

        <?php } ?>
    </div>
</section>

<section id="shoes" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Sport and casual shoes</h3>
        <hr class="mx-auto">
        <p>Here you can check out our Exclusive Shoes</p>
    </div>
        <div class="row mx-auto container-fluid">
        <?php include('server/get_shoes.php'); ?>
        <?php while($row = $shoes->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>">
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"><?php echo $row['product_name'] ;?></h5>
            <h4 class="p-price"><?php echo $row['product_price'] ;?></h4>
            <a href="single.php?product_id=<?php echo $row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
        </div>

        <?php } ?>
    </div>
</section>

<?php 
include('assets/layouts/footer.php');
?>

    