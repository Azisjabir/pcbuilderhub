<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

include 'components/add_cart.php';

// Handle review form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'name' key exists in the POST array
    if (isset($_POST['name'])) {
        $name = htmlspecialchars($_POST['name']);
    } else {
        $name = ''; // Set a default value or handle the error as needed
    }
    
    $rating = (int)$_POST['rating'];
    $review = htmlspecialchars($_POST['review']);

    $sql = "INSERT INTO reviews (name, rating, review) VALUES (:name, :rating, :review)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':review', $review);

    if ($stmt->execute()) {
        echo "<script>alert('Thank you for your review!');</script>";
    } else {
        echo "<script>alert('Error: Could not submit your review.');</script>";
    }
}

// Retrieve all reviews
$sql = "SELECT name, rating, review FROM reviews ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PCBUILDERHUB</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="showcase">
   <div class="video-container">
      <video autoplay muted loop>
         <source src="images/pcvideo.mp4" type="video/mp4">
         Your browser does not support the video tag.
      </video>
      <div class="overlay-content">
         <h1>Welcome to PC Builder Hub</h1>
         <p>Your one-stop destination for custom PC building. We offer component selection, build guides, and expert advice to help you create your perfect computer.</p>
      </div>
   </div>
</div>

<br><br><br>

<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">
          
         <div class="swiper-slide slide">
            <div class="content">
               <h3 style="color:var(--white);">build your own pc</h3>
               <h3 style="color:var(--white); font-size: 1.8rem;">Easy way to choose components with their compatibility!</h3>
                <a href="build.php" class="btn">Build Now</a>
            </div>
            <div class="image">
               <img src="images/build.png" alt="">
            </div>
         </div>
          
         <div class="swiper-slide slide">
            <div class="content">
               <h3 style="color:var(--white);">Learn How To Build Your PC</h3>
               <h3 style="color:var(--white); font-size: 1.8rem;">Clear explanation, perfect guides, and test your knowledge!</h3>
               <a href="guide.php" class="btn">Learn How</a>
            </div>
            <div class="image">
               <img src="images/learn.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <h3 style="color:var(--white);">Buy Your Component Now</h3>
               <h3 style="color:var(--white); font-size: 1.8rem;">Components, Prebuilt choices, Checkout now!</h3>
               <a href="menu.php" class="btn">Buy Now</a>
            </div>
            <div class="image">
               <img src="images/motherboard.png" alt="">
            </div>
         </div>



      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="reviews">
   <div class="container">
      <h1>Leave a Review</h1>
      <form method="POST" action="">
         <label>Your rating</label>
         <div class="stars" id="star-rating">
            <i class="fas fa-star" data-rating="1"></i>
            <i class="fas fa-star" data-rating="2"></i>
            <i class="fas fa-star" data-rating="3"></i>
            <i class="fas fa-star" data-rating="4"></i>
            <i class="fas fa-star" data-rating="5"></i>
         </div>
         <input type="hidden" id="rating" name="rating" value="0">

         <label for="name">Your name</label>
         <input type="text" id="name" name="name" placeholder="Enter your name" required>

         <label for="review">Your review</label>
         <textarea id="review" name="review" placeholder="Write your review here..." required></textarea>

         <button type="submit">Submit</button>
      </form>
   </div>
</section>

<section class="display-reviews">
   <div class="container">
      <h1>Reviews</h1>
      <div class="swiper review-slider">
         <div class="swiper-wrapper">
            <?php if (count($reviews) > 0): ?>
               <?php foreach ($reviews as $review): ?>
                  <div class="swiper-slide review-card">
                     <div class="icon">
                        <i class="fas fa-user-circle"></i>
                     </div>
                     <strong><?php echo htmlspecialchars($review['name']); ?></strong>
                     <div class="rating">
                        <?php for ($i = 0; $i < (int)$review['rating']; $i++): ?>
                           <i class="fas fa-star"></i>
                        <?php endfor; ?>
                        <?php for ($i = (int)$review['rating']; $i < 5; $i++): ?>
                           <i class="far fa-star"></i>
                        <?php endfor; ?>
                     </div>
                     <em><?php echo htmlspecialchars($review['review']); ?></em>
                  </div>
               <?php endforeach; ?>
            <?php else: ?>
               <p>No reviews yet. Be the first to submit one!</p>
            <?php endif; ?>
         </div>
         <div class="swiper-pagination"></div>
      </div>
   </div>
</section>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
var swiper = new Swiper(".hero-slider", {
   loop: true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
});

var reviewSwiper = new Swiper(".review-slider", {
   loop: true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   breakpoints: {
      640: {
         slidesPerView: 1,
      },
      768: {
         slidesPerView: 2,
      },
      1024: {
         slidesPerView: 3,
      },
   },
});
</script>

<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	
</script>

<script>
    const stars = document.querySelectorAll('#star-rating i');
    const ratingInput = document.getElementById('rating');

    stars.forEach((star, index) => {
        // Add hover effect
        star.addEventListener('mouseover', () => {
            resetStars();
            highlightStars(index);
        });

        // Remove hover effect
        star.addEventListener('mouseout', resetStars);

        // Set rating on click
        star.addEventListener('click', () => {
            resetStars();
            highlightStars(index, true);
            ratingInput.value = index + 1; // Set the selected rating
        });
    });

    function highlightStars(index, active = false) {
        for (let i = 0; i <= index; i++) {
            stars[i].classList.add(active ? 'active' : 'hovered');
        }
    }

    function resetStars() {
        stars.forEach(star => {
            star.classList.remove('hovered', 'active');
        });

        // Keep the selected rating highlighted
        const selectedRating = ratingInput.value;
        if (selectedRating > 0) {
            for (let i = 0; i < selectedRating; i++) {
                stars[i].classList.add('active');
            }
        }
    }
</script>

</body>
   <?php include 'components/footer.php'; ?>
</html>
