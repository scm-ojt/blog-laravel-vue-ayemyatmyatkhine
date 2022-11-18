<template>
    <div class="container">
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
                        <input type="file" accept="image/*" @change="previewImage" class="form-control" id="my-file" ref="inputFile">
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
                        <input type="text" class="form-control" v-model="title">
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Description</label>
                        <textarea name="" id="" class="form-control" rows="4" v-model="description"></textarea>
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
    import { $fetch } from "ohmyfetch";
    import { onMounted } from "vue";
    const runtimeConfig = useRuntimeConfig();
    const route = useRoute()
    const categoryList = ref()
    const categories = ref()
    const title = ref()
    const description = ref()
    const preview = ref(null)
    const image = ref(null)
    const imageName = ref('')
    const message = ref()
    const getCategories  = async () => {
        await useFetch(runtimeConfig.public.apiBase + '/categories').then((response)=>{
            categoryList.value = response.data.value
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
    function updateApprovers(categories) {
        let approvers = [];
        categories.forEach((category) => {
                approvers.push(category)
        })
        selectedcategories.value = approvers
    }  
    
    async function save() { 
        let formData = new FormData();
        for(var i =0 ; i< selectedcategories.value.length ; i++){
            formData.append('title' , title.value)
            formData.append('description' , description.value)
            formData.append('category[]' , selectedcategories.value[i])
            formData.append('image', imageName.value)
        }
        await $fetch(runtimeConfig.public.apiBase + "/post/create", {
            method: 'POST',
            body : formData
        }).then((response) => {
            message.value = response.successMessage
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

