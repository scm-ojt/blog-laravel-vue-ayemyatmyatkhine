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
                <form class="form" @submit.prevent="submit" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="input-item mb-3">
                        <label for="image">Choose Image</label>
                        <input type="file" accept="image/*" @change="previewImage" class="form-control" id="my-file" ref="inputFile">
                    </div>
                    <div class="input-item mb-3">
                        <label for="category">Select Category</label>
                        <multiselect v-model="categories" mode="tags" :options="options" label="name" track-by="id"/>
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
    const runtimeConfig = useRuntimeConfig();
    const categories = []
    const title = ref()
    const description = ref()
    const { data: options } = await useFetch(runtimeConfig.baseURL + '/categories')
    const preview = ref(null)
    const image = ref(null)

    function previewImage(event) {
        var input = event.target;
        if (input.files) {
            var reader = new FileReader();
            reader.onload = (e) => {
                preview.value = e.target.result;
            }
            image.value = input.files[0];
            reader.readAsDataURL(input.files[0]);
        }
    }
    function reset() {
        preview.value = null
        image.value = null
        title.value = null
        description.value = null
        categories.value = []
    }
    async function submit() {
        var token = $('meta[name="csrf-token"]').attr('content');
        let formData = new FormData()
        formData.append('title' , title.value)
        formData.append('description' , description.value)
        formData.append('categories' , categories.value)
        formData.append('image' , image.value)
        return await $fetch('http://127.0.0.1:8000/api/post/create' , {
            method: 'POST',
            body: JSON.stringify(formData),
            headers: {
                'content-type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            
        })
    }
</script>

<style src="../../assets/css/list.css"></style>

