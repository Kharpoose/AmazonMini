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
