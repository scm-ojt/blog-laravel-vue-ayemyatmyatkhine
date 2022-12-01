import { defineStore } from 'pinia'
import axios from 'axios'
const baseUrl = process.env.NUXT_PUBLIC_API_BASE
export const useAuthStore = defineStore('auth' , {
	state: () => ({
			// TODO Initialize state from local storage to enable user to stay logged in
			user: '',
			id : '',
			token: '',
		}),
	getters : {
		isLoggedIn: (state) => !!state.user,
		userName: (state) => { return localStorage.getItem('user') },
		userId : (state) => { return localStorage.getItem('id') },
	},
	actions: {
		async login(data) {
			await axios.get('/sanctum/csrf-cookie').then((response)=> {
			 return axios.post('http://127.0.0.1:8000/api/login', data , {
					headers : {
						'Accept' : 'application/json',
						'Content-Type': 'application/json',
					},
				}).then((response) => {
					localStorage.setItem('user', response.data.data.user.name)
					localStorage.setItem('id' , response.data.data.user.id)
					localStorage.setItem('token', response.data.data.token)
				})
			})
		},

		async logout() {
			this.user = ''
			this.token = ''
			localStorage.setItem('user' , '')
			localStorage.setItem('token' , '')
			localStorage.setItem('id' , '')
		}
	},
})