<template>
    <div class="mx-auto my-auto flex-column">
        <img src="../assets/images/nuxt-logo.png" alt="" class="logo mx-auto d-block">
        <h4 class="title text-center mt-2 mb-4">Please Login In</h4>
        <form action="" class="login-form" @submit.prevent="login">
            <div>
                <input type="text" class="form-control" v-model="email" placeholder="Please enter email">
                <span v-if="errorMessage.email" class="required">{{ errorMessage.email[0] }}</span>
                <span v-if="errorMessage.errorMessage" class="required">{{ errorMessage.errorMessage }}</span>
            </div>
            <div class="my-4">
                <input type="password" class="form-control" v-model="password" placeholder="Please enter password">
                <span v-if="errorMessage.password" class="required">{{ errorMessage.password[0] }}</span>
            </div>
            <div class="mb-5">
                <button class="btn btn-custom form-control" type="submit">Sing In</button>
            </div>
        </form>
    </div>
</template>

<script setup>
    import { useAuthStore } from '~/store/pinia'
    const store = useAuthStore()
    definePageMeta({
        layout: "default",
    });
    const router = useRouter()
    const runtimeConfig = useRuntimeConfig()
    const email = ref()
    const password = ref()
    const errorMessage = ref({})
    const user = ref()
    const login = async() => {
        const data = {
            email : email.value,
            password : password.value
        }
        store.login(data).then((response) => {
            user.value = store.userName
            router.push('/post')
        })
        .catch((error)=>{
            if (error.response.status == 401){
        		errorMessage.value = error.response.data
        	}
        	else {
        		errorMessage.value = error.response.data.errors
        	}
        })
    }
    watchEffect(() => {
        if (user.value) {
            return navigateTo('/post');
        }
    });
</script>

<style src="../assets/css/list.css"></style>