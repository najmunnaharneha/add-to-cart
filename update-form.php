<?php 
   session_start();
   if(!isset($_SESSION['name'])){
      echo "You are logged out";
      header('location:index.php');
      
   }
   else{
      header('location: ');
   }
   
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      
      <title>PHP Form</title>
      <?php include 'links.php'; ?>
      <link rel="stylesheet" href="css/regform.css">

   </head>
   <body>

   <?php
      
      include 'db_connect.php';

      if(isset($_POST['update'])){
         $update_name = mysqli_real_escape_string($con, $_POST['name']);
         $update_email = mysqli_real_escape_string($con, $_POST['email']);
         $update_phone = mysqli_real_escape_string($con, $_POST['phone']);
         $update_user = mysqli_real_escape_string($con, $_POST['user']);
         $update_password = mysqli_real_escape_string($con, $_POST['password']);
         $update_cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
         $update_usertype = mysqli_real_escape_string($con, $_POST['usertype']);

         $update_pass = password_hash($update_password, PASSWORD_DEFAULT);
        
         $email = $_SESSION['email'];
         $_SESSION['usertype'] = $_POST['usertype'];
   
            if($update_password === $update_cpassword){
               $update_query = mysqli_query($con, "UPDATE `registration` SET `name` = '$update_name', `email` = '$update_email', `phone` = '$update_phone', `username` = '$update_user', `password` = '$update_pass', `user_type` = '$update_usertype' WHERE email = '$email'");
               if($update_query){
                  ?>
                  <script>
                     alert("Successfully Updated");
                  </script>
                  <?php

               header('location:index.php');

               }
               else{
                  ?>
                  <script>
                     alert("No Connection");
                  </script>
                  <?php
               }
              
               
            }
            else{
               ?>
                  <script>
                     alert("Password does not match!");
                  </script>
                  <?php
              
            }
      }


   ?>

      <div class="container">
         <div class="reg-form">
            <h1>Update Now</h1>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" method="post">
               <div class="input-group row">
                  <input type="text" name="name" id="name"  class="form-control col-md-12" placeholder="Full Name" value="<?= !empty($_POST['name']) ?  $_POST['name'] : ''; ?>" required />
               </div>
               <div class="input-group row">
                  <input type="email" name="email" id="email" class="form-control col-md-12" placeholder="Email Address" value="<?= !empty($_POST['email']) ?  $_POST['email'] : ''; ?>" required />
               </div>
               <!-- <div class="input-group row">
                  <input type="phone" name="phone" id="phone" class="form-control col-md-12" placeholder="Phone Number" value="<?= !empty($_POST['phone']) ?  $_POST['phone'] : ''; ?>" required />
               </div> -->
               <div class="input-group row">
                  <input type="text" name="user" id="user" class="form-control col-md-12" placeholder="Username" value="<?= !empty($_POST['user']) ?  $_POST['user'] : ''; ?>" required />
               </div>
               <div class="input-group row">
                  <select name="usertype" class="custom-select" id="inputGroupSelect04" value="<?= !empty($_POST['usertype']) ?  $_POST['usertype'] : ''; ?>" required>
                     <option value="" selected>User Type</option>
                     <option value="admin">Admin</option>
                     <option value="user">User</option>
                  </select>
               </div>
               <div class="input-group row">
                  <input type="password" name="password" id="password" class="form-control col-md-12" placeholder="Password" value="<?= !empty($_POST['password']) ?  $_POST['password'] : ''; ?>" required />
               </div>
               <div class="input-group row">
                  <input type="password" name="cpassword" id="cpassword" class="form-control col-md-12" placeholder="Confirm Password" value="<?= !empty($_POST['cpassword']) ?  $_POST['cpassword'] : ''; ?>" required />
               </div>

               <div class="input-group row">
                  <input type="submit" class="btn btn-primary col-md-4 text-center" name="update" value="Update Account">
               </div>
            </form>
         </div>
         


         
      </div>

      <script src="index.js"></script>
   </body>
</html>


