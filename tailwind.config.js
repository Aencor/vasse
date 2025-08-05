/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.php",
    "./assets/**/*.{js,jsx,ts,tsx,vue}",
  ],
  darkMode: 'class', // Habilitar modo oscuro basado en clases
  theme: {
    extend: {
      colors: {
        // Puedes agregar colores personalizados aquí
      },
      fontFamily: {
        // Configura tus fuentes personalizadas aquí
      },
    },
  },
  plugins: [
    // Agrega plugins de Tailwind aquí si es necesario
  ],
}
