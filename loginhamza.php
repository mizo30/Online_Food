//login page

<?php
   include 'config.php';
   session_start();

   if(isset($_POST['submit'])){
      $name = maysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $pass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
      $image = $_FILES['image']['name'];
      $image_size = $_FILES ['image']['image_size'];
      $image_tmp_name = $_FILES['image']['tmp_name'];
      $image_folder = 'uploaded_img'.$image;

      $select = mysqli_query($conn,"SELECT * FROM `user_form` WHERE email='$email' AND password='$pass' ")or die('query failed');

      if(mysqli_num_rows($select)>0){

         $row = mysqli_fetch_array($select);
         if($row ['user_type'] == 'admin'){
            $_SESSION['admin_name'] == $row['name'];
            header('location:admin.php');
         }elseif($row['user_type']='user'){
            $_SESSION['user_name'] = $row['name'];
            header('location:user.php');
         }

      }else{
         $message[]='incorrect email or passworde';
      }

      
   }
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <form action="" method="POST">
   <h1>regester new:</h1>
   <?php
      if(isset($message)){
         foreach($message as $message){
            echo'<div class="message">'.$message.'</div>';
         }
      }
   ?>
      <input type="email" name="email" id="" />
      <input typr="password" name="password" id="" />
      <input typr="submit" value="login now" />
      <p>don't have an account?<a href="./test_register">register now</a></p>

   </form>
</body>
</html>
//logout.page 

<?php
include 'config.php';

session_start();
session_unset();
session_destory();

header('location:login.php');
?>

//config.page 
<?php
$conn = mysqli_connect('localhost','root','','data_name') or die('data_basse not connected');
?>


//page_register

<?php
include 'config.php';

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli-real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5['cpassword']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded/img'.$image;

   $select = mysqli_query($conn,"SELECT * FROM `user_form` WHERE email='$email' AND password='$pass' ") or die('query failed');

   if(mysqli_num_rows($select)>0){
      $message[] = 'user excite deja';
   }else{
      if($pass != $cpass){
         $message[] = 'password incorect';
      }elseif($image_size >200000){
         $message[] = 'image size is too large';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form` (name , email, password, cpassword) VALUES('$name','$email','$pass','$cpass')") or die('query failed');
         
         if($insert){
            $message[]= 'enregistrement successfuly';
            header('location:login.php');
         }else{
            $message[] = 'enregistrement not successufult';
         }
      }
      
   }
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <form action="" metghod="POST">
      <h1>register:</h1>
      <?php
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>

      <input type="text" name="name">
      <input type="email" name="email">
      <input type="password" name="password">
      <input type="password" name="cpassword">
      <input type="file" name="image" accept="image/jpg">
      <input type="submit" value="register now">
      <p>already have an account?<a href="./test_login.php">login now</a></p>
   </form>
</body>
</html>

