<?php
session_start();

// Oturum zaman aşımı: 30 dakika
$timeout = 30 * 60;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    if (isset($_SESSION['cart'])) {
        require_once 'includes/db.php';
        foreach ($_SESSION['cart'] as $productId => $item) {
            $quantity = $item['quantity'];
            $stmt = $pdo->prepare("UPDATE products_amazon SET stock = stock + ? WHERE id = ?");
            $stmt->execute([$quantity, $productId]);
        }
    }
    session_unset();
    session_destroy();
    header("Location: login/login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login/login.php");
    exit;
}

require_once "includes/db.php";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>AmazonMini</title>
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <div class="container">
    <aside class="sidebar" id="sidebar">
      <button class="toggle-button" id="closeBtn" onclick="closeSidebar()">≡ メニュー</button>
      <button class="menu-button">🗂 カテゴリー</button>
      <button class="menu-button" onclick="window.location.href='cart/sepet.php'">🛒 カート</button>
      <button class="menu-button">⚙️ 設定</button>
      <button class="menu-button" onclick="window.location.href='login/logout.php'"> ログアウト</button>
    </aside>
    <main class="content">
      <div class="topbar">
        <div class="topbar-flex">
          <form class="search-form" id="searchForm">
            <input type="text" placeholder="商品を検索..." class="search-input" id="searchInput">
            <button type="submit" class="search-button">検索</button>
          </form>
          <div class="theme-switch">
            <label class="switch">
              <input type="checkbox" id="themeToggle">
              <span class="slider"></span>
            </label>
          </div>
        </div>
      </div>
      <div class="product-list">
        <?php
        try {
          $stmt = $pdo->query("SELECT * FROM products_amazon ORDER BY created_at DESC");
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <div class="product-card">
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="product-image">
              <div class="product-details">
                <p class="product-title"><?= htmlspecialchars($row['name']) ?></p>
                <div class="product-description short">
                  <?= nl2br(htmlspecialchars($row['description'])) ?>
                </div>
                <button class="toggle-desc-btn">もっと見る</button>
                <?php if ($row['stock'] <= 10): ?>
                  <p class="stock-warning">在庫は残り<?= htmlspecialchars($row['stock']) ?>個です！</p>
                <?php endif; ?>
                <div class="product-info">
                  <span class="product-price">￥<?= htmlspecialchars($row['price']) ?></span>
                  <div class="product-buttons">
                    <form action="add_to_cart.php" method="post" style="margin: 0;">
                      <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                      <button type="submit" class="add-cart">カートに追加</button>
                    </form>
                    <button class="buy-now">今すぐ購入</button>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } catch (PDOException $e) {
          echo "<p class='error'>データベースから商品を取得できませんでした: " . $e->getMessage() . "</p>";
        }
        ?>
      </div>
    </main>
  </div>

  <!-- Pop-up -->
  <div id="cart-popup" class="cart-popup">
    商品がカートに追加されました！
  </div>

  <button id="openBtn" class="open-button" onclick="openSidebar()">≡</button>
  <script src="assets/script.js"></script>
</body>
</html>