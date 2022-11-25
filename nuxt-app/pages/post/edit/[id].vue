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
                        <img v-if="post.image != null || post.image != 'null'" :src="imageUrl + `/storage/images/${post.image}`" alt="" class="post-img" />
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
                            name="category"
                        />
                        <span v-if="errorMessage" class="required">{{ errorMessage.category[0] }}</span>
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Title</label>
                        <input type="text" class="form-control" v-model="post.title" name="title">
                        <span v-if="errorMessage" class="required">{{ errorMessage.title[0] }}</span>
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="" class="form-control" rows="4" v-model="post.body"></textarea>
                        <span v-if="errorMessage" class="required">{{ errorMessage.description[0] }}</span>
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
    import axios from 'axios'
    import { $fetch } from "ohmyfetch";
    const runtimeConfig = useRuntimeConfig();
    const imageUrl = runtimeConfig.public.url
    const route = useRoute()
    const categoryList = ref()
    const categories = ref([])
    const preview = ref(null)
    const image = ref(null)
    const imageName = ref('')
    const successMessage = ref()
    const errorMessage = ref()
    const {data : post} = await axios.get(`http://127.0.0.1:8000/api/post/edit/${route.params.id}`)

    // bind old categories into multiselect
    let i = 0
    for(i = 0; i < post.categories.length; i++) {
        categories.value.push(post.categories[i].id)
    }
    
    // get category list for multiselect
    const getCategories  = async () => {
        await axios.get('http://127.0.0.1:8000/api/categories').then((response)=>{
            categoryList.value = response.data
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
            formData.append('title' , post.title)
            formData.append('description' , post.body)
            formData.append('category[]' , categories.value[i])
            if(post.image != null) { 
                if(imageName.value == ''){
                    formData.append('image' , post.image)
                }
                else {
                    formData.append('image' , imageName.value)
                }
            }
            else {
                formData.append('image' , imageName.value)
            }   
        }
        // const updateData = {
        //     title: post.title,
        //     description: post.body,
        //     category: categories.value,
        //     image:post.image
        // }
        await axios.put(`http://127.0.0.1:8000/api/post/update/${route.params.id}` , {
            title: post.title,
            description: post.body,
            category: categories.value,
            image:post.image,
            headers : {
                'Content-Type': 'multipart/form-data',
            }
        }).then((response)=>{
            successMessage.value = response.data.successMessage
        }).catch((error)=>{
            errorMessage.value = error.response.data.errors
        })
    }

    function reset() {
        preview.value = null
        imageName.value = null
        post.title = null
        post.body = null
        categories.value = []
    }
</script>

<style src="../../../assets/css/list.css"></style>