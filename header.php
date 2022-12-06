
<header class="header">
 
   <div class="flex">

      <div class="logo">
         <a href="index.php"><img src="images/mobil-logo.svg" alt=""></a>
      </div>
      

      <?php
      
      
      // $select_rows = mysqli_query($con, "SELECT * FROM `cart`") or die('query failed');
      // $row_count = mysqli_num_rows($select_rows);

      

      ?>
      
     
      
      <?php 
      include 'db_connect.php';
      
      
      if(isset($_SESSION['name'])){
        

      ?>
      <div class="menu">
         <form action="logout.php" method="post" class="mt-40">
            <input type="submit" class="logout-btn" name="logout" id="logout" value="Log Out">
          </form>
         <a class="signup-btn"><?php echo  $_SESSION['name']; ?> </a>
         <!-- <a class="signup-btn" href="update-form.php">Update?</a> -->
               
         <?php
         }
         else{
            ?>
            

         
         <a href="login.php" id="signup-btn" class="signup-btn">Sign Up / Sign In</a>
         <?php
         }
         
         ?>
         <a href="login.php" class="signup-btn"><i class="fa fa-user"></i></a>

         <!-- <a href="cart.php" class="cart">cart <span><?php echo sizeof(array($_SESSION)); ?></span> </a> -->
         <a href="cart.php" class="cart">cart </a>
         <a href="cart.php" class="signup-btn"><i class="fa fa-cart-shopping"></i></a>

         <!-- <div id="menu-btn" class="fas fa-bars"></div> -->
         <!-- <nav class="navbar">
            <a href="admin.php">Admin Panel</a>
         </nav> -->
      </div>

   </div>

</header>