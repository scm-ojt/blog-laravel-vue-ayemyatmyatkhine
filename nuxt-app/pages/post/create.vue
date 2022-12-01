<template>
    <div class="container">
        <div v-if="successMessage" class="alert alert-success mt-5 success-alert" role="alert">{{ successMessage }}</div>
        <div class="card create-card my-5">
            <div class="card-header">
                <h4 class="title text-center">Post Create</h4>
            </div>
            <div class="card-body d-flex flex-row">
                <div class="image">
                    <template v-if="preview">
                        <img :src="preview" class="post-img"/>
                    </template>
                    <template v-else>
                        <img src="../../assets/images/image1.webp" alt="" class="post-img">
                    </template>
                </div>
                <form class="form" @submit.prevent="save" enctype="multipart/form-data">
                    <div class="input-item mb-3">
                        <label for="image">Choose Image</label>
                        <input type="file" name="image" accept="image/*" @change="previewImage" class="form-control" id="my-file" ref="imageInput">
                    </div>
                    <div class="input-item mb-3">
                        <label for="category">Select Category</label>
                        <multiselect
                            v-model="category" 
                            mode="tags" 
                            :options="categoryList" 
                            :multiple="true"
                            label="label"   
                            track-by="id" 
                            :close-on-select="true"
                            @input="updateApprovers"
                            name="category"
                            />
                            <span v-if="errorMessage.category" class="required">{{ errorMessage.category[0] }}</span>
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Title</label>
                        <input type="text" class="form-control" v-model="title" name="title">
                        <span v-if="errorMessage.title" class="required">{{ errorMessage.title[0] }}</span>
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Description</label>
                        <textarea id="" class="form-control" rows="4" name="description" v-model="description"></textarea>
                        <span v-if="errorMessage.description" class="required">{{ errorMessage.description[0] }}</span>
                    </div>
                    <div class="input-item">
                        <button class="btn btn-secondary me-3" @click="reset"><font-awesome-icon :icon="['fas' , 'trash-arrow-up']" />&nbsp;Clear</button>
                        <button class="btn btn-primary" type="submit"><font-awesome-icon :icon="['fas' , 'floppy-disk']" />&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted } from "vue"
    import axios from 'axios'
    import { useAuthStore } from '~/store/pinia'
    definePageMeta ({
        layout: "after-login",
    })
    const store = useAuthStore()
    const runtimeConfig = useRuntimeConfig();
    const router = useRouter()
    const categoryList = ref()
    const category = ref()
    const title = ref(null)
    const description = ref(null)
    const preview = ref(null)
    const image = ref(null)
    const imageName = ref(null)
    const successMessage = ref()
    const errorMessage = ref({})
    const getCategories  = async () => {
        await axios.get(runtimeConfig.public.apiBase +'/categories').then((response)=>{
            categoryList.value = response.data
        })  
    }
    onMounted(getCategories)

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

    const selectedcategories = []
    function updateApprovers(category) {
        let approvers = [];
        category.forEach((categoryId) => {
                approvers.push(categoryId)
        })
        selectedcategories.value = approvers
    }  
    
    async function save() { 
        let formData = new FormData()
        if ((selectedcategories != [] && title.value != null && description.value != null) && (imageName.value == null || imageName.value != null)) {
            for(var i =0 ; i< selectedcategories.value.length ; i++){
                formData.append('user_id' , store.userId)
                formData.append('title' , title.value)
                formData.append('description' , description.value)
                formData.append('category[]' , selectedcategories.value[i])
                formData.append('image' , imageName.value)
            }
        }
        await axios.post(runtimeConfig.public.apiBase +"/post/create", formData , {
            headers : {
                'Accept' : 'application/json',
                'Content-Type': 'application/json',
            },
        }).then((response) => {
            successMessage.value = response.data.successMessage
            router.push('/post')
        }).catch((error) => {
            errorMessage.value = error.response.data.errors
        })
    }

    function reset() {
        preview.value = null
        imageName.value = null
        title.value = null
        description.value = null
        selectedcategories.value = []
    }
</script>

<style src="../../assets/css/list.css"></style>

