// https://nuxt.com/docs/guide/directory-structure/nuxt.config#nuxt-config-file
export default defineNuxtConfig({
  modules: [
    '@nuxt/content',
    "@nuxtjs/tailwindcss",
    "@nuxt/image",
    "@nuxtjs/color-mode",
    "nuxt-icon",
    "@nuxtjs/mdc",
    "@nuxthq/studio"
  ],
  mdc: {
    highlight: {
      langs: ['php','js', 'bash']
    }
  },
  colorMode: {
    classSuffix: ''
  },
  content: {
    documentDriven: true,
    highlight: {
      // See the available themes on https://github.com/shikijs/textmate-grammars-themes/tree/main/packages/tm-themes
      theme: {
        dark: 'github-dark',
        default: 'github-light'
      }
    }
  }
})