<?php
session_start();

// Oturum zaman aşımı: 30 dakika
$timeout = 30 * 60;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    // Sepeti geri yükle
    if (isset($_SESSION['cart'])) {
        require_once '../includes/db.php';
        foreach ($_SESSION['cart'] as $productId => $item) {
            $quantity = $item['quantity'];
            $stmt = $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?");
            $stmt->execute([$quantity, $productId]);
        }
    }

    session_unset();
    session_destroy();
    header("Location: ../login/login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // her işlemde güncellenir

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: ../login/login.php");
    exit;
}
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="tr">
<!-- Bu dosya kullanıcının alışveriş sepetini gösterir -->

<head>
    <meta charset="UTF-8">
    <title>Sepetim</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
    <h1 style="text-align: center;">🛒 Sepetim</h1>
    <div style="text-align: center; margin-top: 20px;">
        <a href="../index.php" class="back-button">← Anasayfaya Dön</a>
    </div>
    <div style="text-align: right; margin-bottom: 15px;">
        <a href="clear_cart.php" class="remove-btn">🗑 Sepeti Temizle</a>
    </div>
    <form method="post" action="purchase.php">
        <button type="submit">Satın Al</button>
    </form>


    <div class="product-list" style="padding: 20px;">
        <?php if (empty($cart)): ?>
            <p>Sepetiniz boş.</p>
        <?php else: ?>
            <?php foreach ($cart as $id => $item): ?>
                <div class="product-card">
                    <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" class="product-image">
                    <div class="product-details">
                        <p class="product-title"><?= htmlspecialchars($item['name']) ?></p>
                        <p class="product-price">₺<?= number_format($item['price'], 2) ?></p>
                        <div class="cart-controls">
                            <a href="update_cart.php?id=<?= $id ?>&action=decrease">—</a>
                            <span><?= $item['quantity'] ?></span>
                            <a href="update_cart.php?id=<?= $id ?>&action=increase">🞧</a>
                            <a href="remove_from_cart.php?id=<?= $id ?>" class="remove-btn">🞪</a>
                        </div>

                        <p>Miktar: <?= $item['quantity'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>