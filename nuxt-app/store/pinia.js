import { defineStore } from 'pinia'
import axios from 'axios'
export const useAuthStore = defineStore('auth' , {
	state: () => ({
		// TODO Initialize state from local storage to enable user to stay logged in
		user: localStorage.getItem('user'),
		id : localStorage.getItem('id'),
		token: localStorage.getItem('token'),
	}),
	getters : {
		isLoggedIn: state => !!state.user,
		userName: state => { return state.user },
		userId : state => { return state.id },
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
					this.user = response.data.data.user.name
					this.token = response.data.data.token
					this.id = response.data.data.user.id
					localStorage.setItem('user', response.data.data.user.name)
					localStorage.setItem('id' , response.data.data.user.id)
					localStorage.setItem('token', response.data.data.token)
				})
			})
		},

		async logout() {
			this.user = '',
			this.id = '',
			this.token = ''
		}
	},
})