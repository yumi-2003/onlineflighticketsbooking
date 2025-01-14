/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/*.{html,js,php}",'./node_modules/flowbite/**/*.js'],
  theme: {
    extend: {
      colors: {
        "darkBlue" : "#00103c"
      }
    },
  },
  plugins: [require('flowbite/plugin')],

};

