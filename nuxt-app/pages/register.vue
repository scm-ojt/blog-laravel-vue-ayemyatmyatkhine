<template>
    <div class="mx-auto my-auto flex-column">
        <img src="../assets/images/nuxt-logo.png" alt="" class="logo mx-auto d-block">
        <h4 class="title text-center mt-2 mb-4">Please Sign Up</h4>
        <form action="" class="register-form">
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="User Name">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Email Address">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Password">
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Password Confirmation">
            </div>
            <div class="mb-5">
                <button class="btn btn-custom form-control">Sing Up</button>
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
.navbar-custom {
    background-color: goldenrod;
}
.navbar-brand {
    display: contents;
}
.nav-logo {
    width: 70px;
    height: 60px;
}
.header {
    margin: 0;
}
.footer {
    background-color: black;
    color: goldenrod;
    clear:both;
    padding: 8px 0;
    text-align: center;
    margin: 0 auto;
}
.navbar-nav {
    margin: 0 0 0 auto;
   font-weight: bold;
}
</style>