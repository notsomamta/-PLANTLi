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
    <title>PLANTLi -search</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- font cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css link -->
    <link rel="stylesheet" href="css/userstyle.css">
    
</head>
<body>
      <?php include 'components/web_header.php'; ?>
    <div class="products">
        <div class="heading">
            <h1>Search Result</h1>
        </div>
        <div class="box-container">
            <?php
                if(isset($_POST['search_plant']) OR isset($_POST['search_plant_btn'])){
                    $search_products =$_POST['search_plant'];
                    $select_products = $conn->prepare("SELECT * FROM products WHERE name LIKE '%{$search_products}%' AND status =?");
                    $select_products->execute(['active']);

                    if($select_products->rowCount() > 0){
                        while ($fetch_products=$select_products->fetch(PDO::FETCH_ASSOC)) {
                            $product_id =$fetch_products['id'];
                            
                        
            
            ?>
            <form action="" method="post" class="box" <?php if($fetch_products['stock']==0){echo 'disabled';}?>>
                <img src="uploaded_files/<?= $fetch_products['image']?>" class="image">
                <?php if ($fetch_products['stock'] > 9){?>
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
                                <p> NO Product Found  </p>
                            </div>
                        ';
                    }
                
                
                
            }else{
                    echo '
                            <div class="empty">
                                <p> Sorry search somthing else </p>
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