<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }


    if (isset($_POST['send_message'])) {
        if ($user_id != '') {

            $id =unique_id();
            $name =$_POST['name'];
            $name=filter_var($name, FILTER_SANITIZE_STRING);

            $email =$_POST['email'];
            $email = filter_var($email, FILTER_SANITIZE_STRING);

            $subject =$_POST['subject'];
            $subject=filter_var($subject, FILTER_SANITIZE_STRING);

            $message=$_POST['message'];
            $message=filter_var($message, FILTER_SANITIZE_STRING);

            $verify_message =$conn->prepare("SELECT * FROM message WHERE user_id=? AND name=? AND email=? AND subject=? AND message=?");
            $verify_message->execute([$user_id, $name, $email,$subject,$message]);

            if($verify_message->rowCount() > 0){
                $warning_msg[]='Message sent alraedy!';
            }else{
                $insert_message = $conn->prepare("INSERT INTO message (id, user_id, name, email, subject,message) VALUES(?,?,?,?,?,?) ");
                $insert_message->execute([$id, $user_id,$name,$email,$subject,$message]);

                $success_msg[]='Message sent!';
            }
            
        }else{
            $warning_msg[]='please login first';
        }
    }




   



    


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
            <a  href="home.php">HOME</a>
            <a href="home.php #about">ABOUT</a>
            <a href="shop.php">SHOP</a>
            <a href="order.php">ORDERS</a>
            <a class="active" href="contact.php">CONTACT</a>
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
            <a href="cart.php"><i class="bx bx-cart"><sup><?= $total_cart_item;?></sup></i></a>
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
    <section id="contact" class="section-m2">
        
        
    </section>

  
    
    <div class="service" id="ser">
        <h2 id="our">Our Services</h2>
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
    <div class="form-container" id="for">
        <div class="heading">
            <h1>Any questions? Ask us!</h1>
        <form action="" method="post" class="register">
            <div class="input-field">
                <label>Name <sup>*</sup></label>
                <input type="text" name="name" required placeholder="ENTER YOUR NAME" class="box">
            </div>
            <div class="input-field">
                <label>Email <sup>*</sup></label>
                <input type="email" name="email" required placeholder="ENTER YOUR EMAIL" class="box">
            </div>
            <div class="input-field">
                <label>Subject<sup>*</sup></label>
                <input type="text" name="subject" required placeholder="ENTER YOUR SUBJECT" class="box">
            </div>
            <div class="input-field">
                <label>Message<sup>*</sup></label>
                <textarea name="message" col="20" rows="10" required placeholder="" class="box"></textarea>
            </div>
            <button type="submit" name="send_message" class="btn">SEND</button>
        </form>
        </div>
    </div>
    <div class="address">
        <div class="heading">
            <h1>OUR CONTACT DETAILS</h1>
        </div>
        <div class="box-container" id="diba">
        <div class="box">
            <i class='bx bxs-map'></i>
            <div>
                <h4>address</h4>
                <p>1111 jamia nagar , batla house <br>delhi,india</p>
            </div>
        </div>
        <div class="box">
            <i class='bx bxs-phone-call'></i>
            <div>
                <h4>Phone Numbers</h4>
                <p>1111111</p>
                <p>1111111</p>
            </div>
        </div>
        <div class="box">
            <i class='bx bxs-envelope'></i>
            <div>
                <h4>Email</h4>
                <p>PLANTli@gmail.com</p>
                <p>greenplantli@gmail.com</p>
            </div>
        </div>
        
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