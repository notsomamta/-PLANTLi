<?php 
   include '../components/connect.php'; 

   if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
    
  }else{
    $seller_id='';
    header('location:login.php');
  }

  if (isset($_POST['delete_msg'])) {
    $delete_id=$_POST['delete_id'];
    $delete_id=filter_var($delete_id,FILTER_SANITIZE_STRING);

    $verify_delete=$conn->prepare("SELECT * FROM message WHERE id=?");
    $verify_delete->execute([$delete_id]);

    if($verify_delete->rowCount() >0){
       $delete_msg=$conn->prepare("DELETE FROM message WHERE  id=?");
       $delete_msg->execute([$delete_id]);


       $success_msg[]='message deleted';

    }else{
        $warning_msg[]='message deleted alraedy!';
    }
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
    <section class="user-message">
        <div class="heading">
          <h1>MESSAGES</h1>
          
        </div>
        <div class="box-container">
            <?php
                $select_message=$conn->prepare("SELECT * FROM message");
                $select_message->execute();
                if ($select_message->rowCount() > 0) {
                    while ($fetch_message =$select_message->fetch(PDO::FETCH_ASSOC)) {

                        
                   
            ?>
            <div class="box">
                <h3 class="name"><?= $fetch_message['name'];?></h3>
                <h4><?= $fetch_message['subject'];?></h4>
                <p><?= $fetch_message['message'];?></p>
                <form action="" method="post">
                    <input type="hidden" name="delete_id" value="<?= $fetch_message['id'];?>">
                    <input type="submit" name="delete_msg" value="delete message" class="btn" onclick="return confirm('Delete message?')">
                </form>
            </div>
            <?php 
                     }
                }else{
                    echo '
                        <div class="empty">
                          <p> INBOX IS EMPTY! </p>
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
