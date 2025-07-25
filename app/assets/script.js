const sidebar = document.getElementById("sidebar");
const openBtn = document.getElementById("openBtn");
const closeBtn = document.getElementById("closeBtn");

let sidebarLocked = false; // ユーザーがボタンで開閉した場合は true

function closeSidebar() {
  sidebar.classList.add("closed");
  openBtn.style.display = "block";
  sidebarLocked = true; // ユーザーが閉じたのでスクロールで変更しない
}

function openSidebar() {
  sidebar.classList.remove("closed");
  openBtn.style.display = "none";
  sidebarLocked = true; // ユーザーが開いたのでスクロールで変更しない
}

document.getElementById("themeToggle").addEventListener("change", function() {
  document.body.classList.toggle("dark-mode", this.checked);
});

let lastScrollTop = 0;

window.addEventListener("scroll", function () {
  if (sidebarLocked) return; // ユーザーがボタンで開閉した場合はスクロールで変更しない

  let st = window.pageYOffset || document.documentElement.scrollTop;

  // 下にスクロールした時だけ閉じる
  if (st > lastScrollTop) {
    if (!sidebar.classList.contains("closed")) {
      sidebar.classList.add("closed");
      openBtn.style.display = "block";
    }
  }

  // 一番上に戻った時だけ開く
  if (st === 0 && sidebar.classList.contains("closed")) {
    sidebar.classList.remove("closed");
    openBtn.style.display = "none";
  }

  lastScrollTop = st <= 0 ? 0 : st;
}, false);

document.addEventListener("DOMContentLoaded", function () {
  // 1. 説明文の長さをチェック
  const descriptions = document.querySelectorAll(".product-description");

  descriptions.forEach(desc => {
    const btn = desc.nextElementSibling;

    // 説明文の高さを一時的に展開して測定
    desc.classList.add("expanded");
    const fullHeight = desc.scrollHeight;
    desc.classList.remove("expanded");

    // すでに短い場合はボタンを非表示
    if (fullHeight <= 60) {
      btn.style.display = "none";
    }
  });

  // 2. ボタンをクリックしたら説明文を開閉
  const toggleButtons = document.querySelectorAll('.toggle-desc-btn');

  toggleButtons.forEach(button => {
    button.addEventListener('click', function () {
      const desc = this.previousElementSibling;

      desc.classList.toggle('expanded');

      if (desc.classList.contains('expanded')) {
        this.textContent = "少なく表示";
      } else {
        this.textContent = "もっと見る";
      }
    });
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const productList = document.querySelector('.product-list');

  // 検索フォームの送信を防ぐ（ページをリロードしない）
  document.getElementById('searchForm').addEventListener('submit', e => {
    e.preventDefault();
  });

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim().toLowerCase();

    const products = Array.from(productList.querySelectorAll('.product-card'));


    // フィルターと並び替え
    const filtered = products.filter(card => {
      const title = card.querySelector('.product-title').textContent.toLowerCase();
      return title.includes(query);
    });

    // 並び替え：先頭一致を優先
    filtered.sort((a, b) => {
      const aTitle = a.querySelector('.product-title').textContent.toLowerCase();
      const bTitle = b.querySelector('.product-title').textContent.toLowerCase();

      const aStarts = aTitle.startsWith(query) ? 0 : 1;
      const bStarts = bTitle.startsWith(query) ? 0 : 1;

      if (aStarts !== bStarts) return aStarts - bStarts;
      // 先頭一致が同じ場合はアルファベット順
      return aTitle.localeCompare(bTitle);
    });

    // 全ての商品を非表示
    products.forEach(card => card.style.display = 'none');

    // フィルター＆並び替えた商品を表示＆順序更新
    filtered.forEach(card => {
      card.style.display = 'block';
      productList.appendChild(card); // DOM'da sıralamayı güncelle
    });
  });
});

// ページ読み込み時に localStorage からテーマ情報を適用
document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('themeToggle');
    const isDark = localStorage.getItem('theme') === 'dark';

    if (isDark) {
        document.body.classList.add('dark-mode');
        if (themeToggle) themeToggle.checked = true;
    } else {
        document.body.classList.remove('dark-mode');
        if (themeToggle) themeToggle.checked = false;
    }

    if (themeToggle) {
        themeToggle.addEventListener('change', function () {
            if (this.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
        });
    }
});

