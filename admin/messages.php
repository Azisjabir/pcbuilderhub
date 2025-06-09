<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

// Delete message
if (isset($_GET['delete_message'])) {
    $delete_id = $_GET['delete_message'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messages.php');
}

// Add FAQ
if (isset($_POST['add_faq'])) {
    $question = htmlspecialchars($_POST['question']);
    $answer = htmlspecialchars($_POST['answer']);

    $add_faq = $conn->prepare("INSERT INTO `faqs` (question, answer) VALUES (?, ?)");
    $add_faq->execute([$question, $answer]);
    header('location:messages.php');
}

// Delete FAQ
if (isset($_GET['delete_faq'])) {
    $delete_id = $_GET['delete_faq'];
    $delete_faq = $conn->prepare("DELETE FROM `faqs` WHERE id = ?");
    $delete_faq->execute([$delete_id]);
    header('location:messages.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages & FAQs</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

    <?php include '../components/admin_header.php' ?>

    <!-- messages section starts  -->
    <section>
        <div class="products-table section-spacing">
            <h1>Messages</h1>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_messages = $conn->prepare("SELECT * FROM `messages`");
                    $select_messages->execute();
                    if ($select_messages->rowCount() > 0) {
                        while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $fetch_messages['name']; ?></td>
                            <td><?= $fetch_messages['message']; ?></td>
                            <td>
                                <a href="reply.php?id=<?= $fetch_messages['id']; ?>" class="option-btn">Reply</a>
                                <a href="messages.php?delete_message=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Delete this message?');">Delete</a>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="3" class="empty">You have no messages</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- messages section ends -->

    <!-- FAQs section starts  -->
    <section>
        <div class="faq-container section-spacing">
            <h1>Manage FAQs</h1>

            <!-- Add FAQ Form -->
            <form action="" method="post" class="faq-form">
                <input type="text" name="question" placeholder="Enter FAQ question" required>
                <textarea name="answer" placeholder="Enter FAQ answer" required></textarea>
                <button type="submit" name="add_faq" class="option-btn">Add FAQ</button>
            </form>

            <!-- Display FAQs -->
            <div class="products-table">
                <table>
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $select_faqs = $conn->prepare("SELECT * FROM `faqs`");
                        $select_faqs->execute();
                        if ($select_faqs->rowCount() > 0) {
                            while ($fetch_faqs = $select_faqs->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <tr>
                                <td><?= $fetch_faqs['question']; ?></td>
                                <td><?= $fetch_faqs['answer']; ?></td>
                                <td>
                                    <a href="messages.php?delete_faq=<?= $fetch_faqs['id']; ?>" class="delete-btn" onclick="return confirm('Delete this FAQ?');">Delete</a>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="3" class="empty">No FAQs added yet</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- FAQs section ends -->

    <!-- custom js file link  -->
    <script src="../js/admin_script.js"></script>

</body>

</html>
