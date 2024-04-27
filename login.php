<?php
    include 'components/connect.php';

    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
    }else{
        $user_id = '';
    }




    if(isset($_POST['submit'])){
        
        $email=$_POST['email'];
        $email= filter_var($email, FILTER_SANITIZE_STRING);

        $pass =sha1($_POST['pass']);
        $pass = filter_var($pass,FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM users  WHERE email=? AND password = ? LIMIT 1");
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        
        
        
        if ($select_user->rowCount() > 0) {
            setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
            header('location:home.php');
        }else{
            $warning_msg[]='Incorrect Email or Password';

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
      <?php include 'components/web_header.php'; ?>

    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data"   class=" login" >
            <h3>LOGIN NOW</h3>
            <div class="input-field">
                <p>Your Email <span>*</span></p>
                <input type="email" name="email" placeholder="Enter Your Email" maxlength="50" required class="box">
            </div>
            <div class="input-field">
                <p>Your Password<span>*</span></p>
                <input type="password" name="pass" placeholder="Enter Your Password" maxlength="50" required class="box">
             </div>
            
                <p class="link">DO not have account?<a href="register.php">Register Now</a></p>
                <input type="submit" name="submit" value=" LOGIN Now" class="btn">
        </form>
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