<?php


include('server/connection.php');
//this gonna use search
if(isset($_POST['search'])){

    if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
        //if user has already entered page then page number is the one that they selected
        $page_no = $_GET['page_no'];
      }else{
        //if user just entered the page the default page is 1 
        $page_no =1;
      }

    $category = $_POST["category"]; 
    $price = $_POST["price"]; 

      $stmt1 = $conn->prepare("SELECT COUNT(*) as total_records FROM products WHERE product_category=? AND product_price<=?");
      $stmt1 ->bind_param("si",$category,$price);
      $stmt1->execute();
      $stmt1 ->bind_result($total_records);
      $stmt1-> store_result();
      $stmt1->fetch();

      $total_records_per_page = 8;

      $offset = ($page_no-1)* $total_records_per_page;
    
      $previous_page = $page_no-1;
    
      $next_page = $page_no + 1;
    
      $adjacents = "2";
    
      $total_no_of_pages = ceil($total_records/$total_records_per_page);


      $stmt2 = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price<=? LIMIT $offset,$total_records_per_page");
      $stmt2 ->bind_param("si",$category,$price);
     $stmt2->execute();
      $products = $stmt2->get_result();

      


    



    //return all products 
}else{
    
  if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
    //if user has already entered page then page number is the one that they selected
    $page_no = $_GET['page_no'];
  }else{
    //if user just entered the page the default page is 1 
    $page_no =1;
  }
//return number of products 
  $stmt1 = $conn->prepare("SELECT COUNT(*) as total_records FROM products");
  $stmt1 ->execute();
  $stmt1 ->bind_result($total_records);
  $stmt1-> store_result();
  $stmt1->fetch();

  //set amount of products for a page 
  $total_records_per_page = 8;

  $offset = ($page_no-1)* $total_records_per_page;

  $previous_page = $page_no-1;

  $next_page = $page_no + 1;

  $adjacents = "2";

  $total_no_of_pages = ceil($total_records/$total_records_per_page);

  //getproducts
  $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_records_per_page");
  $stmt2->execute();
  $products = $stmt2->get_result();


}



?>




<?php include('assets/layouts/header.php'); ?>

<section id="search" class="mt-5 py-5">
<div class="container mt-5 py-5">
    <p>Search Products</p>
</div>

<form action="shop.php" method="POST">
    <div class="row mx-auto containe r">
        <div class="col-lg-12 col-md-12 col-sm-12">

            <p>Category</p>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="shoes" name="category" id="category_one" <?php  if(isset($category) && $category == 'shoes'){echo 'checked';} ?>>
                <label class="fpr,-check-label" for="flexRadioDefault1">
                    Shoes
                </label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="clothes" name="category" id="category_two" <?php  if(isset($category) && $category == 'clothes'){echo 'checked';} ?>>
                <label class="fpr,-check-label" for="flexRadioDefault1">
                    Clothes
                </label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="watches" name="category" id="category_two" <?php  if(isset($category)&& $category == 'watches'){echo 'checked';} ?>>
                <label class="fpr,-check-label" for="flexRadioDefault1">
                    Watches
                </label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" value="Bags" name="category" id="category_two" <?php  if(isset($category) && $category == 'Bags'){echo 'checked';} ?>>
                <label class="fpr,-check-label" for="flexRadioDefault1">
                    Bags
                </label>
            </div>

        </div>




        </div>
    </div>

    <div class="row mx-auto container mt-5">
        <div class="col-lg-12 col-md-12 col-sm-12">

            <p>Price</p>
            <input type="range" class="form-range w-50" name="price" value="<?php if(isset($price)){echo $price; }else{ echo "100";} ?>" min="1" max="1000" id="customRange2">
         <div class="w-50">
            <span style="float: left;">1</span>
            <span style="float: right;">1000</span>
         </div>
        </div>
    </div>

    <div class="form-group my-3 mx-3">
        <input type="submit" name="search" value="Search" class="btn btn-primary">
    </div>

</form>


</section>





    <section id="featured" class="my-5 pb-5 py-5">
        <div class="container mt-5 py-5">
            <h3>Shop</h3>
            <hr class="w-100">
            <p>Here's Our Products</p>
        </div>

        <div class="container">
    <div class="row mx-auto">
        <?php while ($row = $products->fetch_assoc()) { ?>
            <div onclick="window.location.href='single.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-6 mb-4">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image'] ?>">
                <div class="star">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h5 class="p-name"><?php echo $row['product_name'] ?></h5>
                <h4 class="p-price"><?php echo $row['product_price'] ?></h4>
                <button class="buy-btn"><a class="underline" href="single.php?product_id=<?php echo $row['product_id']; ?>">Buy Now</a></button>
            </div>
        <?php } ?>
        <nav aria-label="page navigation example">
    <ul class="pagination mt-5">
        <li class="page-item <?php if($page_no <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="<?php if($page_no <= 1) echo '#'; else echo "?page_no=".($page_no-1); ?>">Previous</a>
        </li>
        <?php for($i = 1; $i <= $total_no_of_pages; $i++) { ?>
            <li class="page-item <?php if($page_no == $i) echo 'active'; ?>">
                <a class="page-link" href="<?php echo "?page_no=".$i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>
        <li class="page-item <?php if($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
            <a class="page-link" href="<?php if($page_no >= $total_no_of_pages) echo '#'; else echo "?page_no=".($page_no+1); ?>">Next</a>
        </li>
    </ul>
</nav>

        </div>
    </section>

    <?php include('assets/layouts/footer.php'); ?>