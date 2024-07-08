<header class="footer">

   <div class="flex">

      <a href="#" class="logo">cafe KTHM</a>

      <nav class="navbar">
       
         <a href="products.php">📃Menu</a>
      </nav>

      <?php
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);
      ?>

         <a href="cart.php" class="cart">🛒 cart <span><?php echo $row_count; ?></span> </a>

   </div>

</header> 