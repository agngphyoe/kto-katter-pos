
document.addEventListener('DOMContentLoaded', function() {
  var dropdownToggles = document.querySelectorAll('#dropdown-toggle');

  //////drop down ////////////
  dropdownToggles.forEach(function(toggle) {
    toggle.addEventListener('click', function() {
      // event.stopPropagation();
      var dropdownId = this.getAttribute('data-dropdown');
      var dropdownContent = document.getElementById(dropdownId);
      dropdownContent.classList.toggle('hidden');
   
    

      // dropdownToggles.forEach(function(otherToggle) {
      //   if (otherToggle !== toggle) {
      //     var otherDropdownId = otherToggle.getAttribute('data-dropdown');
      //     var otherDropdownContent = document.getElementById(otherDropdownId);
      //     otherDropdownContent.classList.add('hidden');
      //   }
      // });

       

     
    });
    
    
  });

  


});

 










   







