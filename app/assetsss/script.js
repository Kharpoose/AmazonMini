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