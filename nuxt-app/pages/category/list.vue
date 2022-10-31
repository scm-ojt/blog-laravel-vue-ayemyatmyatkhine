<template>
    <div class="container mt-5 d-flex flex-row">
        <!-- create side -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" :aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        <!-- list side -->
        <div class="list-side">
            <div class="header mb-4">
            <div class="create-btn">
                <button type="button" class="btn btn-create" data-toggle="modal" data-target="#exampleModal"><font-awesome-icon :icon="['fas' , 'plus']" class="icon"/>&nbsp;Create</button>
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
                    <tr v-for="data in categories" :key="data.id">
                        <td>{{ data.id }}</td>
                        <td>{{data.name}}</td>
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

<script setup>
     definePageMeta({
        layout: "after-login",
    });
    const runtimeConfig = useRuntimeConfig();   
    const { data: categories } = await useAsyncData('categories', () => $fetch(runtimeConfig.public.apiBase + '/category/list'));
</script>

<style src="../../assets/css/list.css"></style>