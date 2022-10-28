<template>
    <div class="mx-auto my-auto flex-column">
        <img src="../assets/images/nuxt-logo.png" alt="" class="logo mx-auto d-block">
        <h4 class="title text-center mt-2 mb-4">Please Login In</h4>
        <form action="" class="login-form">
            <div class="mb-3">
                <label for="email" class="form-label">Please enter email</label>
                <input type="text" class="form-control">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Please enter password</label>
                <input type="text" class="form-control">
            </div>
            <div class="mb-5">
                <button class="btn btn-custom form-control">Sing In</button>
            </div>
        </form>
    </div>
</template>

<script>
    definePageMeta({
        layout: "default",
    });
</script>

<style>
.logo {
    width: 165px;
    height: 110px;
    margin: 0 auto;
}
.login-form, 
.register-form {
    width: 400px;
    min-width: 300px;
}
.btn-custom {
    background-color: goldenrod;
}
.btn-custom:hover {
    background-color: rgb(65, 224, 184);
}
</style>