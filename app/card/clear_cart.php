<?php
session_start();
require_once "../includes/db.php";

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $item) {
        $adet = $item['quantity'];
        $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?")->execute([$adet, $id]);
    }

    unset($_SESSION['cart']);
}

header("Location: sepet.php");
exit;
