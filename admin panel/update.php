<?php
    include '../components/connect.php'; 

   if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
    
  }else{
    $seller_id='';
    header('location:login.php');
  }

    if (isset($_POST['submit'])) {
     
        $select_seller =$conn->prepare("SELECT * FROM sellers WHERE id=? LIMIT 1");
        $select_seller->execute([$seller_id]);
        $fetch_seller =$select_seller->fetch(PDO::FETCH_ASSOC);

       
        $prev_image =$fetch_seller['image'];

        $name = $_POST['name'];
        $name =filter_var($name, FILTER_SANITIZE_STRING);
        
        $email = $_POST['email'];
        $email =filter_var($email, FILTER_SANITIZE_STRING);

        // update name //
        if (!empty($name)) {
            $update_name= $conn->prepare("UPDATE sellers SET name= ? WHERE id=?");
            $update_name->execute([$name,$seller_id]);
            $success_msg[]='Username changed!';
            
        }
        // update email//
        if (!empty($email)) {
            $select_email=$conn->prepare("SELECT * FROM sellers WHERE id=? AND email=?");
            $select_email->execute([$seller_id, $email]);

            if ($select_email->rowCount() > 0) {
                $warning_msg[]= 'Email already exist';
            }else{
                $update_email= $conn->prepare("UPDATE sellers SET email= ? WHERE id=?");
                $update_email->execute([$email,$seller_id]);
                $success_msg[]= 'Email updated!';
                
            }

        }
        // update img//

        $image = $_FILES['image']['name'];
        $image = filter_var($image,FILTER_SANITIZE_STRING);
        $ext=pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id().'.'.$ext;
        $image_size =$_FILES['image']['size'];
        $image_tmp_name= $_FILES['image']['tmp_name'];
        $image_folder= '../uploaded_files/'.$rename;

        if (!empty($image)) {
            if($image_size > 1800000){
               $warning_msg[]='image is large in size';
               
            }else{
                $update_image =$conn->prepare("UPDATE sellers SET image =? WHERE id=?");
                $update_image->execute([$rename, $seller_id]);
                move_uploaded_file($image_tmp_name, $image_folder);

                if($prev_image != '' AND $prev_image != $rename){
                    unlink('../uploaded_files/'.$prev_image);
                }
                $success_msg[]='profile picture changed';
            }
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
    <title>admin- update profile page</title>
</head>
<body>
  <div class="main-container">
    <?php include '../components/admin_header.php'; ?>
    
    <section class="form-container">
        <div class="heading">
            <h1> UPDATE  PROFILE</h1>
        </div>
        
        <form action="" method="post" enctype="multipart/form-data"  class="register">
            <div class="img-box">
                <img src="../uploaded_files/<?= $fetch_profile['image'];?>" >
            </div>
            <h3>Update Profile</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>your name <span>*</span></p>
                        <input type="text" name="name" placeholder="<?= $fetch_profile['name'];?>" class="box">
                    </div>
                    <div class="input-field">
                        <p>your email <span>*</span></p>
                        <input type="email" name="email" placeholder="<?= $fetch_profile['email'];?>" class="box">
                    </div>
                    <div class="input-field">
                        <p>select picture <span>*</span></p>
                        <input type="file" name="image" accept="image/* " class="box">
                    </div>
                </div>
                
            </div>
            <input type=" submit" name="submit" value="Update profile" class="btn"  >
        </form>
        
       

    </section>
    </div>
    




  







<!-- sweetalertcdn -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script type="text/javascript" src="../js/admin_script.js"></script>
  <!-- alert -->
  <?php include '../components/alert.php'; ?>
</body>
</html>
