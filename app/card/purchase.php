<?php
session_start();
require_once '../includes/db.php';

// Oturum kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$username = $_SESSION['user']['username'];

// Kullanıcı id'sini al
$stmt = $pdo->prepare("SELECT id FROM amazon_login WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "Kullanıcı bulunamadı.";
    exit;
}

$userId = $user['id'];

// Sepeti session'dan al
$cartItems = $_SESSION['cart'] ?? [];

if (empty($cartItems)) {
    echo "<h2>Sepetiniz boş.</h2>";
    exit;
}

try {
    $pdo->beginTransaction();

    foreach ($cartItems as $productId => $item) {
        $quantity = $item['quantity'];

        // Ürün adı products_amazon tablosundan alınsın (güvenli olsun diye)
        $stmtProduct = $pdo->prepare("SELECT name FROM products_amazon WHERE id = ?");
        $stmtProduct->execute([$productId]);
        $product = $stmtProduct->fetch();

        if (!$product) {
            throw new Exception("Ürün bulunamadı (ID: $productId)");
        }

        $productName = $product['name'];

        // Siparişi orders_amazon tablosuna kaydet
        $stmtInsert = $pdo->prepare("INSERT INTO orders_amazon (user_id, product_name, quantity) VALUES (?, ?, ?)");
        $stmtInsert->execute([$userId, $productName, $quantity]);
    }

    // Sepeti temizle
    unset($_SESSION['cart']);

    $pdo->commit();

    echo "<h2>✅ Sipariş başarıyla tamamlandı!</h2>";
    echo "<a href='../index.php'>Ana sayfaya dön</a>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<h2>❌ Hata oluştu: " . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "<a href='sepet.php'>Sepete dön</a>";
}
?>
