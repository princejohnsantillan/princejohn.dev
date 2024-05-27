// https://nuxt.com/docs/guide/directory-structure/nuxt.config#nuxt-config-file
export default defineNuxtConfig({
  modules: [
    '@nuxt/content',
    "@nuxtjs/tailwindcss",
    "@nuxtjs/color-mode",
    "nuxt-icon",
    "@nuxthq/studio",
    "@nuxt/eslint",
    "@vueuse/nuxt"
  ],

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
  },
  app:{
    head: {
      script: [
        {
          src: 'https://cloud.umami.is/script.js',
          'data-website-id': process.env.UMAMI_WEBSITE_ID,          
          defer: true
        }        
      ]
    }
  }
})