/** @type {import('tailwindcss').Config} */

import typography from '@tailwindcss/typography'
import colors from 'tailwindcss/colors'

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

