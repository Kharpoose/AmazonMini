<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once "../includes/db.php";

$id = (int) ($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if (!isset($_SESSION['cart'][$id])) {
    header("Location: sepet.php");
    exit;
}

if ($action === 'increase') {
    // Veritabanında stok varsa artır
    $stmt = $pdo->prepare("SELECT stock FROM products_amazon WHERE id = ?");
    $stmt->execute([$id]);
    $stock = $stmt->fetchColumn();

    if ($stock > 0) {
        $_SESSION['cart'][$id]['quantity'] += 1;
        $pdo->prepare("UPDATE products_amazon SET stock = stock - 1 WHERE id = ?")->execute([$id]);
    }

} elseif ($action === 'decrease') {
    if ($_SESSION['cart'][$id]['quantity'] > 1) {
        $_SESSION['cart'][$id]['quantity'] -= 1;
        $pdo->prepare("UPDATE products_amazon SET stock = stock + 1 WHERE id = ?")->execute([$id]);
    } else {
        // 1'den azsa komple sil
        header("Location: remove_from_cart.php?id=$id");
        exit;
    }
}

header("Location: sepet.php");
exit;
