<template>
    <div class="container mt-5 d-flex flex-row">
        <!-- create side -->
        <div class="create-side">
            <create :is="categoryId ? categoryId : '' " :category-id="categoryId" />
        </div>
        <!-- list side -->
        <div class="list-side ms-5">
            <div class="header mb-4">
            <div class="create-btn">
                <button type="button" class="btn btn-create" @click="view('null')"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</button>
                <button class="btn btn-import mx-2" @click="toggle()"><font-awesome-icon :icon="['fas', 'file-import']" class="icon"/>&nbsp;Import</button>
                <button class="btn btn-export" @click="exportCsv"><font-awesome-icon :icon="['fas' ,'file-export']" class="icon"/>&nbsp;Export</button>
            </div>
            <div class="input-group search-input">
                <input type="text" class="form-control" v-model="category">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" aria-describedby="basic-addon2" @click="filterCategory">
                        <font-awesome-icon :icon="['fas', 'magnifying-glass']" class="icon"/>
                    </button>
                </div>
            </div>
        </div>
        <div class="category-list">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody v-if="filterCategories.value.length > 0">
                    <tr v-for="item in filterCategories.value" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{item.name}}</td>
                        <td class="action-btn">
                            <button class="btn btn-primary btn-edit me-2" @click="view(item.id)"><font-awesome-icon :icon="['fas','pen-to-square']" /></button>
                            <button class="btn btn-danger btn-delete" @click="deleteCategory(item.id)"><font-awesome-icon :icon="['fas', 'trash-can']" /></button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                       <td colspan="3" class="text-center">No data found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <fileImportModal></fileImportModal>
    </div>
</template>

<script setup lang="ts">
    import { $fetch } from "ohmyfetch";
    import { ref } from 'vue'
    import type { Modal } from "bootstrap";
    definePageMeta({
        layout: "after-login",
    });
    const category = ref()
    const categoryId = ref()
    const categories = ref([])
    const filterCategories = ref([])
    const messages = ref()
    const runtimeConfig = useRuntimeConfig()
    const response  = await useFetch(runtimeConfig.public.apiBase + '/category/list')
    categories.value = response.data    
    filterCategories.value = categories.value

    // create and update components
    function view(params) {
        categoryId.value = params
    }

    //search category
    async function filterCategory(){
        const response = await useFetch(runtimeConfig.public.apiBase + '/category/search' ,{params:{category:category.value}})
        filterCategories.value = response.data
    }

    // export csv file
    async function exportCsv(){
        await useFetch(runtimeConfig.public.apiBase + '/category/export', {responseType:'blob' }).then((response)=>{
            const url = window.URL.createObjectURL(new Blob([response.data.value]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download','category.csv')
            document.body.appendChild(link)
            link.click()
        })
    }
    // delete category
    async function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            await $fetch(runtimeConfig.public.apiBase + `/category/delete/${id}` , {method:'DELETE'}).then((response)=>{
                messages.value = response.successMessage
            })
        }
        window.location.reload(true)
    }

    // file import modal
    const { $bootstrap } = useNuxtApp();
    let modal: Modal;
    onMounted(() => {
        modal = new $bootstrap.Modal(document.getElementById("exampleModal"));
    });
    const toggle = () => {
        modal.toggle();
    };
</script>


<style src="../assets/css/list.css"></style>