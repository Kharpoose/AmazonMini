<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <title>AmazonMini</title>
  <link rel="stylesheet" href="assetss/style.css">
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
        <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
          <form class="search-form">
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
        <div class="product-card">
          <img src="uploads/8X8h.gif" alt="Ürün 1" class="product-image">
          <div class="product-details">
            <p class="product-title">Bluetooth Kulaklık</p>
            <div class="product-info">
              <span class="product-price">₺249</span>
              <div class="product-buttons">
                <button class="add-cart">Sepete Ekle</button>
                <button class="buy-now">Hemen Al</button>
              </div>
            </div>
          </div>
        </div>
        <div class="product-card">
          <img src="uploads/test1.jpg" alt="Ürün 2" class="product-image">
          <div class="product-details">
            <p class="product-title">Kablosuz Mouse</p>
            <div class="product-info">
              <span class="product-price">₺179</span>
              <div class="product-buttons">
                <button class="add-cart">Sepete Ekle</button>
                <button class="buy-now">Hemen Al</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Kapatılmışken görünen küçük açma butonu -->
  <button id="openBtn" class="open-button" onclick="openSidebar()" style="display:none;">≡</button>

  <script src="assetss/script.js"></script>
</body>