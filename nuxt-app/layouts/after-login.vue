<template>
    <div class=" d-flex flex-column min-vh-100">
        <Header>
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container">
                   <NuxtLink  class="navbar-brand" to="/">
                        <img src="../assets/images/logo.webp" alt="" class="nav-logo">
                        <h1 class="header">NUXT PJ</h1>
                    </NuxtLink>
                   <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <NuxtLink class="nav-link" to="/category">Category</NuxtLink>
                            </li>
                            <li class="nav-item">
                                <NuxtLink class="nav-link" to="/post">Post</NuxtLink>
                            </li>
                            <li class="nav-item dropdown" id="nav-dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ user }}</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><button class="dropdown-item" @click.prevent="logout">Logout</button></li>
                                </ul>
                            </li>
                        </ul>
                   </div>
                </div>
            </nav>
        </Header>
        <slot/>
        <footer>
            <p class="footer">Copyright © 2022, All Rights Reserved.</p>
        </footer>
    </div>
</template>

<script setup>
    import {useAuthStore} from '~/store/pinia'
    import { onMounted } from 'vue';
    definePageMeta({
        middleware: 'auth',
    });
    const store = useAuthStore()
    const router = useRouter()
    const user = store.userName
    const logout = async() => {
        store.logout()
        router.push('/login')
    }
    watchEffect(() => {
        if (!user) {
            return navigateTo('/login');
        }
    });
</script>

<style src="../assets/css/layout.css"></style>

