<script setup>
    definePageMeta({
        layout: "after-login",
    });
    const runtimeConfig = useRuntimeConfig()
    const { data : categories} = await useFetch(runtimeConfig.baseURL + '/category/list')
</script>

<template>
    <div class="container mt-5 d-flex flex-row">
        <!-- create side -->
        <div class="create-side">
            <component :is="component ? create : edit" />
        </div>
        <!-- list side -->
        <div class="list-side">
            <div class="header mb-4">
            <div class="create-btn">
                <button type="button" class="btn btn-create" @click="component = create"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</button>
                <button class="btn btn-import mx-2"><font-awesome-icon :icon="['fas', 'file-import']" class="icon"/>&nbsp;Import</button>
                <button class="btn btn-export"><font-awesome-icon :icon="['fas' ,'file-export']" class="icon"/>&nbsp;Export</button>
            </div>
            <div class="input-group search-input">
                <input type="text" class="form-control" value="search">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" aria-describedby="basic-addon2">
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
                            <button class="btn btn-primary btn-edit me-2"><font-awesome-icon :icon="['fas','pen-to-square']" /></button>
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

<style src="../assets/css/list.css"></style>