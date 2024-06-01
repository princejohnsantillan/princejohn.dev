import colors from 'tailwindcss/colors'

// https://nuxt.com/docs/guide/directory-structure/nuxt.config#nuxt-config-file
export default defineNuxtConfig({
  modules: [
    '@nuxt/content',
    "@nuxtjs/tailwindcss",
    "@nuxtjs/color-mode",
    "nuxt-icon",
    "@nuxt/eslint",
    "@vueuse/nuxt",
    "nuxt-og-image",
    "@nuxt/devtools"
  ],
  
  devtools: { enabled: true },

  ogImage: {    
    defaults: {
      props: {
        theme: colors.orange[500],
        colorMode: "dark"
      }
    }
  },

  // https://color-mode.nuxtjs.org/
  colorMode: {
    classSuffix: ''
  },

  // https://content.nuxt.com/
  content: {

    // https://content.nuxt.com/document-driven/introduction
    documentDriven: true,

    // https://content.nuxt.com/get-started/configuration#highlight
    highlight: {      

      // https://github.com/shikijs/textmate-grammars-themes/tree/main/packages/tm-themes
      theme: {
        dark: 'github-dark',
        default: 'github-light'
      },
      
      langs: [        
        'css',
        'php',
        'blade',
        'vue',
        'js',
        'ts',
        'json',
        'shell',
      ]
    }
  }  
})