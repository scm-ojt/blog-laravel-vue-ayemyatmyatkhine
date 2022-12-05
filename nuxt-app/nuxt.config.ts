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
		'@pinia/nuxt',
	],
	axios: {
		credentials: true
	},
	middleware: ['auth'],
})
