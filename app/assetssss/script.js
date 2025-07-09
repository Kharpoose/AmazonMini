const sidebar = document.getElementById("sidebar");
const openBtn = document.getElementById("openBtn");
const closeBtn = document.getElementById("closeBtn");

function closeSidebar() {
  sidebar.classList.add("closed");
  openBtn.style.display = "block";
}

function openSidebar() {
  sidebar.classList.remove("closed");
  openBtn.style.display = "none";
}

document.getElementById("themeToggle").addEventListener("change", function() {
  document.body.classList.toggle("dark-mode", this.checked);
});

// Sayfa aşağı kaydırıldığında sidebar'ı kapat
let lastScrollTop = 0;
let sidebarManuallyOpened = false;

window.addEventListener("scroll", function () {
  let st = window.pageYOffset || document.documentElement.scrollTop;

  // Sadece aşağı kaydırınca kapat
  if (st > lastScrollTop) {
    if (!sidebar.classList.contains("closed")) {
      closeSidebar();
      sidebarManuallyOpened = false;
    }
  }

  // Sadece en tepeye çıkınca aç
  if (st === 0 && sidebar.classList.contains("closed") && !sidebarManuallyOpened) {
    openSidebar();
    sidebarManuallyOpened = true;
  }

  lastScrollTop = st <= 0 ? 0 : st;
}, false);