import LaravelVuePagination from 'laravel-vue-pagination'

export default defineNuxtPlugin((nuxtApp) => {
    nuxtApp.vueApp.component('pagination', LaravelVuePagination)
})
