<?php
session_start();
if(empty($_SESSION['email'])){
  
   ?>
   <!-- alert("login first!"); -->
   <?php
    $message[] = 'Login first';
   header('location:login.php');  
}


@include 'db_connect.php';

if(isset($_POST['checkout'])){
   if(!empty($_SESSION['email'])){
      $user_id = $_SESSION['user_id'];
      $cart_query =  mysqli_query($con, "SELECT * FROM `cart` where `user_id` = '$user_id' ");
      if(mysqli_num_rows($cart_query) > 0){
         while($fetch_cart = mysqli_fetch_assoc($cart_query)){
            $product_id = $fetch_cart['product_id'];
            $product_quantity = $fetch_cart['quantity'];
            $status = 0; 
            mysqli_query($con, "UPDATE `cart` set `status` = '$status' where `user_id` = '$user_id'");
            $insert_query = "INSERT INTO `orders`( `user_id`, `product_id`, `quantity`) 
            VALUES ('$user_id', '$product_id', '$product_quantity')";
            $iquery = mysqli_query($con, $insert_query);

         }
         
      }   

      
      $message[] = 'Succesfully ordered';
      mysqli_query($con, "DELETE from `cart` where `user_id` = '$user_id'");
       
   }
   else{
      $message[] = 'Login first';
   }
}

if(isset($_GET['delete_all'])){
   $user_id = $_SESSION['user_id'];
   mysqli_query($con, "DELETE FROM `cart` where `user_id` = '$user_id'");
   // header('location:cart.php');
}

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
        <th>image</th>
        <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
      </thead>

      <tbody>

         <?php 

           $grand_total = 0;
           if(!empty($_SESSION['email'])){

               $user_id = $_SESSION['user_id'];

               $cart_query =  mysqli_query($con, "SELECT * FROM `cart` where `user_id` = '$user_id' ");
               if(mysqli_num_rows($cart_query) > 0){
                  while($fetch_cart = mysqli_fetch_assoc($cart_query)){
               
                     $product_id = $fetch_cart['product_id'];
                     $unit_price = $fetch_cart['unit_price'];
                     $product_quantity = $fetch_cart['quantity'];
                     $total_price = $fetch_cart['total_price'];

                     $product_query =  mysqli_query($con, "SELECT * FROM `products` where id = '$product_id'");
                     $fetch_product = mysqli_fetch_assoc($product_query); 
                     $product_image = $fetch_product['image'];
                     $product_name = $fetch_product['name'];

               echo "<tr>";

                     echo '<td>';
                     echo "<img src='uploaded_img/$product_image' height='100' alt=''>";
                     echo '</td>';
                     
                     echo '<td>';
                     echo $product_name;
                     echo '</td>';

                     echo '<td>';
                     echo $unit_price;
                     echo '</td>';

                     echo '<td>';
                     echo $product_quantity;
                     echo '</td>';
                     echo '<td>';
                     echo $total_price;
                     echo '</td>';
                  
                  
                  
                  echo "</tr>"; 
                  $grand_total += $total_price;
               }
            }    

           }
           if(!empty($_SESSION['cart'])){
               foreach($_SESSION['cart'] as $products){

                  // echo '<pre>';
                  // // var_dump($products['product_id']);
                  // echo $products['product_id'];
                  // exit();

                  $product_id = $products['product_id'];
                  $product_quantity = $products['product_quantity'];

                  $product_query =  mysqli_query($con, "SELECT * FROM `products` where id = '$product_id'");
                  $fetch_product = mysqli_fetch_assoc($product_query); 
                  $product_image = $fetch_product['image'];
                  $product_name = $fetch_product['name'];
                  $unit_price = $fetch_product['price'];

                  $total_price = $product_quantity * $unit_price;   
                  
                  echo "<tr>";
      
                     echo '<td>';
                     echo "<img src='uploaded_img/$product_image' height='100' alt=''>";
                     echo '</td>';
                     
                     echo '<td>';
                     echo $product_name;
                     echo '</td>';

                     echo '<td>';
                     echo $unit_price;
                     echo '</td>';

                     echo '<td>';
                     echo $product_quantity;
                     echo '</td>';
                     echo '<td>';
                     echo $total_price;
                     echo '</td>';

                  echo "</tr>";
                  
                  $grand_total += $total_price;
               
            }
               
           
         }
      

            
         
         ?>
         <tr class="table-bottom">
            <td><a href="index.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
            <td colspan=2>grand total</td>
            <td><?= $grand_total; ?>Taka/-</td>
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