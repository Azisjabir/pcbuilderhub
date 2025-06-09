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
   <title>Menu</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Shop</h3>
</div>

 <!-- Parts Category Section -->
 <section class="category-product" id="slider-parts">
      <h1 class="title">Parts Category</h1>
      <div class="box-container">
         <a href="category.php?category=motherboard" class="box">
            <img src="images/motherboard.png" alt="Motherboard">
            <h3>Motherboard</h3>
         </a>
         <a href="category.php?category=cpu" class="box">
            <img src="images/cpu.png" alt="CPU">
            <h3>CPU</h3>
         </a>
         <a href="category.php?category=gpu" class="box">
            <img src="images/gpu.png" alt="GPU">
            <h3>GPU</h3>
         </a>
         <a href="category.php?category=ram" class="box">
            <img src="images/ram.png" alt="RAM">
            <h3>RAM</h3>
         </a>
         <a href="category.php?category=power supply" class="box">
            <img src="images/psu.png" alt="Power Supply">
            <h3>Power Supply</h3>
         </a>
         <a href="category.php?category=cooler" class="box">
            <img src="images/cooler.png" alt="Cooler">
            <h3>Cooler</h3>
         </a>
      </div>
   </section>

   <!-- Prebuilt Category Section -->
   <section class="category-product" id="slider-prebuilt">
      <h1 class="title">Prebuilt Category</h1>
      <div class="box-container">
         <a href="category_prebuilt.php?category=basic" class="box">
            <img src="images/basic.png" alt="Basic Prebuilt">
            <h3>Basic</h3>
            <p>Entry-level prebuilt system suitable for everyday tasks.</p>
         </a>
         <a href="category_prebuilt.php?category=intermediate" class="box">
            <img src="images/intermediate.png" alt="Intermediate Prebuilt">
            <h3>Intermediate</h3>
            <p>Balanced prebuilt system for gaming and productivity.</p>
         </a>
         <a href="category_prebuilt.php?category=advanced" class="box">
            <img src="images/advanced.png" alt="Advanced Prebuilt">
            <h3>Advanced</h3>
            <p>High-performance prebuilt system for demanding applications.</p>
         </a>
      </div>
   </section>



<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
      document.addEventListener("DOMContentLoaded", () => {
         const sliders = document.querySelectorAll(".category-product");

         sliders.forEach((slider) => {
            const container = slider.querySelector(".box-container");
            const prevButton = document.createElement("button");
            const nextButton = document.createElement("button");

            // Create buttons
            prevButton.className = "prev";
            prevButton.textContent = "❮";
            nextButton.className = "next";
            nextButton.textContent = "❯";

            // Add buttons to slider
            const controls = document.createElement("div");
            controls.className = "slider-controls";
            controls.appendChild(prevButton);
            controls.appendChild(nextButton);
            slider.appendChild(controls);

            let scrollAmount = 0;

            prevButton.addEventListener("click", () => {
               scrollAmount -= container.clientWidth;
               container.scroll({
                  left: scrollAmount,
                  behavior: "smooth",
               });
            });

            nextButton.addEventListener("click", () => {
               scrollAmount += container.clientWidth;
               container.scroll({
                  left: scrollAmount,
                  behavior: "smooth",
               });
            });

            // Ensure only 3 items are visible
            const boxes = container.querySelectorAll(".box");
            boxes.forEach((box) => {
               box.style.flex = `0 0 calc((100% / 3) - 10px)`; // 3 boxes in view
            });
         });
      });
   </script>

</body>
   <?php include 'components/footer.php'; ?>
</html>
