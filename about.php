<?php
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

// Usage example
$userReview1 = new UserReview
("Ema Gashi", 4, "My experience with this online cat shop has been exceptional, from their diverse selection of cats to their thorough adoption process. Their detailed profiles and continuous support made finding and welcoming my new cat into my home a joyous experience, and she has since become an irreplaceable part of my family. I'm thankful for this shop's dedication to both their cats' well-being and fostering meaningful connections with their customers.");
$userReview1->displayReviewDetails();

$userReview2 = new ExtendedUserReview
("Drin Berisha", 5, "My experience with this online cat shop exceeded all expectations! From browsing their extensive selection of cats to the seamless adoption process, every step was a delight. The staff was knowledgeable and passionate about finding the right fit for both me and the cat. I appreciated their commitment to responsible adoption practices and the thorough vetting process they conducted. I'm grateful to this online shop for making it possible.", "Additional information");
$userReview2->displayReviewDetails();


$userReview3 = new UserReview
("Ela Bajrami", 5, "Discovering this online cat shop was a dream come true for me as an allergy sufferer, as their hypoallergenic cat breeds allowed me to fulfill my wish for a feline companion without compromising my health. Their seamless adoption process, coupled with the invaluable support and guidance from their staff, made the experience truly fulfilling, and I couldn't be happier with my adorable and affectionate new cat. I love this page!");
$userReview3->displayReviewDetails();

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
    <p><?php echo $userReview1->getMessage(); ?></p>
    <div class="stars">
        <?php 
        
        $starRating = $userReview1->getStarRating();
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $starRating) {
                echo '<i class="fas fa-star"></i>';
            } else {
                echo '<i class="fas fa-star-half-alt"></i>';
            }
        }
        ?>
    </div>
    <h3><?php echo $userReview1->getName(); ?></h3>
</div>
<div class="box">
<img src="images/pic-3.png" alt="">
<p><?php echo $userReview2->getMessage(); ?></p>
<div class="stars">
    <?php 
    $starRating = $userReview2->getStarRating();
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $starRating) {
            echo '<i class="fas fa-star"></i>';
        } else {
            echo '<i class="fas fa-star-half-alt"></i>';
        }
    }
    ?>
</div>
<h3><?php echo $userReview2->getName(); ?></h3>
</div>
      <div class="box">
         <img src="images/pic-4.png" alt="">
         <p><?php echo $userReview3->getMessage(); ?></p>
<div class="stars">
    <?php 
    $starRating = $userReview3->getStarRating();
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $starRating) {
            echo '<i class="fas fa-star"></i>';
        } else {
            echo '<i class="fas fa-star-half-alt"></i>';
        }
    }
    ?>
</div>
<h3><?php echo $userReview3->getName(); ?></h3>
</div>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>