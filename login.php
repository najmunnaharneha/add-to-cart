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
      if(isset($_POST['login'])){
         $email = mysqli_real_escape_string($con, $_POST['email']);
         $password = mysqli_real_escape_string($con, $_POST['password']);

         

         $user_query = " select * from registration where email = '$email' limit 1 ";
         $query = mysqli_query($con, $user_query);
         $user_data = mysqli_num_rows($query);

         if($user_data){ 

            $user_data = mysqli_fetch_assoc($query);

            $db_pass = $user_data['password'];

            $pass_decode =  password_verify($password, $db_pass);
            
            if($pass_decode){ 
               ?>
                  <script>
                     alert("Login Successful");
                  </script>
                  <?php
                  header('location:index.php');
                  
                  $token = rand();
            
                  $insertquery = "UPDATE `registration` SET token = '$token' where email = '$email' ";
                  $iquery = mysqli_query($con, $insertquery);

                  
                  
                  $_SESSION['user_id'] = $user_data['id'];
                  $_SESSION['name'] = $user_data['name'];
                  $_SESSION['email'] = $user_data['email'];
                  $_SESSION['user'] = $user_data['user'];
                  $_SESSION['usertype'] = $user_data['user_type'];

                 if(!empty($_SESSION['cart'])){
                        
                        $_SESSION['cart'][] = [
                        'product_id' => $_POST['product_id'],
                        'product_quantity' => $_POST['product_quantity']
                     ];

                     foreach($_SESSION['cart'] as $products){
                     // echo "<pre>";
                     // var_dump($products['product_quantity']);
                     // exit();
                     
                     
                     $product_id = $products['product_id'];
                     if($product_id != null){
                     $product_quantity = $products['product_quantity'];

                     $user_id = $_SESSION['user_id'];
   
                     $cart_query =  mysqli_query($con, "SELECT * FROM `cart` where product_id = '$product_id' and `user_id` = '$user_id' ");
                     $fetch_quantity = mysqli_fetch_assoc($cart_query);
                     $old_quantity = $fetch_quantity['quantity'];
                     $update_quantity = $product_quantity + $old_quantity;
                     
                     $product_query =  mysqli_query($con, "SELECT * FROM `products` where id = '$product_id'");
                     $fetch_product = mysqli_fetch_assoc($product_query);  
                     $unit_price = $fetch_product['price'];
                      
                     $total_price = $product_quantity * $unit_price;
                     
                     $product_count = mysqli_num_rows($cart_query);

                     $status = 1;
   
                     if($product_count>0){
                        $total_price = $update_quantity * $unit_price;
                        $update_query = mysqli_query($con, "UPDATE `cart` SET quantity = '$update_quantity', total_price = '$total_price', `status` = ' $status' WHERE product_id = '$product_id' and `user_id` = '$user_id' ");
                     
                     }
               
                     else{
                        

                        $insert_query = "INSERT INTO `cart`( `user_id`, `product_id`, `quantity`, `unit_price`,`total_price`,`status`) 
                        VALUES ('$user_id', '$product_id', '$product_quantity', '$unit_price', '$total_price','$status')";
                        $iquery = mysqli_query($con, $insert_query);             
               
                     }
                  
                     } 
   
                  }
            
                  unset ($_SESSION['cart']); 
               }
                
                  
            }

            
            else{
               ?>
               <script>
                  alert("Password Incorrect");
               </script>
               <?php
            }
            
         }
         else{
            ?>
                  <script>
                     alert("Invalid Email");
                  </script>
                  <?php
            
         }
      }
      


   ?>

      <div class="container">
         <div class="reg-form">
            <h1>Login Now</h1>
            <form action="login.php" method="post">
               
               <div class="input-group row">
                  <input type="email" name="email" id="email" class="form-control col-md-12" placeholder="Email Address" required />
               </div>
               <div class="input-group row">
                  <input type="password" name="password" id="password" class="form-control col-md-12" placeholder="Password" required />
               </div>
               <div class="input-group row">
                  <input type="submit" class="btn btn-primary col-md-4 text-center" name="login" id="login-btn" value="Login">
               </div>

               <p>Don't have an account? <a href="register.php">Register Now</a></p>
              
              
               
            </form>
         </div>
         


         
      </div>

      <script src="index.js"></script>
   </body>
</html>


