<template>
    <div class=" d-flex flex-column min-vh-100">
        <Header>
            <nav class="navbar navbar-expand-lg navbar-custom">
                <div class="container">
                   <NuxtLink  class="navbar-brand" to="/">
                        <img src="../assets/images/logo.webp" alt="" class="nav-logo">
                        <h1 class="header">NUXT PJ</h1>
                    </NuxtLink>
                   <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <NuxtLink class="nav-link" to="/register">Register</NuxtLink>
                            </li>
                            <li class="nav-item">
                                <NuxtLink class="nav-link" to="/login">Login</NuxtLink>
                            </li>
                        </ul>
                   </div>
                </div>
            </nav>
        </Header>
       <slot />
       <footer>
            <p class="footer">Copyright © 2022, All Rights Reserved.</p>
       </footer>
    </div>
</template>

<style src="../assets/css/layout.css"></style>