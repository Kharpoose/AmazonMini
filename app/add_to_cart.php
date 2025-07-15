<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
  header("Location: login/login.php");
  exit;
}
?>
<?php
require_once "includes/db.php";

if (!isset($_POST['product_id'])) {
    die("Ürün ID'si eksik.");
}

$id = (int) $_POST['product_id'];

// 1. Ürünü veritabanından al
$stmt = $pdo->prepare("SELECT * FROM products_amazon WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Ürün bulunamadı.");
}

// 2. Stok kontrolü
if ($product['stock'] <= 0) {
    die("Stok kalmadı.");
}

// 3. Sepete ekle (session)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => 1
    ];
}

// 4. Stok -1 güncelle
$update = $pdo->prepare("UPDATE products_amazon SET stock = stock - 1 WHERE id = ?");
$update->execute([$id]);

// 5. Ana sayfaya geri yönlendir
header("Location: index.php");
exit;
