<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if(isset($_POST['submit'])) {
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);

   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $pass = sha1($_POST['pass']);
       $pass = filter_var($pass, FILTER_SANITIZE_STRING);

       $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
       $select_user->execute([$email, $pass]);
       $row = $select_user->fetch(PDO::FETCH_ASSOC);

       if($select_user->rowCount() > 0){
           if($row['type'] == 'buyer') {
               $_SESSION['user_id'] = $row['id'];
               header('location:index.php');
           } else if($row['type'] == 'seller') {
               $_SESSION['user_id'] = $row['id'];
               header('location:listing.php');
           }
       } else {
           $message[] = 'Incorrect username or password!';
       }
   } else {
       $message[] = 'Invalid email address!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/stylee.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

    <form action="#" method="post" autocomplete="off" onsubmit="return validateForm()">
      <h3>login now</h3>

      <div>
      <input type="email" name="email" id="UserEmail" required placeholder="enter your email" class="box" maxlength="50" onkeyup="validateUserEmail()">
       <span id="UserEmail_Error"></span>
    </div>
    <div>
      <input type="password" name="pass" id="Password" required placeholder="enter your password" class="box" maxlength="50" onkeyup="validatePassword()">
       <span id="Password_Error"></span>
    </div>
      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>

<script type="text/javascript">
    var UserEmail_Error = document.getElementById('UserEmail_Error'); 
    var Password_Error = document.getElementById('Password_Error');
   
    function validateUserEmail() {
        var Email = document.getElementById('UserEmail').value.replace(/^\s+|\s+$/g, "");

        if (Email.length == 0) {
            UserEmail_Error.innerHTML = 'User Email is required.';
            return false;
        } else {
            var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!Email.match(emailPattern)) {
                UserEmail_Error.innerHTML = 'Please Enter UserEmail in the correct format.';
                return false;
            }
            UserEmail_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
            return true;
        }
    }

    function validatePassword() {
        var Password = document.getElementById('Password').value.replace(/^\s+|\s+$/g, "");

        if (Password.length == 0) {
            Password_Error.innerHTML = 'Password is required.';
            return false;
        } else {
            const PasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!Password.match(PasswordPattern)) {
                Password_Error.innerHTML = 'Please Enter Password with Numbers, symbols, upper and lower case (minimum 8 characters)';
                return false;
            }
            Password_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
            return true;
        }
    }

    function validateForm() {
        if (!validateUserEmail() || !validatePassword()) {
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
