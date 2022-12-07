<template>
    <div class="mx-auto my-auto flex-column">
        <img src="../assets/images/nuxt-logo.png" alt="" class="logo mx-auto d-block">
        <h4 class="title text-center mt-2 mb-4">Please Sign Up</h4>
        <div v-if="successMessage" class="alert alert-success" role="alert">{{successMessage}}</div>
        <form action="" class="register-form" @submit.prevent="register">
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="User Name" v-model="name" name="name">
                <span v-if="errorMessage.name" class="required">{{ errorMessage.name[0] }}</span>
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Email Address" v-model="email" name="email">
                <span v-if="errorMessage.email" class="required">{{ errorMessage.email[0] }}</span>
            </div>
            <div class="mb-4">
                <input type="password" class="form-control" placeholder="Password" v-model="password" name="password">
                <span v-if="errorMessage.password" class="required">{{ errorMessage.password[0] }}</span>
            </div>
            <div class="mb-4">
                <input type="password" name="confirm_password" class="form-control" placeholder="Password Confirmation" v-model="confirm_password">
                <span v-if="errorMessage.confirm_password" class="required">{{ errorMessage.confirm_password[0] }}</span>
            </div>
            <div class="mb-5">
                <button class="btn btn-custom form-control" type="submit">Sing Up</button>
            </div>
        </form>
    </div>
</template>

<script setup>
    import axios from 'axios'
    import { useAuthStore } from '~/store/pinia'

    definePageMeta({
        layout: "default",
    });

    const store = useAuthStore()
    const runtimeConfig = useRuntimeConfig()
    const router = useRouter()
    const name = ref()
    const email = ref()
    const password = ref()
    const confirm_password = ref()
    const successMessage = ref()
    const errorMessage = ref({})
    const success = ref(true)
    async function register() {
        const formData = new FormData()
        if (name.value != null && email.value != null && password.value != null && confirm_password.value != null || (name.value != null || email.value != null || password.value != null || confirm_password.value != null)) {
            formData.append('name' , name.value),
            formData.append('email' , email.value),
            formData.append('password' , password.value),
            formData.append('confirm_password' , confirm_password.value)
        }
        await axios.post(runtimeConfig.public.apiBase + "/register", formData , {
            headers : {
                'Accept' : 'application/json',
                'Content-Type' : 'application/json',
            },
        }).then((response)=>{
            successMessage.value = response.data.successMessage
            success.value = true
        }).catch((error)=>{
            errorMessage.value = error.response.data.errors
            success.value = false
        })
        if(success.value){
            const data = {
                email : email.value,
                password : password.value
            }
            console.log(data)
            store.login(data).then((response)=>{
                router.push('/post')
            })
        }
    }
</script>

<style src="../assets/css/layout.css"></style>