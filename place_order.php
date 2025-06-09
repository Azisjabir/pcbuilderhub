<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}

// Process the order (you can copy the order processing logic from checkout.php)
$check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$check_cart->execute([$user_id]);

if($check_cart->rowCount() > 0){
    // Get user details
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

    // Calculate total products and price
    $cart_items = [];
    $grand_total = 0;
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $select_cart->execute([$user_id]);
    
    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
        $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
    }
    
    $total_products = implode($cart_items);

    // Insert order
    $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
    $insert_order->execute([$user_id, $fetch_profile['name'], $fetch_profile['number'], $fetch_profile['email'], 'Online Banking', $fetch_profile['address'], $total_products, $grand_total]);

    // Clear cart
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Placed</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
      .success-message {
         text-align: center;
         padding: 50px 20px;
         max-width: 600px;
         margin: 20px auto;
         background: #fff;
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
      .success-message i {
         font-size: 5rem;
         color: #4CAF50;
         margin-bottom: 20px;
      }
   </style>
</head>
<body>
   <?php include 'components/user_header.php'; ?>

   <div class="heading">
      <h3>Order Confirmation</h3>
      <p><a href="home.php">Home</a> <span> / Order Placed</span></p>
   </div>

   <section class="success-message">
      <i class="fas fa-check-circle"></i>
      <h2>Order Placed Successfully!</h2>
      <p>Thank you for your purchase. Your order has been successfully placed.</p>
      <div style="margin-top: 20px;">
         <a href="orders.php" class="btn">View Orders</a>
         <a href="home.php" class="btn">Continue Shopping</a>
      </div>
   </section>

   <?php include 'components/footer.php'; ?>
</body>
</html> 