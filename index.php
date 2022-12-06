<?php

session_start();


@include 'db_connect.php';

//   echo "<pre>";
//       var_dump($_SESSION);
//       exit();


if(isset($_POST['add_to_cart'])){
   

   if(!empty($_SESSION['email'])) {

      if(!empty($_SESSION['cart'])){
                  
         $_SESSION['cart'][] = [
            'product_id' => $_POST['product_id'],
            'product_quantity' => $_POST['product_quantity']
         ];

         $user_id = $_SESSION['user_id'];
         $product_id = $_SESSION['cart'][0]['product_id'];        
         $product_quantity = $_SESSION['cart'][0]['product_quantity'];

         $cart_query =  mysqli_query($con, "SELECT * FROM `cart` where product_id = '$product_id' and `user_id` = '$user_id'");
         
         $product_query =  mysqli_query($con, "SELECT * FROM `products` where id = '$product_id'");
         $fetch_product = mysqli_fetch_assoc($product_query);  
         $unit_price = $fetch_product['price'];
          
         $total_price = $product_quantity * $unit_price;
         
         $product_count = mysqli_num_rows($cart_query);

         $status = 1;
         
         if($product_count>0){
            $fetch_quantity = mysqli_fetch_assoc($cart_query);
            $old_quantity = $fetch_quantity['quantity'];
            $update_quantity = $product_quantity + $old_quantity;
            $update_query = mysqli_query($con, "UPDATE `cart` SET quantity = '$update_quantity' WHERE product_id = '$product_id' and `user_id` = '$user_id'");
             
         }
         else{
            $insert_query = "INSERT INTO `cart`( `user_id`, `product_id`, `quantity`, `unit_price`,`total_price`,`status`) 
            VALUES ('$user_id', '$product_id', '$product_quantity', '$unit_price', '$total_price','$status')";
            $iquery = mysqli_query($con, $insert_query);
         }
         
   }
      

      $user_id =  $_SESSION['user_id'];
      $product_id = $_POST['product_id'];

      $product_query =  mysqli_query($con, "SELECT * FROM `products` where id = '$product_id'");
      $fetch_product = mysqli_fetch_assoc($product_query);
      
      $product_quantity = $_POST['product_quantity'];
      $unit_price = $fetch_product['price'];
      $total_price = $product_quantity * $unit_price;

      $status = 1;

      $cart_query =  mysqli_query($con, "SELECT * FROM `cart` where product_id = '$product_id' and `user_id` = '$user_id'");    
      $product_count = mysqli_num_rows($cart_query);
         if($product_count>0){
            $fetch_quantity = mysqli_fetch_assoc($cart_query);
            $old_quantity = $fetch_quantity['quantity'];
            $update_quantity = $product_quantity + $old_quantity; 
            $total_price = $update_quantity * $unit_price;
            $update_query = mysqli_query($con, "UPDATE `cart` SET quantity = '$update_quantity', total_price = '$total_price' WHERE product_id = '$product_id' and `user_id` = '$user_id'");
            ?>
            <script>
               alert("Successfully Updated");
            </script>
            <?php
            $message[] = 'product updated to cart succesfully';
            
         }
         else{
            $insert_query = "INSERT INTO `cart`( `user_id`, `product_id`, `quantity`, `unit_price`,`total_price`,`status`) 
            VALUES ('$user_id', '$product_id', '$product_quantity', '$unit_price', '$total_price','$status')";
            $iquery = mysqli_query($con, $insert_query);
            ?>
            <script>
               // alert("Successfully Inserted");
               </script>
            <?php
            $message[] = 'product added to cart succesfully';
         }
      
     

   }
   else{
      
      $_SESSION['cart'][] = [
         'product_id' => $_POST['product_id'],
         'product_quantity' => $_POST['product_quantity']
      ];
      
      // echo "<pre>";
      // var_dump($_SESSION['cart']);
      // print_r(array_keys($_SESSION['cart'][1]));
      // echo '<br>';
      // print_r(array_values($_SESSION['cart'][0]));
      // exit();

      
      // if($_SESSION['cart'][0]['product_id'] ==  $_SESSION['cart'][1]['product_id']){
      //    $_SESSION['cart'][0]['product_quantity'] = $_SESSION['cart'][0]['product_quantity'] + $_SESSION['cart'][1]['product_quantity'];
      //    $_SESSION['cart'][1] = '';
      // }   
     
     

      // echo "<pre>";
      // var_dump($_SESSION['cart']);
      // exit();
      
      // echo "<pre>";
      // var_dump($_SESSION['cart'][0]['product_id']);
      // exit();


      $message[] = 'product added to cart succesfully';
   }
 
   

   
   // $p_name = $_SESSION['product_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

<div class="container">

<section class="products">

   <h1 class="heading">Our Products</h1>

   <div class="box-container">

      <?php
      
      $select_products = mysqli_query($con, "SELECT * FROM `products`");
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price"><?php echo $fetch_product['price']; ?>Taka</div>
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
            <input type="number" min=0 name="product_quantity" placeholder="Quantity" required class="form-control" style="text-align:center;font-size:16px;">
            <input type="submit" class="btn" value="add to cart" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>