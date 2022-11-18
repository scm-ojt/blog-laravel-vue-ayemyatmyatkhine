<template>
    <div class="container mt-5 min-vh-75">
        <div class="card create-card my-5">
            <div class="card-header">
                <h4 class="title text-center">Post Edit</h4>
            </div>
            <div class="card-body d-flex flex-row">
                <div class="image">
                    <template v-if="preview">
                        <img :src="preview" class="post-img"/>
                    </template>
                    <template v-else>
                        <img v-if="post.image != null" :src="imageUrl + `/storage/images/${post.image}`" alt="" class="post-img" />
                        <img v-else src="../../../assets/images/image1.webp" alt="" class="post-img" />
                    </template>
                </div>
                <form class="form" @submit.prevent="update" enctype="multipart/form-data">
                    <div class="input-item mb-3">
                        <label for="image">Choose Image</label>
                        <input type="hidden" v-model="post.image">
                        <input type="file" accept="image/*" v-on:change="previewImage" class="form-control" id="my-file" ref="inputFile">
                    </div>
                    <div class="input-item mb-3">
                        <label for="category">Select Category</label>
                        <multiselect
                            v-model="categories" 
                            mode="tags" 
                            :options="categoryList"     
                            :multiple="true"
                            label="label"   
                            track-by="id" 
                            :close-on-select="true"
                            @input="updateApprovers"
                        />
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Title</label>
                        <input type="text" class="form-control" v-model="post.title">
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Description</label>
                        <textarea name="" id="" class="form-control" rows="4" v-model="post.body"></textarea>
                    </div>
                    <div class="input-item">
                        <button class="btn btn-secondary me-3" @click="reset"><font-awesome-icon :icon="['fas' , 'trash-arrow-up']" />&nbsp;Clear</button>
                        <button class="btn btn-primary" type="submit"><font-awesome-icon :icon="['fas' , 'floppy-disk']" />&nbsp;Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { exportDefaultSpecifier } from "@babel/types";
import { $fetch } from "ohmyfetch";
    const runtimeConfig = useRuntimeConfig();
    const imageUrl = runtimeConfig.public.url
    const route = useRoute()
    const categoryList = ref()
    const categories = ref([])
    const preview = ref(null)
    const image = ref(null)
    const imageName = ref('')
    const message = ref()
    const {data : post} = await useFetch(runtimeConfig.public.apiBase + `/post/edit/${route.params.id}`)

    // bind old categories into multiselect
    let i = 0
    for(i = 0; i < post.value.categories.length; i++) {
        categories.value.push(post.value.categories[i].id)
    }
    
    // get category list for multiselect
    const getCategories  = async () => {
        await useFetch(runtimeConfig.public.apiBase + '/categories').then((response)=>{
            categoryList.value = response.data.value
        })  
    }
    onMounted(getCategories)

    // update selected category
    const selectedcategories = []
    function updateApprovers(categories) {
        let approvers = [];
        categories.forEach((category) => {
                approvers.push(category);
        });
        categories.value = approvers;
    }

    // preview image
    function previewImage(event) {
        var reader = new FileReader();
        var input = event.target;
        if (input.files) {
            reader.onload = (e) => {
                preview.value = e.target.result;
            }
            image.value = reader.readAsDataURL(input.files[0])
        }
        imageName.value = event.target.files[0]
    }
    
    // update post
    async function update() {
        let formData = new FormData()  
        for(var i = 0; i < categories.value.length ; i++) {
            formData.append('title' , post.value.title)
            formData.append('description' , post.value.body)
            formData.append('category[]' , categories.value[i])
            if(post.value.image != null) { 
                if(imageName.value == ''){
                    formData.append('image' , post.value.image)
                }
                else {
                    formData.append('image' , imageName.value)
                }
            }
            else {
                formData.append('image' , imageName.value)
            }
            formData.append('_method', 'PUT');
        }
        await $fetch(runtimeConfig.public.apiBase + `/post/update/${route.params.id}` , {
            method : "POST",
            body : formData
        })
    }

    function reset() {
        preview.value = null
        imageName.value = null
        post.value.title = null
        post.value.body = null
        categories.value = []
    }
</script>

<style src="../../../assets/css/list.css"></style>