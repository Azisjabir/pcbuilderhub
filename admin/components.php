<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['add_component'])) {

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $select_components = $conn->prepare("SELECT * FROM `build_components` WHERE name = ?");
    $select_components->execute([$name]);

    if ($select_components->rowCount() > 0) {
        $message[] = 'Component name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_component = $conn->prepare("INSERT INTO `build_components`(name, category, details, price, image) VALUES(?,?,?,?,?)");
            $insert_component->execute([$name, $category, $details, $price, $image]);
            
            // If the category is motherboard, process compatibility
            if ($category === 'motherboard') {
                $compatibility_data = $_POST['compatibility'] ?? [];
                $motherboard_id = $conn->lastInsertId(); // ID of the newly added motherboard

                foreach ($compatibility_data as $comp_category => $comp_ids) {
                    foreach ($comp_ids as $comp_id) {
                        $insert_compatibility = $conn->prepare("INSERT INTO `compatible` (motherboard_id, component_id, category) VALUES (?, ?, ?)");
                        $insert_compatibility->execute([$motherboard_id, $comp_id, $comp_category]);
                    }
                }
            }

            $message[] = 'New component added!';
        }
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_component_image = $conn->prepare("SELECT * FROM `build_components` WHERE id = ?");
    $delete_component_image->execute([$delete_id]);
    $fetch_delete_image = $delete_component_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    $delete_component = $conn->prepare("DELETE FROM `build_components` WHERE id = ?");
    $delete_component->execute([$delete_id]);
    header('location:components.php');
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

<?php include '../components/admin_header.php' ?>

<!-- Add Products Section Starts -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Component</h3>
      
      <select name="category" class="box" id="category" required onchange="toggleCompatibilityBox(this.value)">
         <option value="" disabled selected>Select category --</option>
         <option value="motherboard">Motherboard</option>
         <option value="cpu">CPU</option>
         <option value="gpu">GPU</option>
         <option value="ram">RAM</option>
         <option value="power supply">Power Supply</option>
         <option value="cooler">Cooler</option>
         <option value="storage">Storage</option>
         <option value="case">Case</option>
      </select>
      <input type="text" required placeholder="Enter component name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Enter component price" name="price" class="box">
      <textarea name="details" class="box" required placeholder="Enter component details" cols="30" rows="10"></textarea>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <!-- Compatibility section -->
      <div id="compatibility-box" style="display: none;">
         <h4>Select Compatible Components:</h4>
         <div class="compatibility-group">
            <?php
            $categories = ['cpu', 'gpu', 'ram', 'power supply', 'cooler', 'case'];
            foreach ($categories as $comp_category) {
                  $components = $conn->prepare("SELECT * FROM `build_components` WHERE category = ?");
                  $components->execute([$comp_category]);

                  echo "<div class='category-box'>";
                  echo "<label><strong>$comp_category</strong></label>";
                  echo "<select name=\"compatibility[$comp_category][]\" class=\"box\" multiple>";
                  echo "<option value=\"\" disabled>Select components</option>";
                  while ($component = $components->fetch(PDO::FETCH_ASSOC)) {
                     echo "<option value=\"{$component['id']}\">{$component['name']}</option>";
                  }
                  echo "</select>";
                  echo "</div>";
            }
            ?>
         </div>
      </div>

      <input type="submit" value="Add Component" name="add_component" class="btn">
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
            <th>Actions</th> <!-- Update and Delete buttons -->
         </tr>
      </thead>
      <tbody>
         <?php
         $show_products = $conn->prepare("SELECT * FROM `build_components`");
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

               // Display action buttons
               echo "<td>";
               echo "<a href='update_component.php?update=" . $fetch_products['id'] . "' class='option-btn'>Update</a> ";
               echo "<a href='components.php?delete=" . $fetch_products['id'] . "' class='delete-btn' onclick=\"return confirm('Delete this product?');\">Delete</a>";
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

</body>
</html>

<script>
function toggleCompatibilityBox(category) {
    const compatibilityBox = document.getElementById('compatibility-box');
    compatibilityBox.style.display = category === 'motherboard' ? 'block' : 'none';
}
</script>
