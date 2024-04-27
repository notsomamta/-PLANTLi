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
    <title>user-dashboard</title>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    <section class="user-box">
        <div class="heading">
          <h1>Users</h1>
          
        </div>
        <div class="box-container">
            <?php
            $select_user =$conn->prepare("SELECT * FROM users");
            $select_user->execute();

            if ($select_user->rowCount() > 0) {
                while ($fetch_user = $select_user->fetch(PDO::FETCH_ASSOC)) {
                    $user_id = $fetch_user['id'];
                    
               
            
            ?>
            <div class="box">
                <p>User id: <span><?= $user_id;?></span></p>
                <p>User Name: <span><?= $fetch_user['name'];?></span></p>
                <p>User email: <span><?= $fetch_user['email'];?></span></p>
            </div>
            <?php
                    }
                }else{
                    echo '
                        <div class="empty">
                          <p> NO user register </p>
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
