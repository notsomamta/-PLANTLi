<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }




    $pid=$_GET['pid'];

    include 'components/add_cart.php';



    


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLANTLi-view</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- font cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="css/userstyle.css">
    
</head>
<body>
      <?php include 'components/web_header.php'; ?>

        <section class="view_page">
            <div class="heading">
                <h2>PRODUCT DETAILS</h2>
            </div>
            <?php
                if(isset($_GET['pid'])){
                    $pid =$_GET['pid'];
                    $select_products =$conn->prepare("SELECT * FROM products WHERE id=?");
                    $select_products->execute([$pid]);

                    if ($select_products->rowCount() > 0) {
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

                        
            
            
            ?>
            <form action="" method="post" class="box">
                <div class="img-bx">
                    <img src="uploaded_files/<?=$fetch_products['image'];?>" >
                </div>
                <div class="detail">
                    <?php if($fetch_products['stock'] > 9){?>
                        <span class="stock" style="color:green;">In Stock</span>
                    <?php }elseif($fetch_products['stock']==0){?>
                        <span class="stock" style="color:red;">Out of Stock</span>

                    <?php }else{ ?>
                        <span class="stock" style="color:red;">Only <?=$fetch_products['stock'];?> Left!</span>
                    <?php } ?>
                    <p class="price">₹<?=$fetch_products['price'];?>/-</p>
                    <div class="name"><?=$fetch_products['name'];?></div>
                    <p class="product-detail"><?=$fetch_products['product_detail'];?></p>
                    <input type="hidden" name="product_id" value="<?=$fetch_products['id'];?>">
                    <div class="button">
                        <input type="hidden" name="qty" value="1" min="0" class="quantity">
                        <button type="submit" name="add_to_cart" class="btn">Add To Cart<i class='bx bxs-cart-alt'></i></button>
                    </div>
                </div>
            </form>
            <?PHP
                            }
                        }
                    }
            
            ?>
        </section>
    
    
    

    </section>
    <div class="products">
        <div class="heading">
            <h1>More products</h1>
        </div>
        <?php include 'components/menu.php'; ?>
    </div>
    </header>




            
  



<!-- banner -->
    <section id="bannery" class="section-m2">
        <h4>Cultivating Joy, Harvesting Happiness</h4>
        <h3>"A beautiful <span>plant </span>is like having a <span>friend</span> around the house."</h2>
        <h6>-Beth Ditto</h6>
    </section>



<!-- banner end -->
    

 


    













    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/web_footer.php'; ?>
    <!-- js link -->
    <script src="js/userscript.js"></script>

    <?php include 'components/alert.php'; ?>

</body>
</html>