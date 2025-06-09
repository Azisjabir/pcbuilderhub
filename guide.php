<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

// Fetch categories
$categories = $conn->query("SELECT * FROM learn_categories")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Learn To Build Your PC</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- build your PC section starts -->
<div class="heading">
   <h3>Learn To Build Your PC</h3>
   
</div>

<section class="category">
   <div class="container">
      <div class="content">
         <h1 class="title">Build AMD System</h1>
         <p class="subtitle">A computer system that uses products from Advanced Micro Devices (AMD)</p>
         <a href="amd.php" class="btn">Learn How</a>
      </div>
      <div class="image">
         <img src="images/amdlogo.png">
      </div>
   </div>
</section>

<section class="category">
   <div class="container">
      <div class="content">
         <h1 class="title">Build INTEL System</h1>
         <p class="subtitle">A computer that uses an Intel microprocessor, such as a Core, Xeon, or Pentium chip.</p>
         <a href="intel.php" class="btn">Learn How</a>
      </div>
      <div class="image">
         <img src="images/INTEL.png">
      </div>
   </div>
</section>

</body>
   <?php include 'components/footer.php'; ?>
</html>
<script src="js/script.js"></script>