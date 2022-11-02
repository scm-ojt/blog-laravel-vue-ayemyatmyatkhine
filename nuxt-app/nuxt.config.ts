// https://v3.nuxtjs.org/api/configuration/nuxt.config
export default defineNuxtConfig({
    meta: {
      title: 'NuxtOjt',
    },
    runtimeConfig: {
      Credential: true,
      baseURL: 'http://localhost:8000/api',
      debug: process.env.DEBUG
    },
    css: [
        'bootstrap/dist/css/bootstrap.min.css',
        '@fortawesome/fontawesome-svg-core/styles.css',
        '@vueform/multiselect/themes/default.css'
      ],
      script: [
        {
          src: 'bootstrap/dist/js/bootstrap.bundle.min.js'
        }
      ],
      vite: {
        define: {
          'process.env.DEBUG': false,
        },
      },

})
