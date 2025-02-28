


    document.addEventListener("DOMContentLoaded", function() {
      const dropdownBtn = document.getElementById("dropdown-btn");
      const dropdownMenu = document.getElementById("dropdown-menu");
      const notiMenu = document.getElementById("noti-menu");
      const notiBtn = document.getElementById("noti-btn");

      notiBtn.addEventListener("click",()=>{
        notiMenu.classList.toggle("hidden");
      })

      const menuBtn = document.getElementById("menu-btn");
      const sidebarBtn = document.getElementById("sidebar-btn");
      const closeBtn=document.getElementById("close-btn");

      closeBtn.addEventListener("click",function(){
        console.log("u click close");
        sidebarBtn.classList.toggle("hidden");
      })

      menuBtn.addEventListener("click",function(){
        console.log("u click menu");
        sidebarBtn.classList.toggle("hidden");
        // sidebarBtn.classList.toggle("transform  transition-transform duration-300 ease-in-out ");
      })
    
      dropdownBtn.addEventListener("click", function() {
        console.log("u click dropdown-btn");
        dropdownMenu.classList.toggle("hidden");
      });
    
      document.addEventListener("click", function(event) {
        if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target) ) {
          dropdownMenu.classList.add("hidden");
        }
        if( !notiMenu.contains(event.target) && !notiBtn.contains(event.target)){
          notiMenu.classList.add("hidden");

        }
      });
    });
    
  

 


  