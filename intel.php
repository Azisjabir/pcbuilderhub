<?php
include 'components/connect.php';
session_start();

// Initialize user_id
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch guide content for Intel category
$stmt = $conn->prepare("SELECT article_url, video_url, quiz_url FROM lessons WHERE category_id = (SELECT id FROM learn_categories WHERE name = 'INTEL Build')");
$stmt->execute();
$content = $stmt->fetch(PDO::FETCH_ASSOC);

// Assign variables
$article_url = $content['article_url'] ?? null;
$video_url = $content['video_url'] ?? null;
$quiz_url = $content['quiz_url'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Learn to Build Your Intel PC</title>
   <link rel="stylesheet" href="css/style.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include 'components/user_header.php'; // Include the user header ?>

<div class="heading">
   <h3>Learn to Build Your Intel PC</h3>
</div>

<!-- Articles Section -->
<section class="articles">
   <?php if ($article_url): ?>
      <div class="box">
         <h2>WHAT YOU NEED TO KNOW AS A BEGINNER</h2>
         <a href="<?= htmlspecialchars($article_url) ?>" target="_blank" class="btn">Read Article</a>
      </div>
   <?php endif; ?>
</section>

<!-- Videos Section -->
<section class="videos">
   <?php if ($video_url): ?>
      <div class="box">
         <h2>STEP BY STEP TUTORIAL</h2>
         <div class="video">
            <iframe src="<?= htmlspecialchars($video_url) ?>" frameborder="0" allowfullscreen></iframe>
         </div>
      </div>
   <?php endif; ?>
</section>

<!-- Add Quiz Section -->
<section class="quiz">
   <?php if ($quiz_url): ?>
      <div class="box">
      <h2>TEST YOUR KNOWLEDGE WITH A QUIZ</h2>
      <a href="<?= htmlspecialchars($quiz_url) ?>" target="_blank" class="btn">Attempt Quiz</a>
   <?php endif; ?>
</section>

<?php include 'components/footer.php'; // Include the footer ?>

</body>
</html>
