<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }

    include 'components/add_cart.php';


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLANTLi</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- font cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="css/userstyle.css">
    
</head>
<body>
<header class="header">
    <section class="sub-head">
        <a href="home.php" class="logo">
            <i class="fas fa-spa" width="120"></i>
            PLANTLi
        </a>
        <nav class="navbar">
            <a href="home.php">HOME</a>
            <a href=" home.php #about ">ABOUT</a>
            <a class="active" href="shop.php">SHOP</a>
            <a href="#">ORDERS</a>
            <a href="contact.php">CONTACT</a>
        </nav>
        <form action="search_product.php" method="post" class="search-form">
            <input type="text" name="search_plant" placeholder="search products.." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_plant_btn"></button>
        </form>
        <div class="icons">
            <div class="bx bx-list-plus" id="menu-bars"></div>
            <div class="bx bx-search-alt-2" id="search-icon"></div>
            <!-- <a href="wishlist.php"><i class="bx bx-heart"><sup>0</sup></i></a> -->

            <?php
                $count_cart_item = $conn->prepare("SELECT *FROM cart WHERE user_id=?");
                $count_cart_item->execute([$user_id]);
                $total_cart_item = $count_cart_item->rowCount();
            
            
            ?>
            <a href="cart.php"> <i class="bx bx-cart"><sup><?= $total_cart_item;?></sup></i></a>
            <div class="bx bxs-user" id="user-btn"></div>

        </div>
        <div class="profile-detail">
            <?php
                $select_profile =$conn->prepare("SELECT * FROM users WHERE id=?");
                $select_profile->execute([$user_id]);

                if($select_profile->rowCount() > 0){
                   $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="uploaded_files/<?= $fetch_profile['image'];?>">
            <h3 style="margin-bottom:1rem;"><?= $fetch_profile['name'];?></h3>
            <div class="flex-btn">
                <!-- <a href="profile.php" class="btn">View profile</a> -->
                <a href="components/user_logout.php" onclick="return confirm('Logout form website?'); " class="btn">Logout</a>
            </div>
    
            <?php }else { ?>
                 
                <h3  style="margin-bottom:1rem;">please login or sign up</h3>
                <div class="flex-btn">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Sign up</a>


            </div>
        <?php } ?>
        </div>
    
    

    </section>
</header>



<div class="products">
    <h2>OUR PLANTS</h2>
    <div class="box-container">
        <?php
            $select_products = $conn->prepare("SELECT * FROM products WHERE status=? LIMIT 6");
            $select_products->execute(['active']);

            if ($select_products->rowCount() > 0) {
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

            
    
        ?>
        <form action="" method="post" class="box" <?php if($fetch_products['stock']==0){echo 'disabled';}?>>
                <img src="uploaded_files/<?= $fetch_products['image']?>" class="image">
                <?php if ($fetch_products['stock']> 9){?>
                    <span class="stock" style="color:green;">In Stock</span>
                <?php }elseif ($fetch_products['stock']==0) { ?>
                    <span class="stock" style="color:red;">Out of Stock</span>
                <?php }else{ ?>
                    <span class="stock" style="color:red;">going out of stock soon <?=$fetch_products['stock'];?> Left</span>


               <?php } ?>
               <div class="content">
                    <div class="button">
                        <div><h3 class="name"><?= $fetch_products['name'];?></h3></div>
                         <div>
                            <button type="submit" name="add_to_cart"><i class="bx bxs-cart"></i></button>
                            <a href="view_page.php?pid=<?= $fetch_products['id'];?>" class="bx bxs-show"></a>
                         </div>
                    </div>
                    <p class="price"> ₹<?=$fetch_products['price'];?>/-</p>
                    <input type="hidden" name="product_id" value="<?= $fetch_products['id']?>">
                    <div class="flex-btn">
                        <a href="checkout.php?get_id=<?= $fetch_products['id'];?>" class="btn">Buy Now</a>
                         <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty-box">
                    </div>

               </div>
        </form>
        <?php
                }
            }else{
                echo '
                    <div class="empty">
                        <p> NO Product added yet! </p>
                    </div>
            
                ';

            }
    
        ?>
    </div>
</div>



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