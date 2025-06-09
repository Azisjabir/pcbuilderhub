<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
    exit;
}

// Fetch user details
$user_query = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$user_query->execute([$user_id]);
$user = $user_query->fetch(PDO::FETCH_ASSOC);
$name = $user['name'] ?? '';
$number = $user['number'] ?? '';
$email = $user['email'] ?? '';
$address = $user['address'] ?? '';

// Fetch order details
$grand_total = 0;
$cart_items = [];

$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);
if ($select_cart->rowCount() > 0) {
    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
        $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ')';
        $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
    }
} else {
    echo '<script>alert("Your cart is empty! Please add items to proceed.");</script>';
    header('location:cart.php');
    exit;
}

$cart_items_str = implode(', ', $cart_items);

// Handle receipt upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
        $receipt_tmp_name = $_FILES['receipt']['tmp_name'];
        $receipt_name = time() . '_' . $_FILES['receipt']['name']; // Unique file name
        $receipt_destination = 'uploads/' . $receipt_name;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($receipt_tmp_name, $receipt_destination)) {
            // Insert order into the database
            $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status, receipt_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([
                $user_id,
                $name,
                $number,
                $email,
                'QR Payment',
                $address,
                $cart_items_str,
                $grand_total,
                date('Y-m-d H:i:s'),
                'Pending',
                $receipt_name
            ]);

            // Clear the cart after successful order
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            echo '<script>alert("Order placed successfully!");</script>';
            echo '<script>window.location.href = "orders.php";</script>';
            exit;
        } else {
            echo '<script>alert("Failed to upload receipt. Please try again.");</script>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header Section -->
<?php include 'components/user_header.php'; ?>
<!-- Header Section Ends -->

<div class="heading">
    <h3>QR Payment</h3>
    <p><a href="home.php">Home</a> <span> / QR Payment</span></p>
</div>

<section class="qr-payment">
    <h1 class="title">Complete Your Payment</h1>

    <div class="order-summary">
        <h3>Order Details</h3>
        <p><strong>Items:</strong> <?= $cart_items_str; ?></p>
        <p><strong>Total Amount:</strong> RM<?= number_format($grand_total, 2); ?></p>
    </div>

    <div class="qr-code">
        <h3>Scan to Pay</h3>
        <img src="images/qr-code.jpg" alt="QR Code">
    </div>

    <p class="note">Please scan the QR code above using your mobile banking app to complete the payment.</p>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="receipt">Upload Receipt:</label>
        <input type="file" name="receipt" id="receipt" accept="image/*,application/pdf" required>
        <div class="btn-container">
            <button type="submit" class="btn">Upload Receipt</button>
            <a href="checkout.php" class="btn">Back to Checkout</a>
        </div>
    </form>

</section>

<!-- Footer Section -->
<?php include 'components/footer.php'; ?>
<!-- Footer Section Ends -->

<script src="js/script.js"></script>
</body>
</html>
