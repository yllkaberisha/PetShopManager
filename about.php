<?php
// Define UserReview class
class UserReview {
   // Properties
   protected $name;
   protected $starRating;
   protected $message;

   // Constructor
   public function __construct($name, $starRating, $message) {
       $this->name = $name;
       $this->starRating = $starRating;
       $this->message = $message;
   }

   // Getters
   public function getName() {
       return $this->name;
   }

   public function getStarRating() {
       return $this->starRating;
   }

   public function getMessage() {
       return $this->message;
   }

   // Setters
   public function setName($name) {
       $this->name = $name;
   }

   public function setStarRating($starRating) {
       $this->starRating = $starRating;
   }

   public function setMessage($message) {
       $this->message = $message;
   }

   // Method to display review details
   public function displayReviewDetails() { 
       // Display logic can go here
   }
}

// Define a subclass inheriting from UserReview
class ExtendedUserReview extends UserReview {
   // Additional properties specific to this subclass
   private $extraInfo;

   // Constructor
   public function __construct($name, $starRating, $message, $extraInfo) {
       // Call parent constructor
       parent::__construct($name, $starRating, $message);
       $this->extraInfo = $extraInfo;
   }

   // Getter for extraInfo
   public function getExtraInfo() {
       return $this->extraInfo;
   }

   // Setter for extraInfo
   public function setExtraInfo($extraInfo) {
       $this->extraInfo = $extraInfo;
   }
}

// Function to fetch reviews from API
function fetchReviewsFromAPI($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

// Fetch reviews from JSONPlaceholder API
$apiUrl = "https://jsonplaceholder.typicode.com/posts";
$reviewsData = fetchReviewsFromAPI($apiUrl);

// Simulate review data (since JSONPlaceholder doesn't provide star ratings and names)
$reviews = [];
for ($i = 0; $i < 3; $i++) { // Limit to 3 reviews
    $reviewData = $reviewsData[$i];
    $name = "User " . ($i + 1);
    $starRating = rand(3, 5); // Random star rating between 3 and 5
    $message = $reviewData['body'];
    $reviews[] = new UserReview($name, $starRating, $message);
}

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- Font awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>About Us</h3>
   <p><a href="home.php">Home</a> / About</p>
</div>

<section class="about">
   <div class="flex">
      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>
      <div class="content">
         <h3>Why Choose Us?</h3>
         <p>Lorem ipsum dolor sit amet reiciendis natus fuga, cumque excepturi veniam ratione iure. Excepturi fugiat officia temporibus?</p>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit officia corporis ratione saepe sed adipisci?</p>
         <a href="contact.php" class="btn">Contact Us</a>
      </div>
   </div>
</section>

<section class="reviews">
   <h1 class="title">Client's Reviews</h1>
   <div class="box-container">
      <?php foreach ($reviews as $review): ?>
      <div class="box">
         <img src="images/pic-<?php echo rand(2, 6); ?>.png" alt="">
         <p><?php echo $review->getMessage(); ?></p>
         <div class="stars">
            <?php 
            $starRating = $review->getStarRating();
            for ($i = 1; $i <= 5; $i++) {
                echo $i <= $starRating ? '<i class="fas fa-star"></i>' : '<i class="fas fa-star-half-alt"></i>';
            }
            ?>
         </div>
         <h3><?php echo $review->getName(); ?></h3>
      </div>
      <?php endforeach; ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>
</body>
</html>
