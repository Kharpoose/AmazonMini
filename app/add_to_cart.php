<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
  header("Location: login/login.php");
  exit;
}

require_once "includes/db.php";

// 商品IDが指定されていない場合はエラー
if (!isset($_POST['product_id'])) {
    die("商品IDが不足しています。");
}

$id = (int) $_POST['product_id'];

// 1. 商品情報を取得
$stmt = $pdo->prepare("SELECT * FROM products_amazon WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("商品が見つかりません。");
}

// 2. 在庫チェック
if ($product['stock'] <= 0) {
    die("在庫がありません。");
}

// 3. カートに追加（セッション）
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => 1
    ];
}

// 4. 在庫を1減らす
$update = $pdo->prepare("UPDATE products_amazon SET stock = stock - 1 WHERE id = ?");
$update->execute([$id]);

// 5. Ana sayfaya geri yönlendir
header("Location: index.php");
exit;
