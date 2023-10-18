<?php

include '../components/connect.php';

session_start();


$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>view reservations</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/adminn_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- placed orders section starts  -->

<section class="view-reservation">

   <h1 class="heading">view reservations</h1>

   <div class="box-container">

   <?php
      $select_reservations = $conn->prepare("SELECT * FROM `reservations`");
      $select_reservations->execute();
      if($select_reservations->rowCount() > 0){
         while($fetch_reservations = $select_reservations->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
      <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> number of guest : <span><?= $fetch_orders['num_guest']; ?></span> </p>
      <p> number of tables : <span><?= $fetch_orders['num_table']; ?>/-</span> </p>
      <p> time : <span><?= $fetch_orders['type']; ?></span> </p>
      <form action="" method="POST">
         <input type="hidden" name="reservation_id" value="<?= $fetch_orders['id']; ?>">
         
         
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">no tables reserved yet!</p>';
   }
   ?>

   </div>

</section>

<!-- view reservation section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>