/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      primary: '#476C5E',
      light: '#F3F6EE',
      black: '#000',
      hover: '#F6EEDB',

      gray400: '#9ca3af',
      lightGray:'#e9f7f7',
      hoverGreen: '#4ade80',

      // neutral: colors.gray,
    },
    extend: {},
  },
  plugins: [],
}

