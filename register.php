<?php 
   session_start();
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

      if(isset($_POST['submit'])){
         $name = mysqli_real_escape_string($con, $_POST['name']);
         $email = mysqli_real_escape_string($con, $_POST['email']);
         $user = mysqli_real_escape_string($con, $_POST['user']);
         $password = mysqli_real_escape_string($con, $_POST['password']);
         $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
         $usertype = mysqli_real_escape_string($con, $_POST['usertype']);
         $_SESSION['usertype'] = $_POST['usertype'];
         // echo "<pre>";
         // var_dump($_SESSION['usertype']);
         // exit();

         $pass = password_hash($password, PASSWORD_DEFAULT);
         // $cpass = password_hash($cpassword, PASSWORD_DEFAULT);

         $emailquery = " select * from registration where email = '$email' ";
         $userquery = "select * from registration where username = '$user' ";
         $query1 = mysqli_query($con, $emailquery);
         $query2 = mysqli_query($con, $userquery);
         $emailcount = mysqli_num_rows($query1);
         $usercount = mysqli_num_rows($query2);
        
 
         if($emailcount>0){
            ?>
                  <script>
                     alert("Email already exists");
                  </script>
                  <?php
            
         }
         if($usercount>0){
            ?>
            <script>
                  alert("User already exists");
               </script>
               <?php

         }
         else{
            if($password === $cpassword){
               $insertquery = "INSERT INTO `registration`(`name`, `email`, `username`, `password`,`user_type`) VALUES ('$name','$email','$user','$pass','$usertype')";
               $iquery = mysqli_query($con, $insertquery);
               if($iquery){
                  ?>
                  <script>
                     alert("Successfully Inserted");
                  </script>
                  <?php

                  header('location:login.php');

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


      }


   ?>

      <div class="container">
         <div class="reg-form">
            <h1>Register Now</h1>
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" method="post">
               <div class="input-group row">
                  <input type="text" name="name" id="name" class="form-control col-md-12" placeholder="Full Name" required />
               </div>
               <div class="input-group row">
                  <input type="email" name="email" id="email" class="form-control col-md-12" placeholder="Email Address" required />
               </div>
               <!-- <div class="input-group row">
                  <input type="phone" name="phone" id="phone" class="form-control col-md-12" placeholder="Phone Number" required />
               </div> -->
               <div class="input-group row">
                  <input type="text" name="user" id="user" class="form-control col-md-12" placeholder="Username" required />
               </div>
               <div class="input-group row">
                  <select name="usertype" class="custom-select" id="inputGroupSelect04" required>
                     <option value="" selected>User Type</option>
                     <option value="admin">Admin</option>
                     <option value="user">User</option>
                  </select>
               </div>
               <div class="input-group row">
                  <input type="password" name="password" id="password" class="form-control col-md-12" placeholder="Password" required />
               </div>
               <div class="input-group row">
                  <input type="password" name="cpassword" id="cpassword" class="form-control col-md-12" placeholder="Confirm Password" required />
               </div>

               <div class="input-group row">
                  <input type="submit" class="btn btn-primary col-md-4 text-center" name="submit" value="Create Account">
               </div>
              
              <p>Already have an account? <a href="login.php">Log in</a></p>
               
            </form>
         </div>
         


         
      </div>

      <script src="index.js"></script>
   </body>
</html>


