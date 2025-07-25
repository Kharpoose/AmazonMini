<?php
session_start();
require_once '../includes/db.php';

// カートに商品がある場合は、在庫を元に戻す
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $item) {
        $quantity = $item['quantity'];

        // 在庫を戻す
        $stmt = $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);
    }

    // カートをクリア
    unset($_SESSION['cart']);
}

// セッションを完全に削除
session_unset();
session_destroy();

// ログインページへリダイレクト
header("Location: ../login/login.php");
exit;
