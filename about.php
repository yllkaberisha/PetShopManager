<?php
lass UserReview {
   // Properties
   protected $className;
   protected $starRating;
   protected $message;

   // Constructor
   public function __construct($className, $starRating, $message) {
       $this->className = $className;
       $this->starRating = $starRating;
       $this->message = $message;
   }

   // Getters
   public function getClassName() {
       return $this->className;
   }

   public function getStarRating() {
       return $this->starRating;
   }

   public function getMessage() {
       return $this->message;
   }

   // Setters
   public function setClassName($className) {
       $this->className = $className;
   }

   public function setStarRating($starRating) {
       $this->starRating = $starRating;
   }

   public function setMessage($message) {
       $this->message = $message;
   }

   // Method to display review details
   public function displayReviewDetails() {
       echo "Class Name: " . $this->getClassName() . "\n";
       echo "Star Rating: " . $this->getStarRating() . "\n";
       echo "Message: " . $this->getMessage() . "\n";
   }
}

// Define a subclass inheriting from UserReview
class ExtendedUserReview extends UserReview {
   // Additional properties specific to this subclass
   private $extraInfo;

   // Constructor
   public function __construct($className, $starRating, $message, $extraInfo) {
       // Call parent constructor
       parent::__construct($className, $starRating, $message);
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

// Usage example
$userReview1 = new UserReview("Class A", 4, "Great product!");
$userReview1->displayReviewDetails();

$userReview2 = new ExtendedUserReview("Class B", 5, "Awesome service!", "Additional information");
$userReview2->displayReviewDetails();
echo "Extra Info: " . $userReview2->getExtraInfo() . "\n";

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>Lorem ipsum dolor sit amet reiciendis natus fuga, cumque excepturi veniam ratione iure. Excepturi fugiat  officia  temporibus?</p>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit officia corporis ratione saepe sed adipisci?</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

 

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Yllka Berisha</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Noar Kuleta</h3>
      </div>

      <div class="box">
         <img src="images/pic-4.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt ad, quo labore fugiat nam accusamus quia. Ducimus repudiandae dolore placeat.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Lura Ibishi</h3>
      </div>

   </div>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>