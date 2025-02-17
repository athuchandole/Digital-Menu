<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['fname'])) {
   ?>

   <?php

   @include 'config.php';

   if (isset($_POST['add_product'])) {
      $p_name = $_POST['p_name'];
      $p_price = $_POST['p_price'];
      $p_image = $_FILES['p_image']['name'];
      $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
      $p_image_folder = 'uploaded_img/' . $p_image;

      $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$p_name', '$p_price', '$p_image')") or die('query failed');

      if ($insert_query) {
         move_uploaded_file($p_image_tmp_name, $p_image_folder);
         $message[] = 'Food add succesfully';
      } else {
         $message[] = 'could not add the Food';
      }
   }
   ;

   if (isset($_GET['delete'])) {
      $delete_id = $_GET['delete'];
      $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
      if ($delete_query) {
         header('location:home.php');
         $message[] = 'product has been deleted';
      } else {
         header('location:home.php');
         $message[] = 'product could not be deleted';
      }
      ;
   }
   ;

   if (isset($_POST['update_product'])) {
      $update_p_id = $_POST['update_p_id'];
      $update_p_name = $_POST['update_p_name'];
      $update_p_price = $_POST['update_p_price'];
      $update_p_image = $_FILES['update_p_image']['name'];
      $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
      $update_p_image_folder = 'uploaded_img/' . $update_p_image;

      $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");

      if ($update_query) {
         move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
         $message[] = 'product updated succesfully';
         header('location:home.php');
      } else {
         $message[] = 'product could not be updated';
         header('location:home.php');
      }

   }

   ?>


   <!DOCTYPE html>
   <html>

   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Home</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      <link rel="stylesheet" type="text/css" href="css/admin.css">

   </head>

   <body style="background-image: url(bg/bg2.jpg); background-repeat: repeat-y;">

      <?php
      if (isset($message)) {
         foreach ($message as $message) {
            echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
         }
         ;
      }
      ;
      ?>

      <?php include 'header.php'; ?>

      <div class="container">

         <section>

            <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
               <h3>add a new Foods</h3>
               <input type="text" name="p_name" placeholder="Enter Food Name" class="box" required>
               <input type="number" name="p_price" min="0" placeholder="Enter price" class="box" required>
               <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
               <input type="submit" value="add the Food" name="add_product" class="btn">
            </form>

         </section>

         <section class="display-product-table" style="background-color: antiquewhite" ;>

            <table>

               <thead>
                  <th>Food image</th>
                  <th>Food name</th>
                  <th>Food price</th>
                  <th>action</th>
               </thead>

               <tbody>
                  <?php

                  $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                  if (mysqli_num_rows($select_products) > 0) {
                     while ($row = mysqli_fetch_assoc($select_products)) {
                        ?>

                        <tr>
                           <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                           <td>
                              <?php echo $row['name']; ?>
                           </td>
                           <td>₹
                              <?php echo $row['price']; ?>/- Only
                           </td>
                           <td>
                              <a href="home.php?delete=<?php echo $row['id']; ?>" class="delete-btn"
                                 onclick="return confirm('Are your sure you want to delete this?');"> <i
                                    class="fas fa-trash"></i> delete </a>
                              <a href="home.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i>
                                 update </a>
                           </td>
                        </tr>

                        <?php
                     }
                     ;
                  } else {
                     echo "<div class='empty'>no product added</div>";
                  }
                  ;
                  ?>
               </tbody>
            </table>

         </section>

         <section class="edit-form-container">

            <?php
            if (isset($_GET['edit'])) {
               $edit_id = $_GET['edit'];
               $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
               if (mysqli_num_rows($edit_query) > 0) {
                  while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                     ?>

                     <form action="" method="post" enctype="multipart/form-data">
                        <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
                        <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
                        <input type="number" min="0" class="box" required name="update_p_price"
                           value="<?php echo $fetch_edit['price']; ?>">
                        <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                        <input type="submit" value="update the prodcut" name="update_product" class="btn">
                        <input type="reset" value="cancel" id="close-edit" class="option-btn">
                     </form>

                     <?php
                  }
                  ;
               }
               ;
               echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
            }
            ;
            ?>

         </section>

      </div>






      <!-- custom js file link  -->
      <script src="js/script.js"></script>

   </body>

   </html>


<?php } else {
   header("Location: login.php");
   exit;
} ?>