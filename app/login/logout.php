<?php
session_start();
require_once '../includes/db.php';

// Eğer sepette ürün varsa, her biri için stoğu geri artır
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $item) {
        $quantity = $item['quantity'];

        // Stok geri yükle
        $stmt = $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);
    }

    // Sepeti temizle
    unset($_SESSION['cart']);
}

// Oturumu tamamen sil
session_unset();
session_destroy();

// Giriş sayfasına yönlendir
header("Location: ../login/login.php");
exit;
