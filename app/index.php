<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <title>AmazonMini</title>
  <link rel="stylesheet" href="asset/style.css">
  <style>
    
/* Switch stili */
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  background-color: #ccc;
  border-radius: 34px;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  transition: 0.4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

input:checked+.slider {
  background-color: #2196F3;
}

input:checked+.slider:before {
  transform: translateX(24px);
}
.product-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: flex-start;
}

.product-card {
  width: 220px;
  border: 1px solid #ccc;
  border-radius: 12px;
  overflow: hidden;
  background-color: #fff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease;
}

.product-card:hover {
  transform: scale(1.03);
}

.product-image {
  width: 100%;
  height: 160px;
  object-fit: cover;
}

.product-details {
  padding: 15px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.product-title {
  font-size: 16px;
  margin-bottom: 10px;
}

.product-info {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.product-price {
  font-weight: bold;
  font-size: 16px;
  color: #333;
}

.product-buttons {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.product-buttons button {
  padding: 6px 8px;
  font-size: 13px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.add-cart {
  background-color: #f0c14b;
  color: #111;
}

.buy-now {
  background-color: #ff9900;
  color: #fff;
}

.add-cart:hover {
  background-color: #e2b33c;
}

.buy-now:hover {
  background-color: #e68a00;
}
  </style>
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

  <script src="asset/script.js"></script>
</body>