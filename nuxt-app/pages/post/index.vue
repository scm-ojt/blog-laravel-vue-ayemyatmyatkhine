<template>
    <div class="container mt-5 min-vh-75">
        <div v-if="messages" class="alert alert-success" role="alert">{{ messages }}</div>
        <div class="header mb-5">
            <div class="create-btn">
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
                        <td v-else><img alt="img" :src="imageUrl + `/storage/images/${data.image}`" class="post-img"/></td>
                        <td>{{data.user.name}}</td>
                        <td v-if="data.categories.length > 1">
                            <span v-for="category in data.categories" :key="category.id" class="categories">{{ category.name }}</span>
                        </td>
                        <td v-else>{{ data.categories[0].name }}</td>
                        <td>{{ data.title }}</td>
                        <td>{{ data.body }}</td>
                        <td v-if="store.userId == data.user.id">
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
        <Paginate 
            :page-count="numberOfPages" 
            v-model="page"
            :data="filterList"
            :prev-text="'Prev'" 
            :next-text="'Next'"
            :click-handler="postList">
        </Paginate>
        <fileImportModal></fileImportModal>
    </div>
</template>

<script setup lang="ts">
    import axios from 'axios'
    import { onMounted } from "vue"
    import { useAuthStore } from '~/store/pinia'
    import Paginate from "vuejs-paginate-next"

    definePageMeta({
        layout: "after-login",
    });

    const store = useAuthStore()
    const { $bootstrap } = useNuxtApp()
    const posts = ref([])
    const filterList = ref([])
    const searchData = ref()
    const messages = ref()
    const numberOfPages = ref()
    const page = ref()
    const runtimeConfig = useRuntimeConfig(); 
    const imageUrl = runtimeConfig.public.url
    
    // post list
    const postList = async () => {
        await axios.get(runtimeConfig.public.apiBase +'/post/list?page='+page.value).then((response)=>{
            posts.value = response.data.data
            numberOfPages.value = response.data.last_page
            filterList.value = posts.value
        })
    }
    onMounted(postList)

    console.log("http://127.0.0.1:8000/storage/images/6396b97b2a886_Screenshot2022-10-30092049.png");

    //search post
    async function filter() {
        const response = await axios.get(runtimeConfig.public.apiBase +'/post/search' ,{params:{searchData:searchData.value}});
        filterList.value = response.data
    }

    // export csv file
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

    //delete post
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