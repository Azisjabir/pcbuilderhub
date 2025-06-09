<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick View</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view">

   <h1 class="title">Quick View</h1>

   <?php
      $pid = $_GET['pid'];

      // Check products table
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);

      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex">
         <div class="price"><span>RM<?= $fetch_products['price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
      </div>
      <button type="submit" name="add_to_cart" class="cart-btn">Add to cart</button>
   </form>
   <?php
         }
      } else {
         // Check prebuilt table
         $select_prebuilt = $conn->prepare("SELECT * FROM `prebuilt` WHERE id = ?");
         $select_prebuilt->execute([$pid]);

         if($select_prebuilt->rowCount() > 0){
            while($fetch_prebuilt = $select_prebuilt->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_prebuilt['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_prebuilt['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_prebuilt['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_prebuilt['image']; ?>">
      <img src="uploaded_img/<?= $fetch_prebuilt['image']; ?>" alt="">
      <a href="category_prebuilt.php?category=<?= $fetch_prebuilt['category']; ?>" class="cat"><?= $fetch_prebuilt['category']; ?></a>
      <div class="name"><?= $fetch_prebuilt['name']; ?></div>
      <div class="flex">
         <div class="price"><span>RM<?= $fetch_prebuilt['price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
      </div>
      <div class="flex">
         <div class="detail"><?= $fetch_prebuilt['detail']; ?></div>
         </div>
         <button type="submit" name="add_to_cart" class="cart-btn">Add to cart</button>
   </form>

   <?php
            }
         } else {
            echo '<p class="empty">No products found!</p>';
         }
      }
   ?>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
