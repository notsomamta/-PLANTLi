<header class="header">
    <section class="sub-head">
        <a href="home.php" class="logo">
            <i class="fas fa-spa" width="120"></i>
            PLANTLi
        </a>
        <nav class="navbar">
            <a  href="#home">HOME</a>
            <a href="#about">ABOUT</a>
            <a href="shop.php">SHOP</a>
            <a href="order.php">ORDERS</a>
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
            <img src="uploaded_files/ <?= $fetch_profile['image'];?>">
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