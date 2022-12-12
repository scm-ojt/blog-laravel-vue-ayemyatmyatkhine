import { useAuthStore } from '~/store/pinia';
export default defineNuxtRouteMiddleware((to , from) => {
	
	if (to.name !== 'login' && !localStorage.getItem('token')) {
		return navigateTo('/login');
	}
});