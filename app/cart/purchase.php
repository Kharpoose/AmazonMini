<?php
session_start();
require_once '../includes/db.php';

// セッション確認
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: ../login/login.php");
    exit;
}

$username = $_SESSION['user']['username'];

// ユーザーID取得
$stmt = $pdo->prepare("SELECT id FROM amazon_login WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
    echo "ユーザーが見つかりません。";
    exit;
}

$userId = $user['id'];

// カート情報取得
$cartItems = $_SESSION['cart'] ?? [];

if (empty($cartItems)) {
    echo "<h2>カートは空です。</h2>";
    echo '<a href="../index.php" style="display:inline-block;margin-top:20px;padding:10px 20px;background:#222;color:#fff;border-radius:6px;text-decoration:none;">ホームに戻る</a>';
    exit;
}

try {
    $pdo->beginTransaction();

    foreach ($cartItems as $productId => $item) {
        $quantity = $item['quantity'];

        // 商品名取得（安全のためDBから）
        $stmtProduct = $pdo->prepare("SELECT name FROM products_amazon WHERE id = ?");
        $stmtProduct->execute([$productId]);
        $product = $stmtProduct->fetch();

        if (!$product) {
            throw new Exception("商品が見つかりません (ID: $productId)");
        }

        $productName = $product['name'];

        // 注文情報をorders_amazonテーブルに保存
        $stmtInsert = $pdo->prepare("INSERT INTO orders_amazon (user_id, product_name, quantity) VALUES (?, ?, ?)");
        $stmtInsert->execute([$userId, $productName, $quantity]);
    }

    // カートをクリア
    unset($_SESSION['cart']);

    $pdo->commit();

    echo "<h2>✅ ご注文が正常に完了しました！</h2>";
    echo "<a href='../index.php'>ホームに戻る</a>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<h2>❌ エラーが発生しました: " . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "<a href='sepet.php'>カートに戻る</a>";
}
?>
