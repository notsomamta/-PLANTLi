<?php 
   include '../components/connect.php'; 

   if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
    
  }else{
    $seller_id='';
    header('location:login.php');
  }

  if(isset($_POST['update_order'])){
     
    $order_id = $_POST['order_id'];
    $order_id= filter_var($order_id, FILTER_SANITIZE_STRING);

    $update_payment =$_POST['update_payment'];
    $update_payment = filter_var($update_payment,FILTER_SANITIZE_STRING);

    $update_pay =$conn->prepare("UPDATE orders SET payment_status =? WHERE id=?");
    $update_pay->execute([$update_payment, $order_id]);
    $success_msg[]='status updated!';
  }
  


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
    <title>admin-dashboard</title>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="user-orders">
        <div class="heading">
          <h1>ODERS</h1>
          
        </div>
        <div class="box-container">
            <?php
                $select_order =$conn->prepare("SELECT * FROM orders WHERE seller_id=?");
                $select_order->execute([$seller_id]);

                if ($select_order->rowCount() > 0) {
                    while ($fetch_order= $select_order->fetch(PDO::FETCH_ASSOC)){
                      
            
            ?>
            <div class="box">
                <div class="status" style="color:<?php if($fetch_order['status']=='in progress')
                {echo "limegreen";}else{echo "red";}?>"><?= $fetch_order['status'];?>

            </div>
            <div class="details">
                <p>User Name: <span><?= $fetch_order['name'];?></span></p>
                <p>User id: <span><?= $fetch_order['user'];?></span></p>
                <p>order placed:<span><?= $fetch_order['date'];?></span></p>
                <p>User number:<span><?= $fetch_order['number'];?></span></p>
                <p>User email :<span><?= $fetch_order['email'];?></span></p>
                <p>Total price:<span><?= $fetch_order['price'];?></span></p>
                <p>Payment method:<span><?= $fetch_order['method'];?></span></p>
                <p>User address:<span><?= $fetch_order['address'];?></span></p>
            </div>
            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?= $fetch_order['id'];?>">
                <select name="payment_confirmation" class="box" style="width:90%;">
                        <option disabled selected><?=$fetch_order['payment_status'];?></option>
                        <option value="pending">Pending</option>
                        <option value="delivered">delivered</option>
                </select>
                <div class="flex-btn">
                    <input type="submit" name="update_order" value="update payment" class="btn">
                </div>
            </form>

            </div>

            <?php 
                  }
                }else{
                    echo '
                        <div class="empty">
                          <p> no order placed </p>
                        </div>
                    
                    ';

                }
            
            ?>
            
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
