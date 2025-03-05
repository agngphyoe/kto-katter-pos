document.addEventListener("DOMContentLoaded", function() {
    const dropdownBtn = document.getElementById("dropdown-btn1");
    const dropdownMenu = document.getElementById("dropdown-menu1");
  
    dropdownBtn.addEventListener("click", function() {
      dropdownMenu.classList.toggle("hidden");
    });
  });
  