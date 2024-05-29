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

