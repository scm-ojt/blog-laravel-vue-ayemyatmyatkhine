// https://v3.nuxtjs.org/api/configuration/nuxt.config
export default defineNuxtConfig({
	ssr: false,
	meta: {
		title: 'NuxtOjt',
	},
	runtimeConfig: {
		apiSecret : '',
      public: {
        apiBase: '',
		url : process.env.APP_URL
      }
	},
	css: [
		'bootstrap/dist/css/bootstrap.min.css',
		'@fortawesome/fontawesome-svg-core/styles.css',
		'@vueform/multiselect/themes/default.css',
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
	plugins: [
		"@/plugins/bootstrap.client.ts"
	]

})
