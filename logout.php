<?php 
   session_start();
   session_destroy();
   header('location:index.php');

   include 'db_connect.php';
   if(isset($_POST['logout'])){
      $removeToken = " UPDATE registration SET token = '' ";
      mysqli_query($con, $removeToken);

      // $insertType = " UPDATE `registration` SET user_type = '' ";
      // $iquery = mysqli_query($con, $insertType);

      echo  $_SESSION['name'] = "";
      
   }
?>