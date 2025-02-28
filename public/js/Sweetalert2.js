const create=document.getElementById('create');
create.addEventListener("click",(e)=>{
    e.preventDefault();
    console.log("hello");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            title:'my-title',
            text:'text-primary',
          confirmButton: ' confirm-Button',
         
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        imageUrl: "/images/Done-rafiki.png",
        imageAlt: 'Custom Image',
        imageWidth: 300,
        imageHeight: 300,
        title: 'Well Done!',
        text: 'Your Product is created.',
        icon: 'info ',
        
        confirmButtonText: 'Back to Main Page ->',
       
       
      });
})





