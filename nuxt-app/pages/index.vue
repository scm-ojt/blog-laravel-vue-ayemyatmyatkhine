<template>
    <div class="mx-auto my-auto">
        <h1>Welcome</h1>
        <h3>NUXTJS OJT</h3>
    </div>
</template>

<script setup>
    import { useAuthStore } from '~/store/pinia'
    definePageMeta({
        layout: "default",
    });
    const store = useAuthStore()
    const user = store.userName
    console.log(user)
    watchEffect(() => {
        if (user) {
            return navigateTo('/post');
        }
    });
</script>