<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $num_guest = $_POST['num_guest'];
   $num_guest = filter_var($num_guest, FILTER_SANITIZE_STRING);
   $num_tables = $_POST['num_guest'];
   $num_tables = filter_var($num_tables, FILTER_SANITIZE_STRING);
   $time = $_POST['time'];
   $time = filter_var($time, FILTER_SANITIZE_STRING);

   $insert_reservations = $conn->prepare("INSERT INTO `users`(name, email, number, num_guest,num_tables,time) VALUES(?,?,?,?,?,?)");
         $insert_reservations->execute([$name, $email, $number, $num_guest,$num_tables,$time]);





   
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>reservations</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>orders</h3>
   <p><a href="index.php">home</a> <span> / reservations</span></p>
</div>

<section class="orders">

   <h1 class="title">your reservations</h1>

   <div class="box-container">
      
   </div>

   <section class="form-container">

   <form action="" method="post">
      <h3>new reservations</h3>
      <input type="text" class="box" placeholder="enter your name" maxlength="50" >
      <input type="text" class="box" placeholder="enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" class="box" placeholder="enter your contact number" min="0" max="9999999999" maxlength="10">
      <input type="text" class="box" placeholder="enter number of guest" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" class="box" placeholder="enter number of tables" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" >
      <input type="text" class="box" placeholder="enter time" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" >
      
      
      <input type="submit" value="save reservation" name="submit" class="btn" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
   </form>

</section>
</section>

<script src="js/script.js"></script>

</body>
</html>

<?php include 'components/footer.php'; ?>