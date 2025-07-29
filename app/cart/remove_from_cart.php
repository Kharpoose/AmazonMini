<?php
session_start();
require_once "../includes/db.php";

// 商品IDが指定されていない場合はエラー
if (!isset($_GET['id'])) {
    die("商品IDが不足しています。");
}

$id = (int) $_GET['id'];

// カートに商品がある場合のみ処理
if (isset($_SESSION['cart'][$id])) {
    $adet = $_SESSION['cart'][$id]['quantity'];

    // 1. 在庫を戻す
    $update = $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?");
    $update->execute([$adet, $id]);

    // 2. セッションから削除
    unset($_SESSION['cart'][$id]);
}

// カートページに戻る
header("Location: sepet.php");
exit;
