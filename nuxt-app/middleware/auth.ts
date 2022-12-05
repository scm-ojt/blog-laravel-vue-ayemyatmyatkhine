import { useAuthStore } from '~/store/pinia';
import editPost from '../pages/post/edit/[id].vue'
export default defineNuxtRouteMiddleware((to , from) => {
	const authStore = useAuthStore();
	const isLoggin = authStore.isLoggedIn
	if (to.name !== 'login' && !localStorage.getItem('token')) {
		return navigateTo('/login');
	}
	else if(isLoggin && to.path === '/post/edit/'){
		if(to.params.id !== from.params.id) {
			return navigateTo('/post')
		}
	}
});