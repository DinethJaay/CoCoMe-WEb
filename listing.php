<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

if(isset($_POST['add'])){


    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $categories = $_POST['categories'];
    $categories = filter_var($categories, FILTER_SANITIZE_STRING);
   

   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);

    $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = 'uploaded_img/'.$image_01;

   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $pcode = $_POST['pcode'];
    $pcode = filter_var($pcode, FILTER_SANITIZE_STRING);

   


  

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name,category,price,image,details,pcode) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$name, $categories, $price,$image_01,$details,$pcode]);

      if($insert_products){
         if($image_size_01 > 2000000){
            $message[] = 'image size is too large!';
         }else
         {
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            
            $message = 'new product added!';

             echo "<script type='text/javascript'>alert('$message');location='listing.php'</script>";
         }

      }

   }  

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/stylee.css">
   <!-- <link rel="stylesheet" href="css/listing.css"> -->
   <style>

  .products {
    background-color: #f0f0f0;
    padding: 20px;
    display: flex;
    justify-content: center;
  }

  .container {
    max-width: 800px;
    margin: 0 auto;
  }

  .wrapper {
    width: 600px;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    margin: 0 auto;
  }
</style>



</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>our menu</h3>
   <p><a href="index.php">home</a> <span> / Listing</span></p>
</div>

<!-- menu section starts  -->

<section class="products">
    <div class="container">
        <div class="wrapper">
            <div class="title" style="font-size: 24px; font-weight: bold; text-align: center; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                LISTING DETAILS FORM
            </div>
            <div style="padding: 20px;">
                <form action="" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" onkeyup="validateName()" style="width:500px">
                        <span id="Name_Error"></span>
                    </div>

                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <label for="categories">Categories</label>
                        <div class="category_select">
                            <select class="form-control" id="categories" name="categories" onkeyup="validate_Categories()" style="width:500px">
                                <option>select</option>
                                <option value="Coconut">Coconut</option>
                                <option value="Tea">Tea</option>
                                <option value="Rubber">Rubber</option>
                            </select>
                        </div>
                        <span id="Categories_Error"></span>
                    </div>

                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <label for="image_01">Image 01 (required)</label>
                        <input type="file" class="form-control-file" id="image_01" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" style="width:500px" required>
                    </div>

                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" max="9999999999" onkeyup="validatePrice()" style="width:500px">
                        <span id="Price_Error"></span>
                    </div>

                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <label for="details">Details</label>
                        <textarea class="form-control" id="details" name="details" onkeyup="validateDetails()" style="width:500px"></textarea>
                        <span id="Details_Error"></span>
                    </div>

                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <label for="pcode">Postal Code</label>
                        <input type="text" class="form-control" id="pcode" name="pcode" onkeyup="validatePostalCode()" style="width:500px">
                        <span id="Postal_Code_Error"></span>
                    </div>

                    <div class="form-group" style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                        <input type="submit" value="Add Product" class="btn btn-primary" name="add" style="width: 100%; height: 50px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- menu section ends -->



<script type="text/javascript">
    var Name_Error=document.getElementById('Name_Error');
    var Categories_Error=document.getElementById('Categories_Error'); 
    var Price_Error = document.getElementById('Price_Error');
    var Details_Error = document.getElementById('Details_Error');  
    var Postal_Code_Error=document.getElementById('Postal_Code_Error'); 
    

    function validateName()
    {
    
    var Name=document.getElementById('name').value.replace(/^\s+|\s+$/g, "");
    if(Name.length == 0)
    {
        Name_Error.innerHTML='Name is required.';
        return false;
    }
    Name_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
    }

    


    function validate_Categories()
    {
    if(document.getElementById("categories").value == "S")
    {
        Categories_Error.innerHTML='Categories is required.';
        return false;
    }
    Categories_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
    }
    
    document.getElementById("categories").addEventListener("click", function() {

    if (document.getElementById("categories").value != "S") {

        Categories_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
    }
    });


    function validatePrice()
    {
    
    var Price=document.getElementById('price').value.replace(/^\s+|\s+$/g, "");
    if(Price.length == 0)
    {
        Price_Error.innerHTML='Price is required.';
        return false;
    }
    Price_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
    }



    function validateDetails()
    {
    
    var Details=document.getElementById('details').value.replace(/^\s+|\s+$/g, "");
    if(Details.length == 0)
    {
        Details_Error.innerHTML='Details is required.';
        return false;
    }
    Details_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
    }

    function validatePostalCode()
    {
    
    var Postal_Code=document.getElementById('pcode').value.replace(/^\s+|\s+$/g, "");
    if(Postal_Code.length == 0)
    {
        Postal_Code_Error.innerHTML='Postal Code is required.';
        return false;
    }
    Postal_Code_Error.innerHTML = '<i class="fa-regular fa-circle-check"></i>';
    return true;
    }


    function validateForm()
    {
        validateName();
        validate_Categories();
        validatePrice();
        validateDetails();
        validatePostalCode();

    if((!validateName()) || (!validate_Categories()) ||  (!validatePrice()) || (!validateDetails()) || (!validatePostalCode()))
    {
    return false;
    }
    }
    </script>





















<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>