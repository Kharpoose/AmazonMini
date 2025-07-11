<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <title>AmazonMini</title>
  <link rel="stylesheet" href="assetssss/style.css">
</head>

<body>
  <div class="container">
    <aside class="sidebar" id="sidebar">
      <button class="toggle-button" id="closeBtn" onclick="closeSidebar()">≡ Menü</button>
      <button class="menu-button">🗂 Kategori</button>
      <button class="menu-button">🛒 Sepet</button>
      <button class="menu-button">⚙️ Ayarlar</button>
    </aside>
    <main class="content">
      <div class="topbar">
        <div class="topbar-flex">
          <form class="search-form" action="#" method="get">
            <input type="text" placeholder="Ürün ara..." class="search-input">
            <button type="submit" class="search-button">Ara</button>
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
        require_once "includes/db.php";
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
                <button class="toggle-desc-btn">Daha Fazla Göster</button>
                <?php if ($row['stock'] <= 10): ?>
                  <p class="stock-warning">Stokta sadece <?= htmlspecialchars($row['stock']) ?> adet kaldı!</p>
                <?php endif; ?>
                <div class="product-info">
                  <span class="product-price">₺<?= htmlspecialchars($row['price']) ?></span>
                  <div class="product-buttons">
                    <button class="add-cart">Sepete Ekle</button>
                    <button class="buy-now">Hemen Al</button>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } catch (PDOException $e) {
          echo "<p style='color: red;'>Veritabanından ürünler alınamadı: " . $e->getMessage() . "</p>";
        }
        ?>
      </div>
    </main>
  </div>
  <button id="openBtn" class="open-button" onclick="openSidebar()">≡</button>
  <script src="assetssss/script.js"></script>
</body>

</html>