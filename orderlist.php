<?php
@include 'config.php';
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Products</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">



</head>
<body style="background-image: url(bg/bg1.jpg); background-repeat: repeat-y;">

<?php include 'header.php'; ?>


<section class="display-product-table" >

   <table style="background-color: beige"; >

      <thead>
	  <th>Order No</th>
		 <th>Cust. name</th>
         <th>phone no.</th>
         <th>table no.</th>
         <th>Orders</th>
		 <th>method</th>
		 <th>price</th>
		 <th>status</th>
      </thead>

      <tbody>
	  <?php
         
		 $select_products = mysqli_query($conn, "SELECT * FROM `order` WHERE status='0' OR status='1' ORDER BY id DESC");
		 
		 if(mysqli_num_rows($select_products) > 0){
			while($row = mysqli_fetch_assoc($select_products)){
	  ?>

	  <tr>
	  <td><?php echo $row['id']; ?></td>
	  <td><?php echo $row['name']; ?></td>
	  <td><?php echo $row['number']; ?></td>
	  <td><?php echo $row['table']; ?></td>
	  <td><?php echo $row['total_products']; ?></td>
	  <td><?php echo $row['method']; ?></td>
	  <td><?php echo $row['total_price']; ?></td>
	  <td>
	  <?php 
		if($row['status']==0)
		{
			echo '<a href="active.php?id=', $row['id'].'&status=1" class="btn1 btn-success" >Deliverd</a>';
	  	}
		
		elseif($row['status']==1)
		{
			  echo '<a onclick="return confirm(\'Are you sure customer paid there payment ? \')" href="active.php?id=', $row['id'] . '&status=2" class="btn2 btn-danger" >order_Done</a>';
			}
			
		
		?>
		
	</td>
	  

	  </tr>


		<?php
            };    
            }else{
               echo "<div class='empty'>Zero Order Panding</div>";
            };
         ?>

        

         
      </tbody>
   </table>

</section>











<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>