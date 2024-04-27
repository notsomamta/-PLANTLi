<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = 'location:login.php';
    }

    //update//
    if (isset($_POST['update_cart'])){
        $cart_id = $_POST['cart_id'];
        $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

        $qty = $_POST['qty'];
        $qty = filter_var($qty,FILTER_SANITIZE_STRING);

        $update_qty = $conn->prepare("UPDATE cart SET qty = ?  WHERE id =?");
        $update_qty->execute([$qty, $cart_id]);

        $success_msg[] = 'cart quantity changed !';
    }

    // delete//
     if(isset($_POST['delete_item'])){
        $cart_id =$_POST['cart_id'];
        $cart_id =filter_var($cart_id, FILTER_SANITIZE_STRING);

        $verify_delete=$conn->prepare("SELECT * FROM cart WHERE id =?");
        $verify_delete->execute([$cart_id]);

        if($verify_delete->rowCount() > 0){
            
            $delete_cart_id =$conn->prepare("DELETE FROM cart WHERE id=?");
            $delete_cart_id->execute([$cart_id]);

            $success_msg[]= 'cart item  deleted successfully';

        }else{
            $warning_msg[]='cart item deleted now';
        }
    }

    //empty cart//

    if (isset($_POST['empty_cart'])) {
        
        $empty_cart =$conn->prepare("SELECT * FROM cart WHERE user_id=?");
        $empty_cart->execute([$user_id]);

        if($empty_cart->rowCount() > 0){

            $delete_cart_id=$conn->prepare("DELETE FROM cart WHERE user_id =?");
            $delete_cart_id->execute([$user_id]);

            $success_msg[]='CART IS EMPTY NOW!';
        }else{
            $warning_msg[]='YOUR CART IS ALREADY EMPTY';
        }
        
    }


   



    


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLANTLi -cart</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- font cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="css/userstyle.css">
    
</head>
<body>
      <?php include 'components/web_header.php'; ?>

    <div class="detail">
        
    </div>
    <div class="products" id="pro">
        <div class="heading">
            <h2>My Cart<i class='bx bxs-cart-alt'></i></h2>
        </div>
        <div class="box-container">
            <?php
                $grand_total=0;
                $select_cart =$conn->prepare("SELECT * FROM cart WHERE user_id=?");
                $select_cart->execute([$user_id]);

                if ($select_cart->rowCount() > 0) {
                    while($fetch_cart = $select_cart->fetch(PDO:: FETCH_ASSOC)){
                        $select_products=$conn->prepare("SELECT * FROM products WHERE id=?");
                        $select_products->execute([$fetch_cart['product_id']]);

                        if ($select_products->rowCount() > 0) {
                            $fetch_products=$select_products->fetch(PDO::FETCH_ASSOC);
                        

            ?>

            <form action="" method="post" class="box <?php if($fetch_products['stock']==0){ echo 'disabled';};?>">
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id'];?>" >
                    <img src="uploaded_files/<?= $fetch_products['image'];?>" class="image" >
                    <?php
                        if ($fetch_products['stock'] > 9 ) {?>
                        <span class="stock" style="color:green;">In Stock</span>
                    <?php }elseif($fetch_products['stock']==0){?>
                        <span class="stock" style="color:red;">Out of Stock</span>
                    <?php }else { ?>
                        <span class="stock" style="color:red;">Only <?=$fetch_products['stock'];?> Left</span>
                     <?php  }?>
                    <div class="content">
                        <h3 class="name"><?=$fetch_products['name'];?></h3>
                        <div class="flex-btn">
                            <p class="price"> ₹<?=$fetch_products['price'];?>/-</p>
                            <input type="number" name="qty" required min="1" value="<?=$fetch_cart['qty'];?>" max="99" maxlength="2" class="qty">
                            <button type="submit" name="update_cart" class="bx bxs-edit-alt  edit" ></button>
                        </div>
                        <div class="flex-btn">
                            <p class="sub-total">Sub total: <span>₹<?= $sub_total=($fetch_cart['qty']*$fetch_cart['price']);?>/-</span></p>
                            <button type="submit" name="delete_item" class="btn" onclick="return confrim ('do you want to remove it from the cart?');">Delete</button>
                        </div>
                        
                    </div>
                    
                    
                    
        
        
        
            </form>
            <?php 

                        $grand_total += $sub_total;
                        }else{
                             echo '
                                <div class="empty">
                                    <p> NO Product added yet! </p>
                                </div>
                        
                             ';
            
                             }
                        }
            
                }else{
                    echo '
                        <div class="empty">
                            <p> NO product found</p>
                        </div>
                        
                     ';

                }


            
            
            
            
            ?>
        </div>
        <?php if($grand_total!= 0) { ?>
            <div class="cart-tal">
                <p>AMOUNT TO PAY: <span>₹<?= $grand_total;?>/-</span></p>
                <div class="button">
                <form action="" method="post">
                    <button type="submit" name="empty_cart" class="btn" onclick="return confirm('SURE? Want to Remove all from cart!');">REMOVE ALL</button>
                </form>
                <a href="checkout.php" class="btn">PROCEED TO CHECKOUT</a>
                </div>
            </div>

        
        
        <?php } ?>

    </div>

    
    
    

    </section>
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