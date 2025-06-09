<?php

include '../components/connect.php';

session_start();

// Check if the admin is logged in (example)
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $article_url = $_POST['article_url'];
    $video_url = $_POST['video_url'];
    $quiz_url = $_POST['quiz_url'];

    $article_url = filter_var($article_url, FILTER_SANITIZE_URL);
    $video_url = filter_var($video_url, FILTER_SANITIZE_URL);
    $quiz_url = filter_var($quiz_url, FILTER_SANITIZE_URL);

    // Insert content into the database
    $stmt = $conn->prepare("INSERT INTO lessons (category_id, article_url, video_url, quiz_url) VALUES (?, ?, ?, ?)");
    $stmt->execute([$category_id, $article_url, $video_url, $quiz_url]);

    $message = "Guide content added successfully.";
}

// Fetch categories
$categories = [];
try {
    $stmt = $conn->query("SELECT * FROM learn_categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Failed to fetch categories: " . $e->getMessage();
}

// Fetch uploaded lessons
$lessons = [];
try {
    $stmt = $conn->query("SELECT * FROM lessons");
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Failed to fetch lessons: " . $e->getMessage();
}

// Handle delete request
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM lessons WHERE id = ?");
    $stmt->execute([$delete_id]);
    $message = "Lesson deleted successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Guide Content</title>
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_header.php'; ?>

<div class="lessons-container">
    <form action="" method="POST">
        <h3>Add Guide Content</h3>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        
        <label for="category_id">Select Category</label>
        <select name="category_id" id="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= htmlspecialchars($category['id']) ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="article_url">Article URL</label>
        <input 
            type="url" 
            id="article_url" 
            name="article_url" 
            placeholder="Enter the article URL" 
            required>
        
        <label for="video_url">Video URL</label>
        <input 
            type="url" 
            id="video_url" 
            name="video_url" 
            placeholder="Enter the video URL" 
            required>
        
        <label for="quiz_url">Quiz URL</label>
        <input 
            type="url" 
            id="quiz_url" 
            name="quiz_url" 
            placeholder="Enter the quiz URL" 
            required>
        
        <input type="submit" value="Add Content" class="btn">
    </form>
</div>


<!-- Display uploaded lessons -->
<section class="products-table" style="padding-top: 0;">
    <div class="Products-table">
        <h3>Uploaded Lessons</h3>
        <?php if (count($lessons) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Article</th> <!-- Article URLs -->
                        <th>Video</th> <!-- Video URLs -->
                        <th>Quiz</th> <!-- Quiz URLs -->
                        <th>Actions</th> <!-- Delete button -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><?= htmlspecialchars($lesson['article_url']) ?></td>
                            <td><?= htmlspecialchars($lesson['video_url']) ?></td>
                            <td><?= htmlspecialchars($lesson['quiz_url']) ?></td>
                            <td>
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= htmlspecialchars($lesson['id']) ?>">
                                    <input type="submit" value="Delete" class="btn-delete">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No lessons uploaded yet.</p>
        <?php endif; ?>
    </div>
</section>
</body>
</html>
