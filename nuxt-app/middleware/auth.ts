import { useAuthStore } from '~/store/pinia';

export default defineNuxtRouteMiddleware(async (to) => {
  const authStore = useAuthStore();

  if (to.name !== 'login' && !localStorage.getItem('token')) {
    return navigateTo('/login');
  } 
  // else if (to.name !== 'login' && !authStore.user) {
  //   authStore.setAuthUser(await $fetch('/api/getauthuser', {
  //     headers: authHeader,
  //   }));
  // }
});