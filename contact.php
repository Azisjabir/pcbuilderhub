<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: login.php'); // Redirect to login page if not logged in
    exit();
}

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'Already sent message!';
    } else {
        $insert_message = $conn->prepare("INSERT INTO `messages` (user_id, name, email, number, message) VALUES (?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'Sent message successfully!';
    }
}

// Fetch only user's messages with replies
$select_messages = $conn->prepare("SELECT messages.*, replies.reply_message FROM `messages` LEFT JOIN replies ON messages.id = replies.message_id WHERE messages.user_id = ?");
$select_messages->execute([$user_id]);
$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);

// Fetch FAQs from the database
$select_faqs = $conn->prepare("SELECT * FROM `faqs`");
$select_faqs->execute();
$faqs = $select_faqs->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'components/user_header.php'; ?>

    <div class="heading">
        <h3>Contact Us</h3>
        <p><a href="home.php">Home</a> <span>/ Contact</span></p>
    </div>

    <!-- contact section starts  -->
    <section class="contact">
        <div class="row">
            <form action="" method="post">
                <h3>Message Us</h3>
                <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
                <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="10">
                <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
                <textarea name="msg" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
                <input type="submit" value="Send Message" name="send" class="btn">
            </form>
        </div>
    </section>
    <!-- contact section ends -->

    <!-- Display user's messages with replies -->
    <div class="message-table">
        <table class="message-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Admin Reply</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($messages as $message) {
                    echo '<tr>';
                    echo '<td>' . $message['name'] . '</td>';
                    echo '<td>' . $message['number'] . '</td>';
                    echo '<td>' . $message['email'] . '</td>';
                    echo '<td>' . $message['message'] . '</td>';
                    echo '<td class="admin-reply">' . (!empty($message['reply_message']) ? $message['reply_message'] : '-') . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Display FAQs -->
    <div class="faq-section">
    <h3>Frequently Asked Questions</h3>
    <div class="faq-container">
        <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <div class="faq-question">
                    <?= $faq['question']; ?>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="faq-answer">
                    <?= $faq['answer']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


    <?php include 'components/footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', () => {
                item.classList.toggle('open'); // Toggle open class

                // Close other open items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('open');
                    }
                });
            });
        });
    });
</script>

</body>

</html>
