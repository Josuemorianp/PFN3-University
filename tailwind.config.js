/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html, js, php}", "./**.php", "./src/**/**/*.php"],
  theme: {
    extend: {
      fontFamily:{
        'Open Sans': ['Open Sans', 'sans-serif'],
      }
    },
  },
  plugins: [],
}