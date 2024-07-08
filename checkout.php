<?php

@include 'config.php';

if(isset($_POST['order_btn']))
{
   $name = $_POST['name'];
   $number = $_POST['number'];
   $table = $_POST['table'];
   $method = $_POST['method'];

   

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);

   $detail_query = mysqli_query($conn, "INSERT INTO `order`(`name`, `number`, `table`, `method`, `total_products`, `total_price`) 
   VALUES('$name','$number','$table','$method','$total_product','$price_total')")or die('query failed');


   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Your order is placed <br>Please wait for reach ⏳</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : ₹ ".$price_total."/-  </span>
         </div>
         <div class='customer-details'>
            <p> your name : <span>".$name."</span> </p>
            <p> Phone number : <span>".$number."</span> </p>
            <p> table no. : <span>".$table."</span> </p>
            <p> your payment mode : <span>".$method."</span> </p>
            <p>(*pay when i leave*)</p>
         </div>
            <a href='products.php' class='btn'>continue shopping</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">


</head>
<body>

<?php include 'footer.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">⏳ complete your order ⏳</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>your cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> grand total : ₹ <?= $grand_total; ?>/- </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>your name</span>
            <input type="text" placeholder="Enter Your Name" name="name" required>
         </div>
         <div class="inputBox">
            <span>Phone number</span>
            <input type="text" placeholder="Enter Phone Number" name="number" required>
         </div>
        
         <div class="inputBox">
            <span>Table number</span>
            <input type="text" placeholder="Enter Your Table No." name="table" required>
         </div>
         <div class="inputBox">
            <span>payment method</span>
            <select name="method">
               <option value="cash on delivery" selected>Cash payment</option>
               <option value="UPI Pay">Online payment</option>
            </select>
         </div>
         
   
      </div>
      <input type="submit" value="order now" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>