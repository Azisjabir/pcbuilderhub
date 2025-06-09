<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['add_product'])) {

    $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : null;
    $price = isset($_POST['price']) ? filter_var($_POST['price'], FILTER_SANITIZE_STRING) : '0'; // Default to '0'
    $category = isset($_POST['category']) ? filter_var($_POST['category'], FILTER_SANITIZE_STRING) : null;
    $quantity = isset($_POST['quantity']) ? filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT) : 0; // Default to 0

    $image = isset($_FILES['image']['name']) ? filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING) : null;
    $image_size = isset($_FILES['image']['size']) ? $_FILES['image']['size'] : 0;
    $image_tmp_name = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : null;
    $image_folder = $image ? '../uploaded_img/' . $image : '../uploaded_img/default.jpg';

    if ($name && $category) {
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
        $select_products->execute([$name]);

        if ($select_products->rowCount() > 0) {
            $message[] = 'Product name already exists!';
        } else {
            if ($image) {
                if ($image_size > 2000000) {
                    $message[] = 'Image size is too large';
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
            }

            $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image, quantity) VALUES(?,?,?,?,?)");
            $insert_product->execute([$name, $category, $price, $image_folder, $quantity]);

            $message[] = 'New product added!';
        }
    } else {
        $message[] = 'Please provide all required fields!';
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    header('location:products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Products</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<!-- Add Products Section Starts -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Product</h3>
      
      <select name="category" class="box" required id="categorySelect" onchange="updateProducts()">
         <option value="" disabled selected>Select category --</option>
         <?php
            $fetch_categories = $conn->prepare("SELECT DISTINCT category FROM `build_components`");
            $fetch_categories->execute();
            if ($fetch_categories->rowCount() > 0) {
               while ($category = $fetch_categories->fetch(PDO::FETCH_ASSOC)) {
                  echo '<option value="' . htmlspecialchars($category['category']) . '">' . htmlspecialchars($category['category']) . '</option>';
               }
            } else {
               echo '<option value="">No categories available</option>';
            }
         ?>
      </select>

      <select name="name" class="box" required id="productSelect" onchange="updatePrice()">
         <option value="" disabled selected>Select component --</option>
      </select>

      <input type="text" id="productPrice" class="box" readonly placeholder="Product Price">
      <input type="hidden" name="price" id="hiddenPrice">

      <input type="number" name="quantity" class="box" required placeholder="Enter quantity" min="0">

      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>

      <input type="submit" value="Add Product" name="add_product" class="btn">
   </form>

</section>

<!-- Add Products Section Ends -->

<!-- Show Products Section Starts -->

<section class="products-table" style="padding-top: 0;">
   <table>
      <thead>
         <tr>
            <th>ID</th> <!-- This column shows product IDs -->
            <th>Image</th> <!-- Product images -->
            <th>Name</th> <!-- Product names -->
            <th>Category</th> <!-- Product categories -->
            <th>Price</th> <!-- Product prices -->
            <th>Quantity</th> <!-- Product quantities -->
            <th>Actions</th> <!-- Update and Delete buttons -->
         </tr>
      </thead>
      <tbody>
         <?php
         $show_products = $conn->prepare("SELECT * FROM `products`");
         $show_products->execute();
         if ($show_products->rowCount() > 0) {
            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
               echo "<tr>";

               // Display product ID
               echo "<td>" . $fetch_products['id'] . "</td>";

               // Display product image
               echo "<td><img src='../uploaded_img/" . $fetch_products['image'] . "' alt='' style='width: 50px; height: auto;'></td>";

               // Display product name
               echo "<td>" . $fetch_products['name'] . "</td>";

               // Display product category
               echo "<td>" . $fetch_products['category'] . "</td>";

               // Display product price
               echo "<td>RM" . number_format($fetch_products['price'], 2) . "</td>";

               // Display product quantity
               echo "<td>" . $fetch_products['quantity'] . "</td>";

               // Display action buttons
               echo "<td>";
               echo "<a href='update_product.php?update=" . $fetch_products['id'] . "' class='option-btn'>Update</a> ";
               echo "<a href='products.php?delete=" . $fetch_products['id'] . "' class='delete-btn' onclick=\"return confirm('Delete this product?');\">Delete</a>";
               echo "</td>";

               echo "</tr>";
            }
         } else {
            echo '<tr><td colspan="7" class="empty">No products added yet!</td></tr>';
         }
         ?>
      </tbody>
   </table>
</section>


<!-- Show Products Section Ends -->

<script>
function updateProducts() {
    const categorySelect = document.getElementById('categorySelect');
    const productSelect = document.getElementById('productSelect');
    const selectedCategory = categorySelect.value;

    // Clear current options
    productSelect.innerHTML = '<option value="" disabled selected>Select component --</option>';
    document.getElementById('productPrice').value = ''; // Clear price field

    if (selectedCategory) {
        // Fetch products for selected category using AJAX
        fetch(`get_products.php?category=${encodeURIComponent(selectedCategory)}`)
            .then(response => response.json())
            .then(products => {
                products.forEach(product => {
                    const option = document.createElement('option');
                    option.value = product.name;
                    option.textContent = product.name;
                    option.dataset.price = product.price; // Store price in data attribute
                    productSelect.appendChild(option);
                });
            });
    }
}

function updatePrice() {
    const productSelect = document.getElementById('productSelect');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const priceField = document.getElementById('productPrice');
    const hiddenPriceField = document.getElementById('hiddenPrice'); // Reference to hidden field

    if (selectedOption) {
        const price = selectedOption.dataset.price || '0'; // Default to '0' if no price
        priceField.value = price; // Display price in read-only field
        hiddenPriceField.value = price; // Set price in hidden field for form submission
    } else {
        priceField.value = ''; // Clear display field
        hiddenPriceField.value = ''; // Clear hidden field
    }
}
</script>

</body>
</html>
