/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    // "./node_modules/flowbite/**/*.js",

  ],
  theme: {
    extend: {
      fontFamily: {
        jakarta:'Plus Jakarta Sans',
        inter:'Inter',
        poppins:'Poppins',
      },
      colors: {
        primary: '#00812C',
        secondary:'#BD5907',
        thirdy:'#B3FF98',
        forthy:'#FBD690',
        paraColor:"#777777",
        bgMain:'#E0F1E4',
        headColor:' #FFC727',
        noti:'#FF8A00'

      },

    },
  },
  plugins: [
    // ...
    require('tailwind-scrollbar')({ nocompatible: true }),
    // require('flowbite/plugin'),
  ],
}

