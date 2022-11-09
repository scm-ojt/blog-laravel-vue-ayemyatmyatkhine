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
                <form class="form" @submit.prevent="save">
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
    const categoryList = ref()
    const categories = ref([])
    const title = ref()
    const description = ref()
    const preview = ref(null)
    const image = ref(null)
    const message = ref()
    const getCategories  = async () => {
        await useFetch(runtimeConfig.public.apiBase + '/categories').then((response)=>{
            categoryList.value = response.data.value
        })  
    }
    onMounted(getCategories)

    // function optionSelected(option, id) {
    //     categories.value.push(categoryList[option][value])
    // }
    
    // function onSelect(value) {
    //     categories.value.push(categories)
    //     console.log(categories)
    // }

    function updateApprovers(categories) {
        let approvers = [];
        categories.forEach((category) => {
                approvers.push(category);
        });
        categories.value = approvers;
        console.log(categories)
    }

    var reader = new FileReader();
    function previewImage(event) {
        var input = event.target;
        if (input.files) {
            reader.onload = (e) => {
                preview.value = e.target.result;
            }
            image.value = input.files[0];
            image.value = reader.readAsDataURL(input.files[0]);
            imageUrl.value = URL.createObjectURL(input.files[0])
        }
    }
    
    async function save() {
        // let formData = new FormData()
        // formData.append('title' , title.value)
        // formData.append('description' , description.value)
        // formData.append('category' , categories)
        // formData.append('image' , image.value)
        await $fetch(runtimeConfig.public.apiBase + "/post/create", {
            method: 'POST',
            body: {
                title : title.value,
                description: description.value,
                category: categories,
                image: image.value
            }
        }).then((response) => {
            message.value = response.successMessage
        })
    }
    function reset() {
        preview.value = null
        image.value = null
        title.value = null
        description.value = null
        categories = []
    }
</script>

<style src="../../assets/css/list.css"></style>

