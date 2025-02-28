


document.addEventListener("DOMContentLoaded", function() {
    const dropdownBtn = document.getElementById("dropdown-btn");
    const dropdownMenu = document.getElementById("dropdown-menu");
    const notiMenu = document.getElementById("noti-menu");
    const notiBtn = document.getElementById("noti-btn");

    notiBtn.addEventListener("click",()=>{
      notiMenu.classList.toggle("hidden");
    })

  
  
    dropdownBtn.addEventListener("click", function() {

      dropdownMenu.classList.toggle("hidden");
    });
  
    // document.addEventListener("click", function(event) {
    //   if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
    //     dropdownMenu.classList.add("hidden");
    //   }
    //   if (!notiMenu.contains(event.target) && !notiBtn.contains(event.target)) {
    //     notiMenu.classList.add("hidden");
    //   }
    // });
  });
  





