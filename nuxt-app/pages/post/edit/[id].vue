<template>
    <div class="container mt-5 min-vh-75">
        <div v-if="successMessage" class="alert alert-success mt-5 success-alert" role="alert">{{ successMessage }}</div>
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
                <form class="form" enctype="multipart/form-data">
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
                        <button class="btn btn-secondary me-3" @click.prevent="reset"><font-awesome-icon :icon="['fas' , 'trash-arrow-up']" />&nbsp;Clear</button>
                        <button class="btn btn-primary" @click.prevent="update"><font-awesome-icon :icon="['fas' , 'floppy-disk']" />&nbsp;Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios'
    import { useAuthStore } from '~/store/pinia'
    const runtimeConfig = useRuntimeConfig()
    const imageUrl = runtimeConfig.public.url
    const store = useAuthStore()
    const router = useRouter()
    const route = useRoute()
    definePageMeta({
        layout: "after-login",
        middleware : ['auth'],
        meta: { requiresAuth: true }
    })
    const categoryList = ref()
    const categories = ref([])
    const preview = ref(null)
    const image = ref(null)
    const imageName = ref('')
    const successMessage = ref()
    const errorMessage = ref()
    const userId = store.userId
    const {data : post} = await axios.get(runtimeConfig.public.apiBase + `/post/edit/${route.params.id}`)

    // bind old categories into multiselect
    for(let i = 0; i < post.categories.length; i++) {
        categories.value.push(post.categories[i].id)
    }
    
    // get category list for multiselect
    const getCategories  = async () => {
        await axios.get(runtimeConfig.public.apiBase + '/categories').then((response)=>{
            categoryList.value = response.data
        })  
    }
    onMounted(getCategories)

    // update selected category
  
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
        if ((categories != [] && post.title != null && post.body != null) && (post.image == null || post.image != null)) {  
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
                formData.append("_method", "put");
            }
        }
        else {
            formData.append("_method", "put");
        }
        await axios.post(runtimeConfig.public.apiBase +`/post/update/${route.params.id}` , formData ,{
            // headers: { "Content-Type": "multipart/form-data" }
        }).then((response)=>{
            successMessage.value = response.data.successMessage
            router.push('/post')
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

    //prevent entering from url 
    watchEffect(() => {
        if (userId != post.user.id) {
            return navigateTo('/post');
        }
    })
</script>

<style src="../../../assets/css/list.css"></style>