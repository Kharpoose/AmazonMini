<?php
session_start();
require_once "../includes/db.php";

if (!isset($_GET['id'])) {
    die("Ürün ID'si eksik.");
}

$id = (int) $_GET['id'];

// Sepette varsa işlem yap
if (isset($_SESSION['cart'][$id])) {
    $adet = $_SESSION['cart'][$id]['quantity'];

    // 1. Stok geri ekle
    $update = $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?");
    $update->execute([$adet, $id]);

    // 2. Session'dan çıkar
    unset($_SESSION['cart'][$id]);
}

header("Location: sepet.php");
exit;
