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
		"@/plugins/bootstrap.client.ts",
		{ src: '~/plugins/vee-validate.js', ssr: true },
	],
	buildModules: [
		'@nuxtjs/moment'
	],
	axios: {
		baseURL: 'http://127.0.0.1:8000/api',
	},
	modules: [["@nuxtjs/axios", { proxyHeaders: false }], "@nuxtjs/proxy"],
	// modules: [
	// 	['@nuxtjs/axios', { proxyHeaders: false }]
	// ],
	// axios: {
	// 	// See https://github.com/nuxt-community/axios-module#options
	// 	baseURL: process.env.NUXT_PUBLIC_API_BASE,
	// },
	// publicRuntimeConfig: {
	// 	axios: {
	// 	  baseURL: process.env.NUXT_PUBLIC_API_BASE,
	// 	},
	// },
	

})
