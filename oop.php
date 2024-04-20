<?php
class Animal {
    protected $breed;
    protected $color;
    protected $height;
    protected $weight;

    public function __construct($breed, $color, $height, $weight) {
        $this->breed = $breed;
        $this->color = $color;
        $this->height = $height;
        $this->weight = $weight;
       // echo "Animal created: " . $this->breed . "\n";
    }

    public function __destruct() {
        echo "Animal destroyed: " . $this->breed . "\n";
    }
    public function introduce() {
        echo "I am a " . $this->breed . " with " . $this->color . " fur. I am " . $this->height . " tall and weigh " . $this->weight . ".\n";
    }

    public function getBreed() {
        return $this->breed;
    }
    public function setBreed($breed) {
        $this->breed = $breed;
    }

    public function getColor() {
        return $this->color;
    }
    public function setColor($color) {
        $this->color = $color;
    }

    public function getHeight() {
        return $this->height;
    }
    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWeight() {
        return $this->weight;
    }
    public function setWeight($weight) {
        $this->weight = $weight;
    }
}

class Cat extends Animal {
    private $age;
    private $name;

    public function __construct($breed, $color, $height, $weight, $age, $name) {
        parent::__construct($breed, $color, $height, $weight);
        $this->age = $age;
        $this->name = $name;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
}

class Order {
    private $orderId;
    private $product;
    private $quantity;

    public function __construct($orderId, $product, $quantity) {
        $this->orderId = $orderId;
        $this->product = $product;
        $this->quantity = $quantity;
        echo "Order created: " . $this->orderId . " for product: " . $this->product . "\n";
    }

    public function getOrderId() {
        return $this->orderId;
    }

    public function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setProduct($product) {
        $this->product = $product;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
}
$animal = new Animal('Cat', 'Brown', '60cm', '25kg');
$animal->introduce();

$cat = new Cat('Siamese', 'White', '30cm', '5kg', 3, 'Fluffy');
$cat->introduce();

$order = new Order(123456, 'Mi', 2);

?>
<?php
