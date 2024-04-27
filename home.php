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
            <a class="active" href="#home">HOME</a>
            <a href="#about">ABOUT</a>
            <a href="shop.php">SHOP</a>
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
    

    <!-- home section -->
    <section class="home" id="home">
        <div class="swiper-container home-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>Go the green way</span>
                        <!-- <h3>Indoor Plants</h3> -->
                        <p> "Embrace the <span>GREEN</span> life with our diverse selection of plants, adding freshness and vitality to your home <span>ENVIRONMENT</span>."</p>
                        <!-- <a href="shop.php" class="btn">Shop Now</a> -->
                    </div>
                    <div class="image">
                        <img src="images/slideplant2.png" alt="">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>Greening Your World</span>
                        <!-- <h3>Ornamental Plants</h3> -->
                        <p>“If a tree dies, <span>PLANT</span> another in its place.”</p>
                        <!-- <a href="#" class="btn">Shop Now</a> -->
                    </div>
                    <div class="image">
                        <img src="./images/finalslide.png" alt="">
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="content">
                        <span>Planting Happiness</span>
                        <!-- <h3>WHY PLANTING?</h3> -->
                        <p>"Nurture your space with our botanical treasures, each <span>PLANT</span> a symbol of growth, care, and the beauty of <span>NATURE</span>."</p>
                        <!-- <a href="shop.php" class="btn">Read Now</a> -->
                    </div>
                    <div class="image">
                        <img src="./images/slideplant1.png"
                            alt="">
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- home section end -->


    <section id="banneri" class="section-m2">
        <h4>"Bringing nature's beauty to your doorstep."</h4>
        <h3>“The best time to <span>Plant</span> a tree was 20 years ago. The second best time is <span>Now</span>.”</h3>
        
    </section>

    <!-- service section -->
    <div class="service">
        <h2>Our Services</h2>
        <div class="box-container">
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                    <img src="images/delivery.png" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>Delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                    <img src="images/return.png" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>Free Returns</h4>
                    <span>Free returns within 3 days!</span>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                    <img src="images/24-hours-support.png" class="img1">
                    </div>
                </div>
                <div class="detail">
                    <h4>always with support</h4>
                    <span>24/7 Support</span>
                </div>
            </div>
        </div>
    </div>

    <!-- service section ends  -->
    <h2 class="solo">Categories</h2>
    <!-- categories -->
    <div class="banner-container">
        <div class="banner">
            <img src="images/indoor.jpg" alt="">
            <div class="content">
                <span>Greeny Plants</span>
                <h3>Indoor Plants</h3>
                <a href="shop.php" class="btn">Shop now</a>
            </div>
        </div>
        <div class="banner">
            <img src="images/outdoor.jpg" alt="">
            <div class="content">
                <span>Happy Nature</span>
                <h3>Outdoor Plants</h3>
                <a href="shop.php" class="btn">Shop now</a>
            </div>
        </div>

    </div>
    <br>
    
    <!-- catories end -->
    
    <!-- about -->
    <section class="about" id="about">
        <h3 class="sub-heading">About us</h3>
        <h1 class="pre-heading">Welcome to PTANTLi</h1>
        <div class="row">
            <div class="image">
            <img src="images/aboutimg.png" alt="">
        </div>
        <div class="content">
            <h3>Greeny plants</h3>
            <p>PLANTLi believe that nature has a way of brightening our lives and soothing our souls. That's why we're passionate about bringing the beauty of the outdoors into your home with our handpicked selection of plants.</p>
            <p> Plants are more than just decorations – they're living, breathing companions that enhance our lives in countless ways. From adding a touch of green to your living space to improving air quality and boosting your mood, the benefits of surrounding yourself with plants are endless.</p>
            <p>Thank you for choosing PLANTLi. Together, let's cultivate beauty, one plant at a time.</p>
            <div class="icons-container">
                <div class="icons">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Free Delivery</span>
                </div>
                <div class="icons">
                    <i class="fa-solid fa-box"></i>
                    <span>Eay Return</span>
                </div>
                <div class="icons">
                    <i class="fas fa-headset"></i>
                    <span>24/7 service</span>
                </div>
            </div>
            <a href="shop.html" class="btn">SHOP NOW</a>
        </div>
        </div>
    </section>
    <!-- about end -->


    <section id="bannery" class="section-m2">
        <h4>Cultivating Joy, Harvesting Happiness</h4>
        <h3>"A beautiful <span>plant </span>is like having a <span>friend</span> around the house."</h3>
        <h6>-Beth Ditto</h6>
    </section>


    













    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <?php include 'components/web_footer.php'; ?>
    <!-- js link -->
    <script src="js/userscript.js"></script>

    <?php include 'components/alert.php'; ?>

</body>
</html>