<?php 
   include '../components/connect.php'; 

   if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
    
  }else{
    $seller_id='';
    header('location:login.php');
  }

  $select_products = $conn->prepare("SELECT * FROM products WHERE seller_id =?");
  $select_products->execute([$seller_id]);
  $total_products = $select_products->rowCount();

  
  $select_orders = $conn->prepare("SELECT * FROM orders WHERE seller_id =?");
  $select_orders->execute([$seller_id]);
  $total_orders = $select_orders->rowCount();




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="../css/admin_style.css?v=<?php echo time(); ?>">
    <title>admin-profile page</title>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="admin-profile">
        <div class="heading">
          <h1>PROFILE</h1>
          
        </div>
        <div class="details">
            <div class="seller">
                <img src="../uploaded_files/<?= $fetch_profile['image'];?>" >
                <h3 class="name"><?= $fetch_profile['name'];?></h3>
                <span>Seller</span>
                <!-- <a href="update.php" class="btn">Update Profile</a> -->
            </div>
            <div class="flex">
                <div class="box">
                    <span><?= $total_products;?></span>
                    <p>Total products</p>
                    <a href="view_product.php" class="btn">View products</a>
                 </div>
                <div class="box">
                    <span><?= $total_orders;?></span>
                    <p>Total order place</p>
                    <a href="admin_order.php" class="btn">view oders</a>
                </div>
            </div>
        
        </div>
       

    </section>
    </div>
    




  







<!-- sweetalertcdn -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script type="text/javascript" src="../js/admin_script.js"></script>
  <!-- alert -->
  <?php include '../components/alert.php'; ?>
</body>
</html>
