<?php
session_start();
require_once '../includes/db.php';

// Oturum kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit;
}

$username = $_SESSION['username'];

// Kullanıcı id'sini al
$stmt = $pdo->prepare("SELECT id FROM amazon_login WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "Kullanıcı bulunamadı.";
    exit;
}

$userId = $user['id'];

// Sepeti al
$cartItems = $_SESSION['cart'] ?? [];

if (empty($cartItems)) {
    echo "<h2>Sepetiniz boş.</h2>";
    exit;
}

try {
    $pdo->beginTransaction();

    foreach ($cartItems as $productId => $item) {
        $quantity = $item['quantity'];

        // Stok kontrolü
        $stmtStock = $pdo->prepare("SELECT stock FROM products_amazon WHERE id = ?");
        $stmtStock->execute([$productId]);
        $product = $stmtStock->fetch();

        if (!$product || $product['stock'] < $quantity) {
            throw new Exception("Yetersiz stok: Ürün ID $productId");
        }

        // Stok güncelle
        $stmtUpdate = $pdo->prepare("UPDATE products_amazon SET stock = stock - ? WHERE id = ?");
        $stmtUpdate->execute([$quantity, $productId]);

        // Siparişi kaydet
        $stmtInsert = $pdo->prepare("INSERT INTO orders_amazon (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmtInsert->execute([$userId, $productId, $quantity]);
    }

    // Sepeti temizle
    unset($_SESSION['cart']);

    $pdo->commit();

    // Başarı mesajı
    echo "<h2>Sipariş başarıyla tamamlandı!</h2>";
    echo "<a href='../index.php'>Ana sayfaya dön</a>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<h2>Hata oluştu: " . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "<a href='sepet.php'>Sepete dön</a>";
}
?>
