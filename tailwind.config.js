import colors from 'tailwindcss/colors'
import typography from '@tailwindcss/typography'

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  plugins: [
    typography(),
  ],
  theme: {
    extend: {
      colors: {
        primary: colors.orange
      }
    }
  }
}

