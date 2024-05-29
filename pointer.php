<?php
// Përdorimi dhe kuptimi i pointerëve në PHP

// Përcjellja përmes referencës
function shtoPesëNëÇmim(&$product)
{
    $product['price'] += 5;
}

// Shembull për funksionin shtoPesëNëÇmim
$produkt = array('name' => 'Kotele', 'price' => 50);
shtoPesëNëÇmim($produkt);
echo "Çmimi pas thirrjes së shtoPesëNëÇmim: " . $produkt['price'] . "\n"; // Shfaq 55

// Vendosja e referencave në mes të anëtarëve të vargut
$macet = array(
    array('name' => 'Kotele1', 'price' => 50),
    array('name' => 'Kotele2', 'price' => 60),
    array('name' => 'Kotele3', 'price' => 70)
);
$macet[0] = &$macet[1];
$macet[1]['price'] = 65;
echo "Çmimi i macet[0]: " . $macet[0]['price'] . "\n"; // Shfaq 65

// Përcjellja e vlerës përmes referencës
function ndryshoÇmimin(&$product, $newPrice)
{
    $product['price'] = $newPrice;
}

$a = array('name' => 'Kotele', 'price' => 50);
ndryshoÇmimin($a, 45);
echo "Çmimi i përditësuar i \$a: " . $a['price'] . "\n"; // Shfaq 45

// Përdorimi i funksioneve me referencë
function &gjejProduktin(&$products, $productName)
{
    foreach ($products as &$product) {
        if ($product['name'] == $productName) {
            return $product;
        }
    }
    return null;
}

$products = array(
    array('name' => 'Kotele1', 'price' => 50),
    array('name' => 'Kotele2', 'price' => 60)
);

$produktRef = &gjejProduktin($products, 'Kotele1');
$produktRef['price'] = 55;
echo "Çmimi i përditësuar i Kotele1: " . $products[0]['price'] . "\n"; // Shfaq 55

// Largimi i referencës
$c = array('name' => 'Kotele', 'price' => 50);
$d = &$c;
unset($d);
$d['price'] = 45;
echo "Çmimi i \$c pas unset(): " . $c['price'] . "\n"; // Shfaq 50

// Përdorimi i funksionit unset()
$variabli = array('name' => 'Kotele', 'price' => 50);
unset($variabli['price']);
if (!isset($variabli['price'])) {
    echo "Çmimi i variablit është i pa përcaktuar pas unset()\n"; // Shfaq mesazhin që çmimi është i papërcaktuar
}

// Funksione për menaxhimin e produkteve (macet)
function ulÇmimin(&$product, $discount) {
    $product['price'] -= $discount;
}

function shtoNëShportë(&$cart, $product) {
    $cart[] = $product;
}

function përditësoInformacioninEProduktit(&$product, $newInfo) {
    $product = array_merge($product, $newInfo);
}

function &gjejProduktinSipasID(&$products, $productId) {
    foreach ($products as &$product) {
        if ($product['id'] == $productId) {
            return $product;
        }
    }
    return null;
}

// Shembuj për menaxhimin e produkteve (macet)
$produkt = array('name' => 'Kotele', 'price' => 50);
ulÇmimin($produkt, 5);
echo "Çmimi i përditësuar pas uljes: " . $produkt['price'] . "\n"; // Shfaq 45

$shporta = array();
shtoNëShportë($shporta, $produkt);
print_r($shporta); // Shfaq produktin në shportë

$informacioniIRi = array('price' => 40);
përditësoInformacioninEProduktit($produkt, $informacioniIRi);
print_r($produkt); // Shfaq produktin me çmimin e përditësuar

$products = array(
    array('id' => 1, 'name' => 'Kotele', 'price' => 50),
    array('id' => 2, 'name' => 'Qen', 'price' => 100)
);

$produktRef = &gjejProduktinSipasID($products, 1);
$produktRef['price'] = 45;
print_r($products); // Shfaq produktet me çmimin e përditësuar për Kotele
?>