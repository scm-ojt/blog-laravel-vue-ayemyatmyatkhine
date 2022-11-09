<template>
    <div class="container mt-5 min-vh-75">
        <div class="header mb-5">
            <div class="create-btn">
                <NuxtLink class="btn btn-create" to="post/create"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</NuxtLink>
                <button class="btn btn-import mx-2"><font-awesome-icon :icon="['fas', 'file-import']" class="icon"/>&nbsp;Import</button>
                <button class="btn btn-export" @click="exportCsv"><font-awesome-icon :icon="['fas' ,'file-export']" class="icon"/>&nbsp;Export</button>
            </div>
            <div class="input-group search-input">
                <input type="text" class="form-control" placeholder="search" v-model="searchData">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" aria-describedby="basic-addon2" @click="filter">
                        <font-awesome-icon :icon="['fas', 'magnifying-glass']" class="icon"/>
                    </button>
                </div>
            </div>
        </div>
        <div class="data-list">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>User</th>
                        <th>Categories</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="filterList.value.length > 0">
                    <tr v-for="data in filterList.value" :key="data.id">
                        <td>{{data.id}}</td>
                        <td>{{data.image}}</td>
                        <td>{{data.user.name}}</td>
                        <td v-if="data.categories.length > 1">
                            <span v-for="category in data.categories" :key="category.id" class="categories">{{ category.name }}</span>
                        </td>
                        <td v-else>{{ data.categories[0].name }}</td>
                        <td>{{ data.title }}</td>
                        <td>{{ data.body }}</td>
                        <td>
                            <button class="btn btn-primary btn-edit my-2"><font-awesome-icon :icon="['fas','pen-to-square']" /></button>
                            <button class="btn btn-danger btn-delete mx-2"><font-awesome-icon :icon="['fas', 'trash-can']" /></button>
                            <button class="btn btn-info btn-detail"><font-awesome-icon :icon="['fas', 'circle-info']" class="info-icon" /></button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr><td colspan="7" class="text-center">No data found.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { $fetch } from "ohmyfetch";
    definePageMeta({
        layout: "after-login",
    });
    const posts = ref([])
    const filterList = ref([])
    const searchData = ref()
    const isOpen = ref(false)
    const runtimeConfig = useRuntimeConfig(); 
    const response = await useFetch(runtimeConfig.public.apiBase + '/post/list');
    posts.value = response.data
    filterList.value = posts.value

    async function filter() {
        const response = await useFetch(runtimeConfig.public.apiBase + '/post/search' ,{params:{searchData:searchData.value}});
        filterList.value = response.data
    }

    async function exportCsv()
    {
        await useFetch(runtimeConfig.public.apiBase + '/post/export', {responseType:'blob' }).then((response)=>{
            console.log(response.data)
            const url = window.URL.createObjectURL(new Blob([response.data.value]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download','posts.csv')
            document.body.appendChild(link)
            link.click()
        })
    }
</script>

<style src="../../assets/css/list.css"></style>