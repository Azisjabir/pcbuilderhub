<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['reply'])) {
    $message_id = $_POST['message_id'];
    $reply_message = $_POST['reply_message'];

    $insert_reply = $conn->prepare("INSERT INTO `replies` (message_id, admin_id, reply_message) VALUES (?, ?, ?)");
    $insert_reply->execute([$message_id, $admin_id, $reply_message]);

    // Optionally, you can also update the original message table to mark it as replied, if needed.

    header('location:messages.php');
}

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
    $select_message->execute([$message_id]);

    if ($select_message->rowCount() > 0) {
        $fetch_message = $select_message->fetch(PDO::FETCH_ASSOC);
    } else {
        // Handle the case where the message with the given ID is not found.
        header('location:messages.php');
    }
} else {
    // Handle the case where the message ID is not provided.
    header('location:messages.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Message</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <!-- reply section starts  -->
    <section class="reply">
        <h1 class="heading">Reply to Message</h1>

        <div class="box-container">
            <div class="box">
                <p>Name: <span><?= $fetch_message['name']; ?></span></p>
                <p>Number: <span><?= $fetch_message['number']; ?></span></p>
                <p>Email: <span><?= $fetch_message['email']; ?></span></p>
                <p>Message: <span><?= $fetch_message['message']; ?></span></p>
            </div>

            <form method="post" action="reply.php">
                <input type="hidden" name="message_id" value="<?= $message_id; ?>">
                <label for="reply_message">Your Reply:</label>
                <textarea name="reply_message" id="reply_message" rows="4" required></textarea>
                <button type="submit" name="reply">Send Reply</button>
            </form>
        </div>
    </section>
    <!-- reply section ends -->

    <!-- custom js file link  -->
    <script src="../js/admin_script.js"></script>

</body>

</html>
