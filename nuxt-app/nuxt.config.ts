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
	alias: {
		'class-validator': 'class-validator/cjs/index.js',
	},
	vite: {
		define: {
			'process.env.DEBUG': false,
		},
		optimizeDeps: {
			exclude: ['class-validator']
		}
	},
	plugins: [
		"@/plugins/bootstrap.client.ts",
	],
	buildModules: [
		'@nuxtjs/moment',
		["@nuxtjs/axios", { proxyHeaders: false }], "@nuxtjs/proxy" ,
		'@pinia/nuxt'
	],
	axios: {
		credentials: true
	},
	// modules: [
		
	// ],
	// auth: {
	// 	strategies: {
	// 	  laravelSanctum: {
	// 		provider: 'laravel/sanctum',
	// 		url: 'http://localhost:8000',
	// 	  },
	// 	},
	// },
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
