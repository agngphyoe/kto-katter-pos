const delete1=document.getElementById('delete');
delete1.addEventListener("click",(e)=>{
    e.preventDefault();
    console.log("hello");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            title:'my-title',
          confirmButton: ' confirm-Button',
          cancelButton: 'cancel-Button',
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        imageUrl: "https://as2.ftcdn.net/v2/jpg/05/67/60/69/1000_F_567606970_g1iUgsB1hWTK15ONkrnN6MxwJ36rcRei.jpg",
        imageAlt: 'Custom Image',
        imageWidth: 400,
        imageHeight: 300,
        title: 'Are you sure you want to delete this products?',
        showCancelButton: true,
        confirmButtonText: 'Sure',
        cancelButtonText: 'No',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            // 'Deleted!',
            // 'Your product is successfully deleted.',
            // 'Back to Main Page ->'
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          )
        }
      })
   
})


// edit alert

const edit=document.getElementById('edit');
edit.addEventListener("click",(e)=>{
    e.preventDefault();
    console.log("hello");
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            title:'my-title',
          confirmButton: ' confirm-Button',
          cancelButton: 'cancel-Button',
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        imageUrl: "https://as2.ftcdn.net/v2/jpg/05/67/60/69/1000_F_567606970_g1iUgsB1hWTK15ONkrnN6MxwJ36rcRei.jpg",
        imageAlt: 'Custom Image',
        imageWidth: 400,
        imageHeight: 300,
        title: 'Are you sure you want to edit this products?',
        showCancelButton: true,
        confirmButtonText: 'Sure',
        cancelButtonText: 'No',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Deleted!',
            'Your product is successfully deleted',
            'success'
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          )
        }
      })
   
})