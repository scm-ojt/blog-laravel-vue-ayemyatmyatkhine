<template>
    <div class="container mt-5 min-vh-75">
        <div class="header mb-5">
            <div class="create-btn">
                <div v-if="messages" class="alert alert-success" role="alert">{{ messages }}</div>
                <NuxtLink class="btn btn-create" to="post/create"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</NuxtLink>
                <button class="btn btn-import mx-2" @click="toggleModal()"><font-awesome-icon :icon="['fas', 'file-import']" class="icon"/>&nbsp;Import</button>
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
                <tbody v-if="filterList.length > 0">
                    <tr v-for="data in filterList" :key="data.id">
                        <td>{{data.id}}</td>
                        <td v-if="data.image == null || data.image == 'null'"><img src="../../assets/images/image1.webp" alt="" class="post-img"></td>
                        <td v-else><img :src="imageUrl + `/storage/images/${data.image}`" alt="img" class="post-img"/></td>
                        <td>{{data.user.name}}</td>
                        <td v-if="data.categories.length > 1">
                            <span v-for="category in data.categories" :key="category.id" class="categories">{{ category.name }}</span>
                        </td>
                        <td v-else>{{ data.categories[0].name }}</td>
                        <td>{{ data.title }}</td>
                        <td>{{ data.body }}</td>
                        <td v-if="(store.userId == data.user.id)">
                            <NuxtLink class="btn btn-primary btn-edit my-2" :to="`post/edit/${data.id}`"><font-awesome-icon :icon="['fas','pen-to-square']" /></NuxtLink>
                            <button class="btn btn-danger btn-delete mx-2" @click.prevent="deletePost(data.id)"><font-awesome-icon :icon="['fas', 'trash-can']" /></button>
                            <NuxtLink class="btn btn-info btn-detail" :to="`post/${data.id}`"><font-awesome-icon :icon="['fas', 'circle-info']" class="info-icon" /></NuxtLink>
                        </td>
                        <td v-else>
                            <NuxtLink class="btn btn-info btn-detail" :to="`post/${data.id}`"><font-awesome-icon :icon="['fas', 'circle-info']" class="info-icon" /></NuxtLink>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr><td colspan="7" class="text-center">No data found.</td></tr>
                </tbody>
            </table>
        </div>
        <fileImportModal></fileImportModal>
    </div>
</template>

<script setup lang="ts">
    import axios from 'axios'
    import { onMounted } from "vue"
    import { useAuthStore } from '~/store/pinia'
    const store = useAuthStore()
    const { $bootstrap } = useNuxtApp()
    definePageMeta({
        layout: "after-login",
    });
    const posts = ref([])
    const filterList = ref([])
    const searchData = ref()
    const isOpen = ref(false)
    const messages = ref()
    const import_file = ref()
    const loginUser = store.user
    const runtimeConfig = useRuntimeConfig(); 
    const imageUrl = runtimeConfig.public.url
    const postList = async () => {
        await axios.get(runtimeConfig.public.apiBase +'/post/list').then((response)=>{
            posts.value = response.data
            filterList.value = posts.value
        })
    }
    onMounted(postList)

    async function filter() {
        const response = await axios.get(runtimeConfig.public.apiBase +'/post/search' ,{params:{searchData:searchData.value}});
        filterList.value = response.data
    }

    async function exportCsv()
    {
        await axios.get(runtimeConfig.public.apiBase + '/post/export', {responseType:'blob' }).then((response)=>{
            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download','posts.csv')
            document.body.appendChild(link)
            link.click()
        })
    }

    async function deletePost(id){
        if(confirm('Are you sure you want to delete this post?')) {
            await axios.delete(runtimeConfig.public.apiBase + `/post/delete/${id}` , {method:'DELETE'}).then((response)=>{
                messages.value = response.data.successMessage
                setTimeout(() => {
                    messages.value = '';
                }, 2000);
            })
            postList()
        }
    }

    /**file upload modal */
    let modal = null
    function getModal() {
        if (!modal) {
            modal = new $bootstrap.Modal(document.getElementById("exampleModal"));   
        }
        return modal
    }

    function toggleModal() {
        getModal().show()
    }
</script>

<style src="../../assets/css/list.css"></style>