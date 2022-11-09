<template>
    <div class="container mt-5 d-flex flex-row">
        <!-- create side -->
        <div class="create-side">
            <create v-if="page === 'create'" />
            <edit v-if="page === 'edit'" />
        </div>
        <!-- list side -->
        <div class="list-side ms-5">
            <div class="header mb-4">
            <div class="create-btn">
                <button type="button" class="btn btn-create" @click="view('create')"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</button>
                <button class="btn btn-import mx-2"><font-awesome-icon :icon="['fas', 'file-import']" class="icon"/>&nbsp;Import</button>
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
                <tbody v-if="categories.length > 0">
                    <tr v-for="item in categories" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{item.name}}</td>
                        <td class="action-btn">
                            <button class="btn btn-primary btn-edit me-2" @click="view('edit')"><font-awesome-icon :icon="['fas','pen-to-square']" /></button>
                            <button class="btn btn-danger btn-delete"><font-awesome-icon :icon="['fas', 'trash-can']" /></button>
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
    </div>
</template>

<script setup>
    definePageMeta({
        layout: "after-login",
    });
    const category = ref()
    const page = ref('create')
    const runtimeConfig = useRuntimeConfig()
    const { data : categories} = await useFetch(runtimeConfig.public.apiBase + '/category/list')
    function view(name) {
        page.value = name
    }
    async function filterCategory(){
        const response = await useFetch(runtimeConfig.public.apiBase + '/category/search' ,{params:{category:category.value}})
        categories.value = response.data
        console.log(categories.value)
    }
    async function exportCsv(){
        await useFetch(runtimeConfig.public.apiBase + '/category/export', {responseType:'blob' }).then((response)=>{
            console.log(response.data)
            const url = window.URL.createObjectURL(new Blob([response.data.value]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download','category.csv')
            document.body.appendChild(link)
            link.click()
        })
    }

</script>


<style src="../assets/css/list.css"></style>