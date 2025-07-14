const sidebar = document.getElementById("sidebar");
const openBtn = document.getElementById("openBtn");
const closeBtn = document.getElementById("closeBtn");

let sidebarLocked = false; // Kullanıcı butonla açtı/kapattıysa true olur

function closeSidebar() {
  sidebar.classList.add("closed");
  openBtn.style.display = "block";
  sidebarLocked = true; // Kullanıcı kapattı, scroll ile değişmesin
}

function openSidebar() {
  sidebar.classList.remove("closed");
  openBtn.style.display = "none";
  sidebarLocked = true; // Kullanıcı açtı, scroll ile değişmesin
}

document.getElementById("themeToggle").addEventListener("change", function() {
  document.body.classList.toggle("dark-mode", this.checked);
});

let lastScrollTop = 0;

window.addEventListener("scroll", function () {
  if (sidebarLocked) return; // Kullanıcı butonla açtı/kapattıysa scroll ile değişmesin

  let st = window.pageYOffset || document.documentElement.scrollTop;

  // Sadece aşağı kaydırınca kapat
  if (st > lastScrollTop) {
    if (!sidebar.classList.contains("closed")) {
      sidebar.classList.add("closed");
      openBtn.style.display = "block";
    }
  }

  // Sadece en tepeye çıkınca aç
  if (st === 0 && sidebar.classList.contains("closed")) {
    sidebar.classList.remove("closed");
    openBtn.style.display = "none";
  }

  lastScrollTop = st <= 0 ? 0 : st;
}, false);

document.addEventListener("DOMContentLoaded", function () {
  // 1. Açıklamaları kontrol et: uzun/kısa
  const descriptions = document.querySelectorAll(".product-description");

  descriptions.forEach(desc => {
    const btn = desc.nextElementSibling;

    // Açıklamanın tam yüksekliğini ölçmek için geçici olarak aç
    desc.classList.add("expanded");
    const fullHeight = desc.scrollHeight;
    desc.classList.remove("expanded");

    // Eğer zaten kısa ise butonu gizle
    if (fullHeight <= 60) {
      btn.style.display = "none";
    }
  });

  // 2. Butonlara tıklanınca açıklamayı aç/kapat
  const toggleButtons = document.querySelectorAll('.toggle-desc-btn');

  toggleButtons.forEach(button => {
    button.addEventListener('click', function () {
      const desc = this.previousElementSibling;

      desc.classList.toggle('expanded');

      if (desc.classList.contains('expanded')) {
        this.textContent = "Daha Az Göster";
      } else {
        this.textContent = "Daha Fazla Göster";
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const productList = document.querySelector('.product-list');

  // Arama formunun submit'ini engelle (sayfa yenilenmesin)
  document.getElementById('searchForm').addEventListener('submit', e => {
    e.preventDefault();
  });

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim().toLowerCase();

    const products = Array.from(productList.querySelectorAll('.product-card'));


    // Filtre ve sırala
    const filtered = products.filter(card => {
      const title = card.querySelector('.product-title').textContent.toLowerCase();
      return title.includes(query);
    });

    // Sırala: Başlangıcı eşleşenler önce gelsin
    filtered.sort((a, b) => {
      const aTitle = a.querySelector('.product-title').textContent.toLowerCase();
      const bTitle = b.querySelector('.product-title').textContent.toLowerCase();

      const aStarts = aTitle.startsWith(query) ? 0 : 1;
      const bStarts = bTitle.startsWith(query) ? 0 : 1;

      if (aStarts !== bStarts) return aStarts - bStarts;
      // Başlangıcı eşit olanlarda alfabetik sırala
      return aTitle.localeCompare(bTitle);
    });

    // Önce tüm ürünleri gizle
    products.forEach(card => card.style.display = 'none');

    // Sonra filtrelenip sıralananları göster ve sırala
    filtered.forEach(card => {
      card.style.display = 'block';
      productList.appendChild(card); // DOM'da sıralamayı güncelle
    });
  });
});

