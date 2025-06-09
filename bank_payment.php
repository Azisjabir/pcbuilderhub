<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
}

$bank = isset($_GET['bank']) ? $_GET['bank'] : '';
$bank_names = [
    'maybank' => 'Maybank2u',
    'cimb' => 'CIMB Clicks',
    'public' => 'Public Bank',
    'rhb' => 'RHB Now'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?= $bank_names[$bank] ?? 'Bank' ?> Payment</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
      .bank-login {
         max-width: 500px;
         margin: 20px auto;
         padding: 20px;
         background: #fff;
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
      .bank-login form {
         display: flex;
         flex-direction: column;
         gap: 15px;
      }
      .bank-login .input-group {
         display: flex;
         flex-direction: column;
      }
      .bank-login label {
         margin-bottom: 5px;
         font-weight: bold;
      }
      .bank-login input {
         padding: 10px;
         border: 1px solid #ddd;
         border-radius: 4px;
      }
      .bank-login .bank-logo {
         text-align: center;
         margin-bottom: 20px;
      }
      .bank-login .bank-logo img {
         max-width: 200px;
         height: auto;
      }
   </style>
</head>
<body>
   <?php include 'components/user_header.php'; ?>

   <div class="heading">
      <h3><?= $bank_names[$bank] ?? 'Bank' ?> Payment</h3>
      <p><a href="checkout.php">Checkout</a> <span> / Bank Payment</span></p>
   </div>

   <section class="bank-login">
      <div class="bank-logo">
         <img src="images/<?= $bank ?>-logo.png" alt="<?= $bank_names[$bank] ?> Logo">
      </div>
      
      <form id="bankLoginForm" onsubmit="return processPayment(event)">
         <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
         </div>

         <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
         </div>

         <button type="submit" class="btn" style="background:var(--red); color:var(--white);">Proceed Payment</button>
         <a href="checkout.php" class="btn">Back to Checkout</a>
      </form>
   </section>

   <?php include 'components/footer.php'; ?>

   <script>
   function processPayment(event) {
      event.preventDefault();
      
      // Simulate loading
      const btn = event.target.querySelector('button');
      btn.textContent = 'Processing...';
      btn.disabled = true;

      // Simulate payment processing
      setTimeout(() => {
         alert('Payment processed successfully!');
         // Redirect to success page or process the order
         window.location.href = 'place_order.php';
      }, 2000);

      return false;
   }
   </script>
</body>
   <?php include 'components/footer.php'; ?>
</html> 