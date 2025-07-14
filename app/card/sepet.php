<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="tr">

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