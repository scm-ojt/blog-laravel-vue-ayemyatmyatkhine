<template>
    <div class="container mt-5 d-flex flex-row">
        <!-- create side -->
        <div class="create-side">
            <create :category-id="categoryId" :category-name="categoryName" @successMessage="getMessage($event)"/>
        </div>
        <!-- list side -->
        <div class="list-side ms-5">
            <div v-if="messages" class="alert alert-success" role="alert">{{ messages }}</div>
            <div class="header mb-4">
            <div class="create-btn">
                <button type="button" class="btn btn-create" @click="view('null' , 'null')"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</button>
                <button class="btn btn-import mx-2" @click="toggleModal()"><font-awesome-icon :icon="['fas', 'file-import']" class="icon"/>&nbsp;Import</button>
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
                <tbody v-if="filterCategories.length > 0">
                    <tr v-for="item in filterCategories" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{item.name}}</td>
                        <td class="action-btn">
                            <button class="btn btn-primary btn-edit me-2" @click="view(item.id , item.name)"><font-awesome-icon :icon="['fas','pen-to-square']" /></button>
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
        <PaginationComponent class="pagination-component" v-model="currentPage" :numberOfPages="numberOfPage"></PaginationComponent>
        </div>
        <fileImportModal></fileImportModal>
    </div>
</template>

<script setup lang="ts">
    import { Ref , ref } from 'vue'
    import axios  from 'axios'
    import { onMounted } from "vue"
    import { usePagination } from "../composable/useClientSidePagination";
    definePageMeta({
        layout: "after-login",
    });
    const category = ref()
    const categoryId = ref(null)
    const categoryName = ref()
    const categories = ref([])
    // const filterCategories = ref([])
    const filterCategories: Ref<category[]> = ref([]);
    const messages = ref()
    const currentPage = ref(1)
    const rowsPerPage = ref(10)
    const numberOfPage = ref()
    const runtimeConfig = useRuntimeConfig()

    interface category {
        id: number;
        name: string;
    }

    const { paginatedArray , numberOfPages } = usePagination<category>({
        rowsPerPage,
        arrayToPaginate: filterCategories,
        currentPage
    })
    console.log(filterCategories)
    // get categories list
    const getCategories  = async () => {
        await axios.get(runtimeConfig.public.apiBase + `/category/list`).then((response)=> {
            categories.value = response.data.data
            numberOfPage.value = parseInt(response.data.last_page)
            filterCategories.value = categories.value 
        })
    }
    onMounted(getCategories)

    //get success msg from child component
    function getMessage(data) {
        messages.value = data
        setTimeout(() => {
                    messages.value = '';
                }, 2000);
        getCategories()
    }
       
    // create and update components
    async function view(params1 , params2) {
        categoryId.value = params1,
        categoryName.value = params2
    }
    
    //search category
    async function filterCategory(){
        const response = await axios.get(runtimeConfig.public.apiBase + `/category/search` ,{params:{category:category.value}})
        filterCategories.value = response.data
    }

    // export csv file
    async function exportCsv(){
        await axios.get(runtimeConfig.public.apiBase + '/category/export', {responseType:'blob' }).then((response)=>{
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
            await axios.delete(runtimeConfig.public.apiBase + `/category/delete/${id}` ).then((response)=>{
                messages.value = response.data.successMessage
                setTimeout(() => {
                    messages.value = '';
                }, 2000);
            })
        }
        getCategories()
    }

    // file import modal
    const { $bootstrap } = useNuxtApp();
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


<style src="../assets/css/list.css"></style>