<?php
session_start();


@include 'db_connect.php';

// unset($_SESSION['email']);
// unset($_SESSION['name']);

// echo "<pre>";
// var_dump($_SESSION);
// exit;

// if(isset($_POST['checkout'])){
//       if(isset($_SESSION['email'])){

//          $email = $_SESSION['email'];
//          $user_id = "SELECT id from `registration` where `email` = '$email' ";
//          // $product_name = $_SESSION['product_name'];

//          $select_products = mysqli_query($con, "SELECT id FROM `products` where `name` = '$product_name' ");
//             $fetch_product = mysqli_fetch_assoc($select_products);
//             $p_id = $fetch_product['id'];
//             // $quantity = $_SESSION['quantity'];

            
           

//          foreach($_SESSION[$product_name] as $products){
            

//             foreach($products as $key => $value){
               
//                if($key == 0){
                 
//                   $insertquery = "INSERT INTO `cart`(`user_id`) SELECT `id` from `registration` where email = '$email' ";
//                   $value = mysqli_query($con, $insertquery);
//                }
               
//                else if($key == 1){
                  
//                   $insertquery = " UPDATE `cart` SET product_id = '$p_id' ";
//                   $value = mysqli_query($con, $insertquery);
                  
                  
//                }
//                else if($key == 2){
                  
//                   $insertquery = " UPDATE `cart` SET quantity = '$quantity' ";
//                   $value = mysqli_query($con, $insertquery);
                  
                  
//                }

//             }
            

//          }

//          // $email = $_SESSION['email'];
//          // $user_id = "SELECT id from `registration` where `email` = '$email' ";
//          // $product_name = $_SESSION['product_name'];

//          // $select_products = mysqli_query($con, "SELECT id FROM `products` where `name` = '$product_name' ");
//          //    $fetch_product = mysqli_fetch_assoc($select_products);
//          //    $p_id = $fetch_product['id'];
            
//          //    $quantity = $_SESSION['quantity'];
            
//          //    $insertquery = "INSERT INTO `cart`(`user_id`) SELECT `id` from `registration` where email = '$email' ";
//          //    $iquery = mysqli_query($con, $insertquery);
            
//          //    $insertquery2 = " UPDATE `cart` SET product_id = '$p_id' , quantity = '$quantity' ";
//          //    $iquery_two = mysqli_query($con, $insertquery2);
        
//          $message[] = 'Succesfully Ordered!';
          
//       }
//       else{
//          $message[] = 'Login first!';
//          // header('location:cart.php');
//       }
// }

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>shopping cart</title>
   <?php include 'links.php'; ?>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>

      <thead>
        <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
      </thead>

      <tbody>

         <?php 

            $total = 0;
            $totalAll = 0;
            $grand_total = 0;
            $q_total = 0;
         
            $p = 0;
            $q = 0;

            // if(!empty($_SESSION['name'])){}

            foreach($_SESSION as $products){
              
               
               echo "<tr>";
               
               foreach($products as $key => $value){

               
                  
                  if($key == 'name'){
                    
                     echo "<td>".$value."</td>";
                     $p_name = $value;
                  }
                  
                  else if($key == 'price'){
                  
                     echo "<td>".$value."</td>";
                     $p = $value;
                     
                  }
                  else if($key == 'quantity'){
                    
                     echo "<td>".$value."</td>";
                     $q = $value;

                    
                  }
                  else if($key == 'totalPrice'){
                     $total = ($q * $p);
           
                     echo "<td>".($total)."</td>";
                    
                  }
                  
               

               }

               
               
               echo "</tr>";
               
               $totalAll +=  $total;
               $q_total += $q;
               
               
            }
            $grand_total += $totalAll; 
            

            // $_SESSION['product_name'] =  $p_name;
            // $_SESSION['quantity'] = $q;

            // $_SESSION['quantity'] = $q_total;
            
            
         
         ?>
         <tr class="table-bottom">
            <td><a href="index.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan=2>grand total</td>
            <td><?php echo $grand_total; ?>Taka/-</td>
         </tr>
         
      </tbody>
      
   </table>
   <form action=' ' method='post'>
      <input type="submit" class="option-btn order-btn" name="checkout" value="Order Now">
   </form>
</section>

</div>
   
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>